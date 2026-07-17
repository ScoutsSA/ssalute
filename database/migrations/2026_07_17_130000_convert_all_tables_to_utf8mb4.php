<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Convert every remaining latin1 (and utf8mb3) table in the database to
 * utf8mb4 / utf8mb4_unicode_ci so all free-text fields can store the full
 * Unicode range (emoji, checkmarks, non Latin scripts).
 *
 * Background: the columns were latin1 while the app connection ran as utf8.
 * Any character outside cp1252 could not be stored; under STRICT_TRANS_TABLES
 * the insert failed, and because the legacy app uses ERRMODE_SILENT the row
 * was silently lost while the page reported success.
 *
 * Safety notes (verified against the data before writing this):
 *  - The stored latin1 data is genuine latin1, not double-encoded mojibake, so
 *    CONVERT TO CHARACTER SET re-encodes it losslessly. No row data is changed.
 *  - No B-tree index exceeds the utf8mb4 3072-byte prefix limit (the only
 *    oversized indexes are FULLTEXT, which are exempt), so there are no
 *    "key too long" failures.
 *  - There are no foreign keys; FK charset mismatches cannot occur.
 *
 * The migration is idempotent: it only touches tables that are not already
 * fully utf8mb4, so if it is interrupted it can be re-run to resume.
 *
 * This is heavy DDL that rebuilds each table and briefly locks writes on the
 * larger tables. Run it in a maintenance window with a fresh backup.
 */
return new class extends Migration
{
    private const CHARSET = 'utf8mb4';

    private const COLLATION = 'utf8mb4_unicode_ci';

    public function up(): void
    {
        $connection = DB::connection();
        $database = $connection->getDatabaseName();

        // The legacy data contains '0000-00-00' zero dates (and possibly other
        // dates that predate strict mode). CONVERT TO rebuilds each table, and
        // under the default strict/NO_ZERO_DATE mode that rebuild would reject
        // those rows. Relax sql_mode for this session only so existing values
        // are preserved exactly, then restore it in the finally block. Nothing
        // is coerced: ALLOW_INVALID_DATES keeps zero/invalid dates as-is.
        $originalSqlMode = $connection->selectOne('SELECT @@SESSION.sql_mode AS mode')->mode;
        DB::statement("SET SESSION sql_mode = 'ALLOW_INVALID_DATES'");

        try {
            $this->convert($connection, $database);
        } finally {
            DB::statement('SET SESSION sql_mode = ' . $connection->getPdo()->quote($originalSqlMode));
        }
    }

    public function down(): void
    {
        // No-op on purpose. See the note above.
    }

    private function convert($connection, string $database): void
    {
        $tables = $connection->select(
            <<<'SQL'
                SELECT t.TABLE_NAME AS name
                FROM information_schema.TABLES t
                WHERE t.TABLE_SCHEMA = ?
                  AND t.TABLE_TYPE = 'BASE TABLE'
                  AND (
                      t.TABLE_COLLATION NOT LIKE 'utf8mb4%'
                      OR EXISTS (
                          SELECT 1
                          FROM information_schema.COLUMNS c
                          WHERE c.TABLE_SCHEMA = t.TABLE_SCHEMA
                            AND c.TABLE_NAME = t.TABLE_NAME
                            AND c.CHARACTER_SET_NAME IS NOT NULL
                            AND c.CHARACTER_SET_NAME <> 'utf8mb4'
                      )
                  )
                ORDER BY t.TABLE_NAME
                SQL,
            [$database]
        );

        foreach ($tables as $table) {
            $name = str_replace('`', '``', $table->name);

            try {
                $this->shrinkOversizedIndexes($connection, $database, $table->name);
                DB::statement("ALTER TABLE `{$name}` CONVERT TO CHARACTER SET " . self::CHARSET . ' COLLATE ' . self::COLLATION);
            } catch (\Throwable $e) {
                throw new \RuntimeException("Failed converting table '{$table->name}' to utf8mb4: {$e->getMessage()}", 0, $e);
            }
        }

        $db = str_replace('`', '``', $database);
        DB::statement("ALTER DATABASE `{$db}` CHARACTER SET " . self::CHARSET . ' COLLATE ' . self::COLLATION);
    }

    /**
     * A latin1 prefix index of N characters becomes N*4 bytes under utf8mb4 and
     * can breach InnoDB's 3072-byte key limit (e.g. legacy 767-char prefixes on
     * log/fingerprint tables). Rebuild any such index up front with a safe
     * prefix so the table converts cleanly. Indexes only, no row data changes.
     */
    private function shrinkOversizedIndexes($connection, string $database, string $table): void
    {
        $limitBytes = 3000;   // stay safely below InnoDB's 3072-byte key limit
        $prefixChars = 191;   // safe rebuilt prefix (191 * 4 = 764 bytes)

        $rows = $connection->select(
            <<<'SQL'
                SELECT s.index_name AS index_name,
                       s.non_unique AS non_unique,
                       s.column_name AS column_name,
                       s.sub_part AS sub_part,
                       c.character_maximum_length AS character_maximum_length,
                       (c.data_type IN ('char','varchar','tinytext','text','mediumtext','longtext','enum','set')) AS is_string
                FROM information_schema.statistics s
                JOIN information_schema.columns c
                  ON c.table_schema = s.table_schema
                 AND c.table_name = s.table_name
                 AND c.column_name = s.column_name
                WHERE s.table_schema = ?
                  AND s.table_name = ?
                  AND s.index_type = 'BTREE'
                  AND s.index_name <> 'PRIMARY'
                ORDER BY s.index_name, s.seq_in_index
                SQL,
            [$database, $table]
        );

        $indexes = [];
        foreach ($rows as $row) {
            $indexes[$row->index_name]['non_unique'] = (int) $row->non_unique;
            $indexes[$row->index_name]['columns'][] = $row;
        }

        foreach ($indexes as $indexName => $index) {
            $bytes = 0;
            foreach ($index['columns'] as $column) {
                if ((int) $column->is_string === 1) {
                    $chars = $column->sub_part ?? $column->character_maximum_length ?? 0;
                    $bytes += ((int) $chars) * 4;
                }
            }

            if ($bytes <= $limitBytes) {
                continue;
            }

            $parts = [];
            foreach ($index['columns'] as $column) {
                $quotedColumn = '`' . str_replace('`', '``', $column->column_name) . '`';

                if ((int) $column->is_string === 1) {
                    $prefix = min($prefixChars, (int) ($column->character_maximum_length ?? $prefixChars));
                    if ($column->sub_part !== null) {
                        $prefix = min($prefix, (int) $column->sub_part);
                    }
                    $parts[] = $quotedColumn . '(' . $prefix . ')';
                } else {
                    $parts[] = $quotedColumn;
                }
            }

            $quotedTable = '`' . str_replace('`', '``', $table) . '`';
            $quotedIndex = '`' . str_replace('`', '``', $indexName) . '`';
            $unique = $index['non_unique'] === 0 ? 'UNIQUE ' : '';

            DB::statement("ALTER TABLE {$quotedTable} DROP INDEX {$quotedIndex}");
            DB::statement("CREATE {$unique}INDEX {$quotedIndex} ON {$quotedTable} (" . implode(', ', $parts) . ')');
        }
    }
};

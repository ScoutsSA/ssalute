<?php

namespace App\Sync\Anonymizers\Concerns;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

trait ScrubsColumns
{
    /**
     * Overwrite the given columns on every row with constant values in a single
     * UPDATE. A missing table and missing columns are skipped, so it stays safe
     * against a snapshot whose schema has drifted. Use this when the replacement
     * does not need to differ per row (blanking free text, wiping credentials).
     *
     * @param  array<string, mixed>  $values  column => literal replacement
     */
    protected function bulkScrub(string $connection, string $table, array $values): void
    {
        $present = $this->presentColumns($connection, $table, array_keys($values));

        if ($present === []) {
            return;
        }

        DB::connection($connection)
            ->table($table)
            ->update(array_intersect_key($values, array_flip($present)));
    }

    /**
     * Overwrite columns one row at a time, deriving each value from the row, so a
     * replacement can stay unique per member (emails, usernames, id numbers). A
     * missing table, missing columns, and a missing key column are each a no-op.
     * Query-builder only, so it works on MySQL, PostgreSQL and SQLite.
     *
     * @param  array<int, string>  $candidateColumns
     * @param  Closure(string $column, object $row): mixed  $value
     */
    protected function perRowScrub(string $connection, string $table, array $candidateColumns, Closure $value, string $key = 'id'): void
    {
        $present = $this->presentColumns($connection, $table, $candidateColumns);

        if ($present === [] || ! Schema::connection($connection)->hasColumn($table, $key)) {
            return;
        }

        DB::connection($connection)
            ->table($table)
            ->orderBy($key)
            ->chunkById(500, function ($rows) use ($connection, $table, $present, $value, $key): void {
                foreach ($rows as $row) {
                    $update = [];

                    foreach ($present as $column) {
                        $update[$column] = $value($column, $row);
                    }

                    DB::connection($connection)->table($table)->where($key, $row->{$key})->update($update);
                }
            }, $key);
    }

    /**
     * The subset of the requested columns that actually exist on the table.
     *
     * A missing table or missing columns are skipped rather than failing, so a
     * drifted snapshot still syncs, but each gap is logged as a warning: a column
     * an anonymizer expects to scrub but cannot find is the signal that the map has
     * fallen out of step with the schema and should be revisited.
     *
     * @param  array<int, string>  $columns
     * @return array<int, string>
     */
    protected function presentColumns(string $connection, string $table, array $columns): array
    {
        $schema = Schema::connection($connection);

        if (! $schema->hasTable($table)) {
            Log::warning('sync.anonymizer.table_missing', [
                'anonymizer' => static::class,
                'connection' => $connection,
                'table' => $table,
            ]);

            return [];
        }

        $present = array_values(array_intersect($columns, $schema->getColumnListing($table)));
        $absent = array_values(array_diff($columns, $present));

        if ($absent !== []) {
            Log::warning('sync.anonymizer.columns_missing', [
                'anonymizer' => static::class,
                'connection' => $connection,
                'table' => $table,
                'columns' => $absent,
            ]);
        }

        return $present;
    }
}

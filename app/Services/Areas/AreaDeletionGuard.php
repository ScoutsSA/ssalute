<?php

namespace App\Services\Areas;

use App\Exceptions\AreaStillReferencedException;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Refuses to delete an area while any table in the legacy schema still references it.
 *
 * Log tables listed in AreaReferenceMap::NON_BLOCKING_TABLES are skipped: orphaned log rows are harmless and
 * the largest of them has no index on the area columns, so counting it would scan the whole table.
 */
class AreaDeletionGuard
{
    /** @var array<string, array<string, array{rows: int, columns: array<string, int>}>> */
    private array $memo = [];

    /**
     * Human readable summary such as "Districts: 12, Groups: 340, Role attachments: 3".
     *
     * @param  array<string, int>  $blockers
     */
    public static function describe(array $blockers, int $limit = 10): string
    {
        $parts = [];

        foreach (array_slice($blockers, 0, $limit, true) as $table => $count) {
            $parts[] = AreaReferenceMap::label($table) . ": {$count}";
        }

        $remaining = count($blockers) - count($parts);

        if ($remaining > 0) {
            $parts[] = "and {$remaining} more";
        }

        return implode(', ', $parts);
    }

    private static function memoKey(Region|District|Group $record): string
    {
        return $record::class . ':' . $record->getKey();
    }

    /**
     * Tables that reference the record, table => number of rows that do so. Empty when the record is deletable.
     *
     * One query per blocking table. A table with a single referencing column is a plain indexed count; a table
     * with several gets one query that returns the row total and a count per column, so a row pointing at the
     * area in two columns is one row here and one reference per column in referencesFor(). The result is
     * memoised per record for the lifetime of the guard instance, which is a singleton, so the View page, its
     * linked record tabs and the delete modal share one pass of queries.
     *
     * @return array<string, int>
     */
    public function blockersFor(Region|District|Group $record): array
    {
        return array_map(fn (array $entry): int => $entry['rows'], $this->tablesFor($record));
    }

    /**
     * Every column that references the record, table => column => row count. Served from the same memo.
     *
     * @return array<string, array<string, int>>
     */
    public function referencesFor(Region|District|Group $record): array
    {
        return array_map(fn (array $entry): array => $entry['columns'], $this->tablesFor($record));
    }

    /**
     * Rows in one table whose given column references the record. Served from the memo.
     */
    public function countFor(Region|District|Group $record, string $table, string $column): int
    {
        return $this->tablesFor($record)[$table]['columns'][$column] ?? 0;
    }

    public function isDeletable(Region|District|Group $record): bool
    {
        return $this->tablesFor($record) === [];
    }

    public function assertDeletable(Region|District|Group $record): void
    {
        $blockers = $this->blockersFor($record);

        if ($blockers === []) {
            return;
        }

        throw AreaStillReferencedException::for($record, $blockers);
    }

    public function forget(Region|District|Group $record): void
    {
        unset($this->memo[self::memoKey($record)]);
    }

    /**
     * @return array<string, array{rows: int, columns: array<string, int>}>
     */
    private function tablesFor(Region|District|Group $record): array
    {
        $memoKey = self::memoKey($record);

        if (array_key_exists($memoKey, $this->memo)) {
            return $this->memo[$memoKey];
        }

        $tables = [];

        foreach (AreaReferenceMap::blockingFor($record::class) as $table => $columns) {
            $entry = $this->countReferences($table, $columns, (int) $record->getKey());

            if ($entry['rows'] > 0) {
                $tables[$table] = $entry;
            }
        }

        return $this->memo[$memoKey] = $tables;
    }

    /**
     * @param  list<string>  $columns
     * @return array{rows: int, columns: array<string, int>}
     */
    private function countReferences(string $table, array $columns, int $id): array
    {
        $query = DB::connection(AppServiceProvider::DB_SD_CORE)->table($table);

        if (count($columns) === 1) {
            $rows = $query->where($columns[0], $id)->count();

            return ['rows' => $rows, 'columns' => $rows > 0 ? [$columns[0] => $rows] : []];
        }

        $grammar = $query->getGrammar();
        $selects = ['COUNT(*) AS rows_total'];
        $bindings = [];

        foreach ($columns as $index => $column) {
            $selects[] = 'SUM(' . $grammar->wrap($column) . " = ?) AS column_{$index}";
            $bindings[] = $id;
        }

        $result = $query
            ->selectRaw(implode(', ', $selects), $bindings)
            ->where(function (Builder $query) use ($columns, $id): void {
                foreach ($columns as $column) {
                    $query->orWhere($column, $id);
                }
            })
            ->first();

        $perColumn = [];

        foreach ($columns as $index => $column) {
            $count = (int) ($result->{"column_{$index}"} ?? 0);

            if ($count > 0) {
                $perColumn[$column] = $count;
            }
        }

        return ['rows' => (int) ($result->rows_total ?? 0), 'columns' => $perColumn];
    }
}

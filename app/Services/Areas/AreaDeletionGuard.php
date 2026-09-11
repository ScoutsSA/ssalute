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
 */
class AreaDeletionGuard
{
    /** @var array<string, array<string, int>> */
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

    /**
     * Tables that reference the record, table => row count. Empty when the record is deletable.
     *
     * The result is memoised per record for the lifetime of the guard instance, which is a
     * singleton, so the View page and its relation manager tabs share one pass of queries.
     *
     * @return array<string, int>
     */
    public function blockersFor(Region|District|Group $record): array
    {
        $memoKey = $record::class . ':' . $record->getKey();

        if (array_key_exists($memoKey, $this->memo)) {
            return $this->memo[$memoKey];
        }

        $blockers = [];

        foreach (AreaReferenceMap::for($record::class) as $table => $columns) {
            $count = $this->countReferences($table, $columns, (int) $record->getKey());

            if ($count > 0) {
                $blockers[$table] = $count;
            }
        }

        return $this->memo[$memoKey] = $blockers;
    }

    public function isDeletable(Region|District|Group $record): bool
    {
        return $this->blockersFor($record) === [];
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
        unset($this->memo[$record::class . ':' . $record->getKey()]);
    }

    /**
     * @param  list<string>  $columns
     */
    private function countReferences(string $table, array $columns, int $id): int
    {
        return DB::connection(AppServiceProvider::DB_SD_CORE)
            ->table($table)
            ->where(function (Builder $query) use ($columns, $id): void {
                foreach ($columns as $column) {
                    $query->orWhere($column, $id);
                }
            })
            ->count();
    }
}

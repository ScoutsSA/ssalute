<?php

namespace App\Services\SystemFixes;

use App\Models\AdvancementCub;
use App\Models\AdvancementMeerkat;
use App\Models\AdvancementRover;
use App\Models\AdvancementScout;
use App\Models\BadgesCub;
use App\Models\BadgesMeerkat;
use App\Models\BadgesRover;
use App\Models\BadgesScout;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Ensures the two member-reference columns on youth badge and advancement tables agree.
 *
 * Each of these tables carries a generic `userID` alongside a section-specific member column
 * (`scoutID`, `cubID`, `roverID`, `meerkatID`). Both are meant to hold the same system_users id,
 * but different screens read different columns, so when one is populated and the other is left NULL
 * the record silently drops out of any report that joins on the empty column. (A Scout badge with a
 * NULL `userID`, for example, vanishes from the Advancements & Badges detail even though it is still
 * counted in that report's summary.)
 *
 * The invariant, per row: if either column is set, the other must equal it.
 *   - exactly one column set  -> the NULL column is backfilled from the set one (auto-fixed);
 *   - both set but different   -> left untouched and raised for admin attention;
 *   - both NULL                -> already consistent (nothing to attribute), ignored.
 *
 * Writes go through the query builder rather than Eloquent on purpose: this is a surgical backfill of
 * two id columns across hundreds of thousands of historical rows, so it must not stamp `modified` or
 * emit an audit row per record.
 */
class EnsureYouthMemberIdsAreInSync implements SystemFix
{
    /**
     * Cap on the number of conflicts rendered into the Slack alert. Every conflict is logged
     * individually regardless, so the full set is always recoverable; this only keeps the body readable.
     */
    private const ALERT_SAMPLE_LIMIT = 25;

    /**
     * Youth record models mapped to their section-specific member column. The generic `userID`
     * column is the counterpart on every one of them.
     *
     * @var array<class-string<Model>, string>
     */
    private const TABLES = [
        BadgesMeerkat::class => 'meerkatID',
        AdvancementMeerkat::class => 'meerkatID',
        BadgesCub::class => 'cubID',
        AdvancementCub::class => 'cubID',
        BadgesScout::class => 'scoutID',
        AdvancementScout::class => 'scoutID',
        BadgesRover::class => 'roverID',
        AdvancementRover::class => 'roverID',
    ];

    public function label(): string
    {
        return 'Ensure youth badge and advancement records have matching member ids';
    }

    public function settingKey(): string
    {
        return 'ensure_youth_member_ids_are_in_sync_enabled';
    }

    public function notificationSettingKey(): string
    {
        return 'ensure_youth_member_ids_are_in_sync_notifications';
    }

    public function run(): SystemFixResult
    {
        /** @var list<string> $changes */
        $changes = [];
        /** @var Collection<int, string> $conflicts */
        $conflicts = collect();
        $rowsSynced = 0;

        foreach (self::TABLES as $modelClass => $youthColumn) {
            $table = (new $modelClass)->getTable();

            $filledUser = $this->backfill($table, 'userID', $youthColumn);
            if ($filledUser > 0) {
                $rowsSynced += $filledUser;
                $changes[] = sprintf('%s: set userID from %s on %s.', $table, $youthColumn, $this->rowLabel($filledUser));
            }

            $filledYouth = $this->backfill($table, $youthColumn, 'userID');
            if ($filledYouth > 0) {
                $rowsSynced += $filledYouth;
                $changes[] = sprintf('%s: set %s from userID on %s.', $table, $youthColumn, $this->rowLabel($filledYouth));
            }

            $conflicts = $conflicts->merge($this->conflicts($table, $youthColumn));
        }

        return new SystemFixResult(
            $this->label(),
            $this->summarise($rowsSynced, $conflicts->count()),
            $changes,
            $this->sampleForAlert($conflicts),
        );
    }

    /**
     * Copy the set source column into the NULL target column, for the rows that need it only.
     * Returns the number of rows changed.
     */
    private function backfill(string $table, string $targetColumn, string $sourceColumn): int
    {
        return $this->connection()
            ->table($table)
            ->whereNull($targetColumn)
            ->whereNotNull($sourceColumn)
            ->update([$targetColumn => DB::raw("`{$sourceColumn}`")]);
    }

    /**
     * Rows where both columns are set but disagree: two different member ids on one record, which the
     * fix cannot safely resolve on its own. Each is logged and turned into an admin-attention line.
     *
     * @return Collection<int, string>
     */
    private function conflicts(string $table, string $youthColumn): Collection
    {
        return $this->connection()
            ->table($table)
            ->whereNotNull('userID')
            ->whereNotNull($youthColumn)
            ->whereColumn('userID', '!=', $youthColumn)
            ->orderBy('id')
            ->get(['id', 'userID', $youthColumn])
            ->map(function (object $row) use ($table, $youthColumn): string {
                Log::warning('system_fix.youth_member_ids.conflict', [
                    'fix' => static::class,
                    'table' => $table,
                    'row_id' => (int) $row->id,
                    'user_id' => (int) $row->userID,
                    $youthColumn => (int) $row->{$youthColumn},
                ]);

                return sprintf(
                    '%s #%d: userID %d and %s %d disagree; left unchanged for review.',
                    $table,
                    (int) $row->id,
                    (int) $row->userID,
                    $youthColumn,
                    (int) $row->{$youthColumn},
                );
            });
    }

    private function summarise(int $rowsSynced, int $conflictCount): string
    {
        if ($rowsSynced === 0 && $conflictCount === 0) {
            return 'All youth badge and advancement records already have matching member ids.';
        }

        $parts = [];

        if ($rowsSynced > 0) {
            $parts[] = sprintf('synced %d %s', $rowsSynced, Str::plural('record', $rowsSynced));
        }

        if ($conflictCount > 0) {
            $parts[] = sprintf('%d %s need review', $conflictCount, Str::plural('conflict', $conflictCount));
        }

        return Str::ucfirst(implode('; ', $parts)) . '.';
    }

    /**
     * The alert body is capped for readability; when there are more conflicts, a final line points at the logs.
     *
     * @param  Collection<int, string>  $conflicts
     * @return list<string>
     */
    private function sampleForAlert(Collection $conflicts): array
    {
        if ($conflicts->count() <= self::ALERT_SAMPLE_LIMIT) {
            return $conflicts->values()->all();
        }

        $remaining = $conflicts->count() - self::ALERT_SAMPLE_LIMIT;

        return $conflicts
            ->take(self::ALERT_SAMPLE_LIMIT)
            ->push(sprintf('…and %d more — see the logs (system_fix.youth_member_ids.conflict).', $remaining))
            ->values()
            ->all();
    }

    private function rowLabel(int $count): string
    {
        return sprintf('%d %s', $count, Str::plural('row', $count));
    }

    private function connection(): \Illuminate\Database\ConnectionInterface
    {
        return DB::connection(AppServiceProvider::DB_SD_CORE);
    }
}

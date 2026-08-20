<?php

namespace App\Services\SystemFixes;

use App\Enums\EventAway;
use App\Enums\GroupTypes;
use App\Enums\UserBranchTypes;
use App\Enums\UserEnglishProficiency;
use App\Enums\UserRace;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Filament\Admin\Clusters\Area\Resources\Groups\GroupResource;
use App\Filament\Admin\Clusters\DataFixes\Pages\LegacyValues;
use App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\ApplicationAdultMembershipRequestResource;
use App\Filament\Admin\Clusters\GroupOperations\Resources\Events\EventResource;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Providers\AppServiceProvider;
use BackedEnum;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Ensures legacy sd-core values are stored in the form the application expects to read.
 *
 * Legacy rows are written by screens that never trimmed their input, so values arrive wearing
 * surrounding whitespace: 1,896 leading spaces on `otherName`, 865 trailing on `SSANumber`, 817
 * on `first_name`. Most of that is invisible until something compares or sorts on the column —
 * a leading space sorts a member to the top of every alphabetical list, and MySQL's PAD SPACE
 * collation hides a trailing space from `=` while PHP's `===` still sees it.
 *
 * The fix runs two independent passes, in order, sharing one pair of settings toggles.
 *
 *   1. TRIM — surrounding whitespace is stripped from every listed column. Always safe, always
 *      automatic, and it needs to know nothing about what the column means.
 *   2. VALIDATE — every column cast to a backed enum is then checked against that enum's cases.
 *      A value that is not one of them is logged and raised for an admin, never guessed at.
 *
 * Keeping the passes separate is the point. Trimming `Martian ` is still correct even though the
 * result is not a race; the trim pass tidies it and the validate pass reports it, and neither one
 * has to reason about the other. The validate pass runs after the trim so it never reports a value
 * the same run has just repaired.
 *
 * Two collation notes, both load-bearing. These columns are `utf8mb4_unicode_ci`, which is
 * PAD SPACE, so `col <> TRIM(col)` is false for a trailing space and matches no rows at all; the
 * whitespace predicate is written on LENGTH instead. The same collation is case-insensitive, so
 * the enum comparison casts to BINARY — PHP's enums are case-sensitive, so `african` really is
 * an unrecognised value and must be reported rather than matched.
 *
 * Writes go through the query builder on purpose. This is a surgical correction of single columns
 * on historical rows, so it must not stamp `modified` or emit an audit record per row.
 */
class EnsureLegacyValuesAreCanonical implements ReportsFindings, SystemFix
{
    /**
     * Cap on how many records one column contributes. A page listing thousands helps nobody.
     *
     * The cap is never applied silently: when a column has more offenders than this, the overflow
     * is counted and stated as its own finding. A truncated list that looks complete is worse than
     * a long one, because both the page and the Slack count would understate the problem with
     * nothing to indicate it.
     */
    private const RECORDS_PER_COLUMN = 500;

    /**
     * Where each table's records can be actioned, as [resource class, preferred pages in order].
     * A table absent from this map produces findings without a link rather than no findings.
     *
     * @var array<string, array{0: class-string, 1: list<string>}>
     */
    private const RESOURCES = [
        'system_users' => [UserResource::class, ['edit', 'view']],
        'groups' => [GroupResource::class, ['edit', 'view']],
        'group_events' => [EventResource::class, ['view']],
        'forms_aam_requests' => [ApplicationAdultMembershipRequestResource::class, ['edit']],
    ];

    /**
     * A human label per table, as a SQL expression, so a finding can name the record rather than
     * only its id.
     *
     * @var array<string, string>
     */
    private const LABELS = [
        'system_users' => "CONCAT(COALESCE(first_name, ''), ' ', COALESCE(surname, ''))",
        'groups' => 'name',
        'forms_aam_requests' => "CONCAT(COALESCE(first_name, ''), ' ', COALESCE(surname, ''))",
    ];

    /**
     * Columns whose stored value must carry no surrounding whitespace. Trimmed automatically.
     *
     * @var array<string, list<string>>
     */
    private const TRIM_COLUMNS = [
        'system_users' => ['first_name', 'otherName', 'SSANumber', 'race', 'title', 'sex', 'branch'],
        'groups' => ['gpsLat', 'gpsLon', 'branchCode'],
        'group_programs' => ['title'],
        'forms_aam_requests' => ['title', 'sex'],
    ];

    /**
     * Columns backed by an enum, and what to do when a stored value is not one of its cases.
     *
     * By default the value is reported for a human, because the fix cannot know which case was
     * meant. `clear` marks a column where the value is not worth anyone's time: it is emptied
     * instead. Title is the case in point — it is a courtesy prefix, and the live data holds 204
     * "Not Set" and 112 "External Booking", sentinels no admin can meaningfully turn into a title.
     * Asking someone to clear 319 of those by hand is asking them to do what this can do itself.
     *
     * @var list<array{table: string, column: string, enum: class-string<BackedEnum>, clear?: bool}>
     */
    private const ENUM_COLUMNS = [
        ['table' => 'system_users', 'column' => 'race', 'enum' => UserRace::class],
        ['table' => 'system_users', 'column' => 'title', 'enum' => UserTitle::class, 'clear' => true],
        ['table' => 'system_users', 'column' => 'sex', 'enum' => UserSex::class],
        ['table' => 'system_users', 'column' => 'branch', 'enum' => UserBranchTypes::class],
        ['table' => 'system_users', 'column' => 'proficiencyInEnglish', 'enum' => UserEnglishProficiency::class],
        ['table' => 'forms_aam_requests', 'column' => 'title', 'enum' => UserTitle::class, 'clear' => true],
        ['table' => 'forms_aam_requests', 'column' => 'sex', 'enum' => UserSex::class],
        ['table' => 'groups', 'column' => 'groupTypeID', 'enum' => GroupTypes::class],
        ['table' => 'group_events', 'column' => 'eventAway', 'enum' => EventAway::class],
    ];

    public function label(): string
    {
        return 'Ensure legacy values are stored in their canonical form';
    }

    public function settingKey(): string
    {
        return 'ensure_legacy_values_are_canonical_enabled';
    }

    public function notificationSettingKey(): string
    {
        return 'ensure_legacy_values_are_canonical_notifications';
    }

    public function run(): SystemFixResult
    {
        /** @var list<string> $changes */
        $changes = [];
        $rowsTrimmed = 0;

        foreach (self::TRIM_COLUMNS as $table => $columns) {
            foreach ($columns as $column) {
                $trimmed = $this->trim($table, $column);

                if ($trimmed === 0) {
                    continue;
                }

                $rowsTrimmed += $trimmed;
                $changes[] = sprintf(
                    '%s.%s: stripped surrounding whitespace on %s.',
                    $table,
                    $column,
                    $this->rowLabel($trimmed),
                );

                Log::warning('system_fix.legacy_values.trimmed', [
                    'fix' => static::class,
                    'table' => $table,
                    'column' => $column,
                    'row_count' => $trimmed,
                ]);
            }
        }

        foreach (self::ENUM_COLUMNS as $target) {
            if (! ($target['clear'] ?? false)) {
                continue;
            }

            $cleared = $this->clearUnrecognised($target['table'], $target['column'], $target['enum']);

            if ($cleared === 0) {
                continue;
            }

            $rowsTrimmed += $cleared;
            $changes[] = sprintf(
                '%s.%s: cleared %s holding a value that is not a recognised %s.',
                $target['table'],
                $target['column'],
                $this->rowLabel($cleared),
                Str::headline(class_basename($target['enum'])),
            );

            Log::warning('system_fix.legacy_values.cleared', [
                'fix' => static::class,
                'table' => $target['table'],
                'column' => $target['column'],
                'row_count' => $cleared,
            ]);
        }

        // The validate pass runs after the trim and the clear, so a value this run has just
        // repaired is never raised. findings() is the single source of truth for what is
        // outstanding — the alert and the Data Fixes page cannot disagree about it.
        $findings = $this->findings();

        return new SystemFixResult(
            $this->label(),
            $this->summarise($rowsTrimmed, $findings->count()),
            $changes,
            $findings->map(fn (SystemFixFinding $f): string => $f->toLine())->all(),
        );
    }

    /**
     * Every record whose stored value is not one of its enum's cases, one finding per record,
     * each linking to where it can be corrected.
     *
     * @return Collection<int, SystemFixFinding>
     */
    public function findings(): Collection
    {
        /** @var Collection<int, SystemFixFinding> $findings */
        $findings = collect();

        foreach (self::ENUM_COLUMNS as $target) {
            // A clearable column is emptied by the nightly run, so it is never a worklist item.
            if ($target['clear'] ?? false) {
                continue;
            }

            $findings = $findings->merge(
                $this->unrecognised($target['table'], $target['column'], $target['enum']),
            );
        }

        return $findings->values();
    }

    public function findingsUrl(): ?string
    {
        return LegacyValues::getUrl(panel: 'admin');
    }

    /**
     * Strip surrounding whitespace from a column. Returns the number of rows changed.
     *
     * The predicate is written on LENGTH rather than as `col <> TRIM(col)` because these columns'
     * PAD SPACE collation considers those two equal, so the natural comparison matches nothing.
     */
    private function trim(string $table, string $column): int
    {
        $quoted = $this->quote($column);

        return $this->connection()
            ->table($table)
            ->whereNotNull($column)
            ->whereRaw("LENGTH({$quoted}) <> LENGTH(TRIM({$quoted}))")
            ->update([$column => DB::raw("TRIM({$quoted})")]);
    }

    /**
     * Empty every value the enum does not define, for a column where the value is disposable.
     * Returns the number of rows changed.
     *
     * A nullable column is set to NULL; one declared NOT NULL gets an empty string, since the
     * point is to stop the column asserting something untrue rather than to fight the schema.
     *
     * @param  class-string<BackedEnum>  $enum
     */
    private function clearUnrecognised(string $table, string $column, string $enum): int
    {
        $known = array_column($enum::cases(), 'value');
        $quoted = $this->quote($column);
        $isStringBacked = is_string($enum::cases()[0]->value ?? null);
        $subject = $isStringBacked ? "CAST({$quoted} AS BINARY)" : $quoted;

        return $this->connection()
            ->table($table)
            ->whereNotNull($column)
            ->when($this->isTextColumn($table, $column), fn ($query) => $query->where($column, '<>', ''))
            ->whereRaw("{$subject} not in (" . implode(', ', array_fill(0, count($known), '?')) . ')', $known)
            ->update([$column => $this->isNullableColumn($table, $column) ? null : '']);
    }

    /**
     * Records holding a value the enum does not define. The fix has no basis for choosing a case
     * on an admin's behalf, so each is raised as its own finding rather than corrected.
     *
     * @param  class-string<BackedEnum>  $enum
     * @return Collection<int, SystemFixFinding>
     */
    private function unrecognised(string $table, string $column, string $enum): Collection
    {
        $known = array_column($enum::cases(), 'value');
        $placeholders = implode(', ', array_fill(0, count($known), '?'));
        $quoted = $this->quote($column);

        // Two discriminators, deliberately different, because they answer different questions.
        //
        // The COMPARISON is done in the enum's own domain. A string-backed enum compares
        // byte-exactly, casting the column to BINARY — which also renders an int column as its
        // digits, so GroupTypes ('1'…'5' over an int column) still compares correctly. Doing it
        // the other way round is what MySQL gets wrong: comparing a string-backed enum's cases
        // against a raw int column coerces the non-numeric case `unknown` to 0, which silently
        // makes a stored 0 look like a valid group type.
        //
        // The BLANK check is done on the column's own type. `col <> ''` on an integer column
        // coerces to `col <> 0` and would skip a bad zero entirely.
        $isStringBacked = is_string($enum::cases()[0]->value ?? null);
        $subject = $isStringBacked ? "CAST({$quoted} AS BINARY)" : $quoted;
        $notBlank = $this->isTextColumn($table, $column) ? "and {$quoted} <> ''" : '';

        $label = self::LABELS[$table] ?? 'NULL';
        $enumName = Str::headline(class_basename($enum));

        $predicate = "where {$quoted} is not null
               {$notBlank}
               and {$subject} not in ({$placeholders})";

        $rows = $this->connection()->select(
            "select id, {$quoted} as value, {$label} as label
             from {$this->quote($table)}
             {$predicate}
             order by id
             limit " . self::RECORDS_PER_COLUMN,
            $known,
        );

        $findings = collect($rows)->map(function (object $row) use ($table, $column, $enumName): SystemFixFinding {
            $name = trim((string) $row->label);

            return new SystemFixFinding(
                title: $name !== '' ? "#{$row->id} {$name}" : "{$table} #{$row->id}",
                detail: sprintf('%s is "%s", which is not a recognised %s.', $column, $row->value, $enumName),
                url: $this->recordUrl($table, (int) $row->id),
                linkLabel: 'Open record',
                group: "{$table}.{$column}",
            );
        });

        if ($findings->count() < self::RECORDS_PER_COLUMN) {
            return $findings;
        }

        $total = (int) $this->connection()->select(
            "select count(*) as aggregate from {$this->quote($table)} {$predicate}",
            $known,
        )[0]->aggregate;

        // Landing exactly on the cap is a complete list, not a truncated one.
        if ($total <= $findings->count()) {
            return $findings;
        }

        return $findings->push(new SystemFixFinding(
            title: sprintf('%d more not listed', $total - $findings->count()),
            detail: sprintf(
                'Only the first %d of %d records with an unrecognised %s are shown. Fix these and re-open the page for the rest.',
                self::RECORDS_PER_COLUMN,
                $total,
                $column,
            ),
            group: "{$table}.{$column}",
        ));
    }

    /**
     * Where a record can be actioned, or null when its table has no admin surface. Resources are
     * asked for their preferred page first and fall back, because not every resource registers an
     * edit page — Events, for example, is view-only.
     */
    private function recordUrl(string $table, int $id): ?string
    {
        [$resource, $pages] = self::RESOURCES[$table] ?? [null, []];

        if ($resource === null) {
            return null;
        }

        foreach ($pages as $page) {
            if (array_key_exists($page, $resource::getPages())) {
                return $resource::getUrl($page, ['record' => $id], panel: 'admin');
            }
        }

        return null;
    }

    /**
     * Whether a column stores text, read from the schema rather than inferred from the enum bound
     * to it. The two disagree: GroupTypes is a string-backed enum over an int column.
     */
    private function isTextColumn(string $table, string $column): bool
    {
        $type = $this->connection()->selectOne(
            'select DATA_TYPE t from information_schema.COLUMNS
             where TABLE_SCHEMA = DATABASE() and TABLE_NAME = ? and COLUMN_NAME = ?',
            [$table, $column],
        );

        return in_array($type?->t, ['varchar', 'char', 'text', 'tinytext', 'mediumtext', 'longtext'], true);
    }

    private function isNullableColumn(string $table, string $column): bool
    {
        $nullable = $this->connection()->selectOne(
            'select IS_NULLABLE n from information_schema.COLUMNS
             where TABLE_SCHEMA = DATABASE() and TABLE_NAME = ? and COLUMN_NAME = ?',
            [$table, $column],
        );

        return $nullable?->n === 'YES';
    }

    /**
     * These identifiers come from this class's own constants, never from input; the quoting is
     * here so a column named after a reserved word cannot break the raw fragments above.
     */
    private function quote(string $identifier): string
    {
        return '`' . str_replace('`', '', $identifier) . '`';
    }

    private function summarise(int $rowsTrimmed, int $attentionCount): string
    {
        if ($rowsTrimmed === 0 && $attentionCount === 0) {
            return 'Every legacy value checked is already stored in its canonical form.';
        }

        $parts = [];

        if ($rowsTrimmed > 0) {
            $parts[] = sprintf('trimmed %d %s', $rowsTrimmed, Str::plural('row', $rowsTrimmed));
        }

        if ($attentionCount > 0) {
            $parts[] = sprintf('%d unrecognised %s need review', $attentionCount, Str::plural('value', $attentionCount));
        }

        return Str::ucfirst(implode('; ', $parts)) . '.';
    }

    private function rowLabel(int $count): string
    {
        return sprintf('%d %s', $count, Str::plural('row', $count));
    }

    private function connection(): ConnectionInterface
    {
        return DB::connection(AppServiceProvider::DB_SD_CORE);
    }
}

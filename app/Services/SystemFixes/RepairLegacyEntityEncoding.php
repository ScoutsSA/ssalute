<?php

namespace App\Services\SystemFixes;

use App\Filament\Admin\Clusters\Area\Resources\Groups\GroupResource;
use App\Filament\Admin\Clusters\DataFixes\Pages\LegacyEntityEncoding;
use App\Filament\Admin\Clusters\GroupOperations\Resources\Events\EventResource;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Providers\AppServiceProvider;
use App\Services\LegacyHtmlService;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Repairs legacy text that the Scouts Digital edit forms re-encoded on every save.
 *
 * clean_input() stores an ampersand as `&amp;amp;` (two layers) and the legacy display decodes two
 * layers, so two is harmless. But many legacy edit forms put the stored value back into the field
 * without decoding it, and every save then adds a layer: live rows carry up to sixteen, and from
 * the fourth layer on members see the residue ("Fires &amp;amp; Cooking"). Rows that hit this have
 * also been "fixed" by hand, which is how a group ended up named "1st Naruna ; Constantia".
 *
 * Every listed column holding four or more layers is passed through LegacyHtmlService::repair(),
 * which decodes it only when members would see the same text minus the residue. What it refuses
 * (tag-like text, backslashes, double quotes the legacy render drops) stays as it is and is raised
 * for an admin. Three layers is left alone: it renders correctly, and it is where the legacy rich
 * text editor settles (it posts `&` back as `&amp;`), so repairing it would rewrite every editor
 * save the following night.
 *
 * The legacy forms keep adding layers until each one is fixed, so this runs nightly rather than
 * once. Writes go through the query builder on purpose: a correction of single columns on
 * historical rows must not stamp `modified` or emit an audit record per row.
 */
class RepairLegacyEntityEncoding implements ReportsFindings, SystemFix
{
    /**
     * Four layers and up is what members see as junk: it is what gets repaired, and what is left
     * for an admin when the repair is refused.
     */
    private const string VISIBLY_BROKEN_PATTERN = '%&amp;amp;amp;amp;%';

    private const string VISIBLY_BROKEN_MARKER = '&amp;amp;amp;amp;';

    private const int RECORDS_PER_COLUMN = 500;

    private const int EXCERPT_RADIUS = 40;

    /**
     * Content columns the legacy forms write. Log and audit tables (error_logging,
     * group_edit_record, event_booking_setup_changes, support_chats) are left as recorded.
     *
     * @var array<string, list<string>>
     */
    private const array COLUMNS = [
        'advancement_cubs' => ['notes'],
        'advancement_notes' => ['note'],
        'advancement_photos' => ['description'],
        'advancement_scouts' => ['notes'],
        'ams_documents' => ['description'],
        'ams_documents_groups' => ['description'],
        'ams_training_courses_annual' => ['description', 'name'],
        'ams_training_courses_annual_bookings' => ['instructions', 'previousCourses'],
        'ams_training_locations' => ['contact'],
        'badges_cubs' => ['notes'],
        'badges_documents' => ['description'],
        'badges_meerkats' => ['notes'],
        'badges_notes' => ['note'],
        'badges_photos' => ['description'],
        'badges_scouts' => ['notes'],
        'event_competition_score_adjudication' => ['notes'],
        'event_competitions_groups_attending' => ['teamName'],
        'event_competitions_questions' => ['question'],
        'event_competitions_scoring_sheets' => ['name'],
        'group_district_reports_cubs_attendance' => ['comments'],
        'group_district_reports_scouts_attendance' => ['comments'],
        'group_documents' => ['description'],
        'group_equipment' => ['description', 'purchaseLocation'],
        'group_equipment_store' => ['name'],
        'group_events' => ['description', 'locationAddress', 'locationLat', 'locationLon', 'locationName', 'name'],
        'group_financial_invoices_items' => ['description', 'feeArea'],
        'group_programs' => ['description', 'title'],
        'group_programs_online_tasks' => ['description', 'needs', 'task'],
        'group_programs_online_tasks_notes' => ['note'],
        'groups' => ['description', 'name', 'phys_address', 'postalAddress', 'scarf'],
        'groups_property' => ['ERFno', 'groupNotes', 'improvementsDescription', 'insuranceCompany', 'insuranceContactPerson', 'insuranceDetails', 'landlordName', 'leaseConditions', 'propertyDescription'],
        'info_sharing' => ['name'],
        'jamboree_application' => ['trainingAttended'],
        'scouter_reviews' => ['review'],
        'system_badge_scouts_first' => ['note'],
        'system_badge_scouts_second' => ['task'],
        'system_faq' => ['a'],
        'system_users' => ['allergies', 'allergiesInstructions', 'currentMedication', 'disabilities', 'doctorsName', 'employer', 'first_name', 'hobbies', 'medicalAidName', 'medicalAidPrincipalMember', 'medicalConditions', 'medicalConditionsInstructions', 'occupation', 'phys_address', 'postal_address', 'specialMealRequirements'],
        'system_users_other_roles' => ['creationNotes'],
    ];

    /**
     * Where each table's records can be actioned, as [resource class, preferred pages in order].
     *
     * @var array<string, array{0: class-string, 1: list<string>}>
     */
    private const array RESOURCES = [
        'system_users' => [UserResource::class, ['edit', 'view']],
        'groups' => [GroupResource::class, ['edit', 'view']],
        'group_events' => [EventResource::class, ['view']],
    ];

    /**
     * A human label per table, as a SQL expression, so a finding can name the record.
     *
     * @var array<string, string>
     */
    private const array LABELS = [
        'system_users' => "CONCAT(COALESCE(first_name, ''), ' ', COALESCE(surname, ''))",
        'groups' => 'name',
        'group_events' => 'name',
        'group_programs' => 'title',
    ];

    public function label(): string
    {
        return 'Repair legacy text re-encoded by repeated saves';
    }

    public function settingKey(): string
    {
        return 'repair_legacy_entity_encoding_enabled';
    }

    public function notificationSettingKey(): string
    {
        return 'repair_legacy_entity_encoding_notifications';
    }

    public function run(): SystemFixResult
    {
        /** @var list<string> $changes */
        $changes = [];
        $rowsRepaired = 0;

        foreach (self::COLUMNS as $table => $columns) {
            $repairedPerColumn = $this->repairTable($table, $columns);

            foreach ($repairedPerColumn as $column => $repaired) {
                $rowsRepaired += $repaired;
                $changes[] = sprintf('%s.%s: repaired %s.', $table, $column, $this->rowLabel($repaired));

                Log::warning('system_fix.legacy_entity_encoding.repaired', [
                    'fix' => static::class,
                    'table' => $table,
                    'column' => $column,
                    'row_count' => $repaired,
                ]);
            }
        }

        $findings = $this->findings();

        return new SystemFixResult(
            $this->label(),
            $this->summarise($rowsRepaired, $findings->count()),
            $changes,
            $findings->map(fn (SystemFixFinding $finding): string => $finding->toLine())->all(),
        );
    }

    /**
     * Every record still showing entity residue, one finding per record and column.
     *
     * @return Collection<int, SystemFixFinding>
     */
    public function findings(): Collection
    {
        /** @var Collection<int, SystemFixFinding> $findings */
        $findings = collect();

        foreach (self::COLUMNS as $table => $columns) {
            foreach ($columns as $column) {
                $findings = $findings->merge($this->visiblyBroken($table, $column));
            }
        }

        return $findings->values();
    }

    public function findingsUrl(): ?string
    {
        return LegacyEntityEncoding::getUrl(panel: 'admin');
    }

    /**
     * Repair one table's candidate rows in a single pass. Returns rows changed per column.
     *
     * @param  list<string>  $columns
     * @return array<string, int>
     */
    private function repairTable(string $table, array $columns): array
    {
        /** @var array<string, int> $repaired */
        $repaired = [];

        $this->connection()
            ->table($table)
            ->select(['id', ...$columns])
            ->where(function ($query) use ($columns): void {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', self::VISIBLY_BROKEN_PATTERN);
                }
            })
            ->orderBy('id')
            ->chunkById(200, function (Collection $rows) use ($table, $columns, &$repaired): void {
                foreach ($rows as $row) {
                    $updates = [];

                    foreach ($columns as $column) {
                        $stored = $row->{$column};

                        if ($stored === null) {
                            continue;
                        }

                        if (! str_contains($stored, self::VISIBLY_BROKEN_MARKER)) {
                            continue;
                        }

                        $repairedValue = LegacyHtmlService::repair($stored);

                        if ($repairedValue === $stored) {
                            continue;
                        }

                        $updates[$column] = $repairedValue;
                        $repaired[$column] = ($repaired[$column] ?? 0) + 1;
                    }

                    if ($updates !== []) {
                        $this->connection()->table($table)->where('id', $row->id)->update($updates);
                    }
                }
            });

        return $repaired;
    }

    /**
     * @return Collection<int, SystemFixFinding>
     */
    private function visiblyBroken(string $table, string $column): Collection
    {
        $label = self::LABELS[$table] ?? 'NULL';

        $rows = $this->connection()
            ->table($table)
            ->select(['id', "{$column} as value"])
            ->selectRaw("{$label} as label")
            ->where($column, 'like', self::VISIBLY_BROKEN_PATTERN)
            ->orderBy('id')
            ->limit(self::RECORDS_PER_COLUMN)
            ->get();

        $findings = $rows->map(function (object $row) use ($table, $column): SystemFixFinding {
            $name = trim((string) $row->label);

            return new SystemFixFinding(
                title: $name !== '' ? "#{$row->id} {$name}" : "{$table} #{$row->id}",
                detail: sprintf(
                    '%s shows leftover encoding the repair could not safely remove: "%s"',
                    $column,
                    $this->excerpt((string) $row->value),
                ),
                url: $this->recordUrl($table, (int) $row->id),
                linkLabel: 'Open record',
                group: "{$table}.{$column}",
            );
        });

        if ($findings->count() < self::RECORDS_PER_COLUMN) {
            return $findings;
        }

        $total = $this->connection()->table($table)->where($column, 'like', self::VISIBLY_BROKEN_PATTERN)->count();

        if ($total <= $findings->count()) {
            return $findings;
        }

        return $findings->push(new SystemFixFinding(
            title: sprintf('%d more not listed', $total - $findings->count()),
            detail: sprintf(
                'Only the first %d of %d records with leftover encoding in %s are shown. Fix these and re-open the page for the rest.',
                self::RECORDS_PER_COLUMN,
                $total,
                $column,
            ),
            group: "{$table}.{$column}",
        ));
    }

    /**
     * The stored text around the first run of leftover layers, so an admin can find it.
     */
    private function excerpt(string $value): string
    {
        $position = mb_strpos($value, self::VISIBLY_BROKEN_MARKER) ?: 0;
        $start = max(0, $position - self::EXCERPT_RADIUS);

        return Str::of(mb_substr($value, $start, self::EXCERPT_RADIUS * 3))
            ->squish()
            ->when($start > 0, fn ($excerpt) => $excerpt->prepend('…'))
            ->toString();
    }

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

    private function summarise(int $rowsRepaired, int $attentionCount): string
    {
        if ($rowsRepaired === 0 && $attentionCount === 0) {
            return 'No legacy text carries leftover encoding.';
        }

        $parts = [];

        if ($rowsRepaired > 0) {
            $parts[] = sprintf('repaired %s', $this->rowLabel($rowsRepaired));
        }

        if ($attentionCount > 0) {
            $parts[] = sprintf('%d %s still %s leftover encoding', $attentionCount, Str::plural('value', $attentionCount), $attentionCount === 1 ? 'shows' : 'show');
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

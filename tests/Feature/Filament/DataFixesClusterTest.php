<?php

namespace Tests\Feature\Filament;

use App\Console\Commands\RunSystemFixes;
use App\Filament\Admin\Clusters\DataFixes\Pages\FindingsPage;
use App\Filament\Admin\Clusters\DataFixes\Pages\HomeLocationRoles;
use App\Filament\Admin\Clusters\DataFixes\Pages\LegacyValues;
use App\Filament\Admin\Clusters\DataFixes\Pages\PrimaryRoles;
use App\Filament\Admin\Clusters\DataFixes\Pages\YouthMemberIds;
use App\Models\Group;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use App\Providers\AppServiceProvider;
use App\Services\SystemFixes\EnsureLegacyValuesAreCanonical;
use App\Services\SystemFixes\FlagUsersWithoutRoleInHomeLocation;
use App\Services\SystemFixes\ReportsFindings;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use ReflectionClass;
use Tests\Support\SdCoreTestCase;

class DataFixesClusterTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    /**
     * @return list<array{0: class-string<FindingsPage>}>
     */
    public static function pages(): array
    {
        return [
            [LegacyValues::class],
            [HomeLocationRoles::class],
            [YouthMemberIds::class],
            [PrimaryRoles::class],
        ];
    }

    #[Test]
    #[DataProvider('pages')]
    public function a_super_admin_can_open_each_data_fix_page(string $page): void
    {
        $this->actingAs($this->superAdmin)
            ->get($page::getUrl(panel: 'admin'))
            ->assertOk();
    }

    #[Test]
    #[DataProvider('pages')]
    public function each_page_shows_an_empty_state_when_nothing_is_outstanding(string $page): void
    {
        $this->actingAs($this->superAdmin);

        Livewire::test($page)->assertSee('Nothing outstanding');
    }

    #[Test]
    public function every_registered_fix_that_reports_findings_has_a_page_pointing_back_at_it(): void
    {
        // The alert links to findingsUrl(), so a fix reporting findings with no page would send
        // admins to a dead link. This pins the two lists together.
        $fixes = (new ReflectionClass(RunSystemFixes::class))
            ->getProperty('fixes');
        $fixes->setAccessible(true);
        $registered = $fixes->getValue(app(RunSystemFixes::class));

        $pagesByFix = collect(self::pages())
            ->map(fn (array $row): string => $row[0])
            ->keyBy(fn (string $page): string => $page::fix());

        foreach ($registered as $fixClass) {
            if (! is_subclass_of($fixClass, ReportsFindings::class)) {
                continue;
            }

            $this->assertTrue(
                $pagesByFix->has($fixClass),
                "{$fixClass} reports findings but has no page in the Data Fixes cluster.",
            );

            $this->assertSame(
                $pagesByFix->get($fixClass)::getUrl(panel: 'admin'),
                app($fixClass)->findingsUrl(),
                "{$fixClass} links somewhere other than its own page.",
            );
        }
    }

    #[Test]
    public function the_page_lists_a_record_whose_value_is_not_recognised(): void
    {
        $user = $this->userWithRace('Martian');

        $this->actingAs($this->superAdmin);

        Livewire::test(LegacyValues::class)
            ->assertSee('is not a recognised User Race')
            ->assertSee((string) $user->id);
    }

    #[Test]
    public function each_finding_links_to_the_record_it_is_about(): void
    {
        $user = $this->userWithRace('Martian');

        $finding = app(EnsureLegacyValuesAreCanonical::class)->findings()
            ->firstWhere('title', "#{$user->id} {$user->first_name} {$user->surname}");

        $this->assertNotNull($finding, 'Expected a finding naming the member.');
        $this->assertNotNull($finding->url, 'The finding must link somewhere an admin can act.');
        $this->assertStringContainsString((string) $user->id, $finding->url);
        $this->assertStringContainsString('/backoffice/', $finding->url);
    }

    #[Test]
    public function a_finding_disappears_once_the_record_is_corrected(): void
    {
        $user = $this->userWithRace('Martian');

        $fix = app(EnsureLegacyValuesAreCanonical::class);
        $this->assertCount(1, $fix->findings());

        $user->update(['race' => \App\Enums\UserRace::African]);

        // Measured on read, so the page reflects the correction immediately rather than waiting
        // for the next nightly run.
        $this->assertCount(0, app(EnsureLegacyValuesAreCanonical::class)->findings());
    }

    #[Test]
    public function the_home_location_modal_offers_the_places_the_members_roles_actually_sit(): void
    {
        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $group = $this->groupAt(id: 200, district: 7, region: 3);
        $this->groupRole($user, $group->id);

        $candidates = app(FlagUsersWithoutRoleInHomeLocation::class)->homeCandidates($user->id);

        $this->assertArrayHasKey("group:{$group->id}", $candidates);
        $this->assertStringContainsString($group->name, $candidates["group:{$group->id}"]);
    }

    #[Test]
    public function setting_the_home_location_moves_the_member_and_clears_the_finding(): void
    {
        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $group = $this->groupAt(id: 200, district: 7, region: 3);
        $this->groupRole($user, $group->id);

        $fix = app(FlagUsersWithoutRoleInHomeLocation::class);
        $this->assertCount(1, $fix->findings(), 'Expected the member to be flagged first.');

        $fix->setHome($user->id, "group:{$group->id}");

        $user->refresh();
        $this->assertSame($group->id, (int) $user->assoc_to_group);

        // The hierarchy is kept consistent, not just the group.
        $this->assertSame(7, (int) $user->assoc_to_district);
        $this->assertSame(3, (int) $user->assoc_to_region);

        // Findings are measured on read, so the row is gone without waiting for a nightly run.
        $this->assertCount(0, app(FlagUsersWithoutRoleInHomeLocation::class)->findings());
    }

    #[Test]
    public function the_home_location_action_is_hidden_when_there_is_nothing_to_choose(): void
    {
        // A member flagged with no resolvable role location cannot be fixed from the modal.
        $this->assertSame([], app(FlagUsersWithoutRoleInHomeLocation::class)->homeCandidates(0));
    }

    private function groupAt(int $id, int $district, int $region): Group
    {
        $this->connection()->table('groups')->insert(array_merge(
            $this->requiredColumns('groups'),
            ['id' => $id, 'name' => "Group {$id}", 'assoc_to_district' => $district, 'assoc_to_region' => $region],
        ));

        return Group::query()->findOrFail($id);
    }

    private function groupRole(SystemUser $user, int $groupId): void
    {
        SystemUsersOtherRole::factory()->create([
            'userID' => $user->id,
            'roleID' => SystemUserType::factory()->group()->create()->id,
            'groupID' => $groupId,
            'active' => 1,
        ]);
    }

    /**
     * @return array<string, string|int>
     */
    private function requiredColumns(string $table): array
    {
        $required = $this->connection()->select(
            "select COLUMN_NAME n, DATA_TYPE t from information_schema.COLUMNS
             where TABLE_SCHEMA = DATABASE() and TABLE_NAME = ?
               and IS_NULLABLE = 'NO' and COLUMN_DEFAULT is null
               and EXTRA not like '%auto_increment%'",
            [$table],
        );

        $values = [];

        foreach ($required as $column) {
            $values[$column->n] = match ($column->t) {
                'int', 'bigint', 'mediumint', 'smallint', 'tinyint', 'decimal', 'double', 'float' => 0,
                'date' => '2020-01-01',
                'datetime', 'timestamp' => '2020-01-01 00:00:00',
                default => '',
            };
        }

        return $values;
    }

    private function connection(): \Illuminate\Database\ConnectionInterface
    {
        return DB::connection(AppServiceProvider::DB_SD_CORE);
    }

    private function userWithRace(string $race): SystemUser
    {
        $user = SystemUser::factory()->create();

        DB::connection(AppServiceProvider::DB_SD_CORE)
            ->table('system_users')
            ->where('id', $user->id)
            ->update(['race' => $race]);

        return $user->fresh();
    }
}

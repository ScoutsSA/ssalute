<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Cubs\CubBadgeResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Cubs\Pages\ListCubBadges;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Meerkats\MeerkatBadgeResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Meerkats\Pages\ListMeerkatBadges;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Meerkats\Pages\ViewMeerkatBadge;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\RelationManagers\AutoSignOffTasksRelationManager;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\RelationManagers\BadgeTasksRelationManager;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Rovers\Pages\ListRoverBadges;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Rovers\RoverBadgeResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Scouts\Pages\ListScoutBadges;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Scouts\Pages\ViewScoutBadge;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Scouts\ScoutBadgeResource;
use App\Models\BadgesScout;
use App\Models\SystemBadgeCubsFirst;
use App\Models\SystemBadgeMeerkatsFirst;
use App\Models\SystemBadgeMeerkatsSecond;
use App\Models\SystemBadgeRoversFirst;
use App\Models\SystemBadgeScoutsFirst;
use App\Models\SystemBadgeScoutsSecond;
use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use Filament\Actions\CreateAction;
use Filament\Actions\Testing\TestAction;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class BranchManagementClusterTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    /** @return array<string, array{class-string, class-string}> */
    public static function badgeResourceProvider(): array
    {
        return [
            'meerkat badges' => [MeerkatBadgeResource::class, SystemBadgeMeerkatsFirst::class],
            'cub badges' => [CubBadgeResource::class, SystemBadgeCubsFirst::class],
            'scout badges' => [ScoutBadgeResource::class, SystemBadgeScoutsFirst::class],
            'rover badges' => [RoverBadgeResource::class, SystemBadgeRoversFirst::class],
        ];
    }

    /** @return array<string, array{class-string, class-string}> */
    public static function badgeListPageProvider(): array
    {
        return [
            'meerkat badges' => [ListMeerkatBadges::class, SystemBadgeMeerkatsFirst::class],
            'cub badges' => [ListCubBadges::class, SystemBadgeCubsFirst::class],
            'scout badges' => [ListScoutBadges::class, SystemBadgeScoutsFirst::class],
            'rover badges' => [ListRoverBadges::class, SystemBadgeRoversFirst::class],
        ];
    }

    #[Test]
    #[DataProvider('badgeResourceProvider')]
    public function super_admin_can_access_badge_resource_list(string $resourceClass, string $modelClass): void
    {
        $this->actingAs($this->superAdmin)
            ->get($resourceClass::getUrl('index'))
            ->assertOk();
    }

    #[Test]
    #[DataProvider('badgeResourceProvider')]
    public function regular_user_is_forbidden_from_badge_resource(string $resourceClass, string $modelClass): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get($resourceClass::getUrl('index'))
            ->assertForbidden();
    }

    #[Test]
    public function guest_is_redirected_when_accessing_branch_management(): void
    {
        $this->get(MeerkatBadgeResource::getUrl('index'))
            ->assertRedirect();
    }

    #[Test]
    #[DataProvider('badgeListPageProvider')]
    public function badge_list_shows_active_badges(string $listPageClass, string $modelClass): void
    {
        $badges = $modelClass::factory()->count(3)->create();

        Livewire::actingAs($this->superAdmin)
            ->test($listPageClass)
            ->assertOk()
            ->assertCanSeeTableRecords($badges);
    }

    #[Test]
    #[DataProvider('badgeListPageProvider')]
    public function super_admin_can_create_a_badge(string $listPageClass, string $modelClass): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test($listPageClass)
            ->callAction(CreateAction::class, data: [
                'name' => 'Astronomer',
                'type' => 'Interest',
                'note' => 'Stargazing badge.',
                'active' => true,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas($modelClass, [
            'name' => 'Astronomer',
            'type' => 'Interest',
            'active' => 1,
        ]);
    }

    #[Test]
    public function super_admin_can_edit_a_badge(): void
    {
        $badge = SystemBadgeMeerkatsFirst::factory()->create(['name' => 'Old Name']);

        Livewire::actingAs($this->superAdmin)
            ->test(ListMeerkatBadges::class)
            ->callAction(TestAction::make('edit')->table($badge), data: [
                'name' => 'New Name',
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(SystemBadgeMeerkatsFirst::class, [
            'id' => $badge->id,
            'name' => 'New Name',
        ]);
    }

    #[Test]
    public function deactivate_action_toggles_the_active_flag_without_deleting(): void
    {
        $badge = SystemBadgeMeerkatsFirst::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ListMeerkatBadges::class)
            ->callAction(TestAction::make('deactivate')->table($badge));

        $this->assertDatabaseHas(SystemBadgeMeerkatsFirst::class, [
            'id' => $badge->id,
            'active' => 0,
        ]);
    }

    #[Test]
    public function activate_action_restores_a_deactivated_badge(): void
    {
        $badge = SystemBadgeMeerkatsFirst::factory()->create(['active' => 0]);

        Livewire::actingAs($this->superAdmin)
            ->test(ListMeerkatBadges::class)
            ->filterTable('active', false)
            ->callAction(TestAction::make('activate')->table($badge));

        $this->assertDatabaseHas(SystemBadgeMeerkatsFirst::class, [
            'id' => $badge->id,
            'active' => 1,
        ]);
    }

    #[Test]
    public function task_list_hides_inactive_tasks_by_default(): void
    {
        $badge = SystemBadgeMeerkatsFirst::factory()->create();
        $active = SystemBadgeMeerkatsSecond::factory()->for($badge, 'badgeFirst')->create();
        $inactive = SystemBadgeMeerkatsSecond::factory()->for($badge, 'badgeFirst')->create(['active' => 0]);

        Livewire::actingAs($this->superAdmin)
            ->test(BadgeTasksRelationManager::class, [
                'ownerRecord' => $badge,
                'pageClass' => ViewMeerkatBadge::class,
            ])
            ->assertCanSeeTableRecords([$active])
            ->assertCanNotSeeTableRecords([$inactive]);
    }

    #[Test]
    public function view_page_renders_the_tasks_relation_manager(): void
    {
        $badge = SystemBadgeMeerkatsFirst::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewMeerkatBadge::class, ['record' => $badge->id])
            ->assertOk()
            ->assertSeeLivewire(BadgeTasksRelationManager::class);
    }

    #[Test]
    public function scout_badge_resource_registers_the_auto_sign_off_relation_manager(): void
    {
        $registered = array_map(
            fn ($manager): string => $manager->relationManager,
            ScoutBadgeResource::getRelations(),
        );

        $this->assertSame([BadgeTasksRelationManager::class, AutoSignOffTasksRelationManager::class], $registered);
    }

    #[Test]
    public function creating_a_task_appends_it_to_the_end_of_the_badge(): void
    {
        $badge = SystemBadgeMeerkatsFirst::factory()->create();
        SystemBadgeMeerkatsSecond::factory()->for($badge, 'badgeFirst')->create(['position' => 3]);

        Livewire::actingAs($this->superAdmin)
            ->test(BadgeTasksRelationManager::class, [
                'ownerRecord' => $badge,
                'pageClass' => ViewMeerkatBadge::class,
            ])
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'heading' => 'Observation',
                'task' => 'Point out three constellations.',
                'active' => true,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(SystemBadgeMeerkatsSecond::class, [
            'firstID' => $badge->id,
            'task' => 'Point out three constellations.',
            'position' => 4,
        ]);
    }

    #[Test]
    public function tasks_can_be_reordered(): void
    {
        $badge = SystemBadgeMeerkatsFirst::factory()->create();
        [$first, $second, $third] = SystemBadgeMeerkatsSecond::factory()
            ->for($badge, 'badgeFirst')
            ->count(3)
            ->sequence(['position' => 1], ['position' => 2], ['position' => 3])
            ->create();

        Livewire::actingAs($this->superAdmin)
            ->test(BadgeTasksRelationManager::class, [
                'ownerRecord' => $badge,
                'pageClass' => ViewMeerkatBadge::class,
            ])
            ->call('reorderTable', [$third->id, $first->id, $second->id]);

        $this->assertSame(2, $first->refresh()->position);
        $this->assertSame(3, $second->refresh()->position);
        $this->assertSame(1, $third->refresh()->position);
    }

    #[Test]
    public function deactivating_a_task_keeps_the_record(): void
    {
        $badge = SystemBadgeMeerkatsFirst::factory()->create();
        $task = SystemBadgeMeerkatsSecond::factory()->for($badge, 'badgeFirst')->create();

        Livewire::actingAs($this->superAdmin)
            ->test(BadgeTasksRelationManager::class, [
                'ownerRecord' => $badge,
                'pageClass' => ViewMeerkatBadge::class,
            ])
            ->callAction(TestAction::make('deactivate')->table($task));

        $this->assertDatabaseHas(SystemBadgeMeerkatsSecond::class, [
            'id' => $task->id,
            'active' => 0,
        ]);
    }

    #[Test]
    public function deactivating_catalogue_rows_leaves_awarded_badges_untouched(): void
    {
        $badge = SystemBadgeScoutsFirst::factory()->create();
        $task = SystemBadgeScoutsSecond::factory()->for($badge, 'badgeFirst')->create();
        $scout = SystemUser::factory()->create();

        $awarded = BadgesScout::query()->create([
            'assocToGroup' => 1,
            'scoutID' => $scout->id,
            'userID' => $scout->id,
            'firstID' => $badge->id,
            'secondID' => $task->id,
            'badgeDate' => '2026-01-15',
            'latest' => 1,
            'active' => 1,
            'createdby' => $this->superAdmin->id,
        ]);

        Livewire::actingAs($this->superAdmin)
            ->test(ListScoutBadges::class)
            ->callAction(TestAction::make('deactivate')->table($badge));

        Livewire::actingAs($this->superAdmin)
            ->test(BadgeTasksRelationManager::class, [
                'ownerRecord' => $badge->refresh(),
                'pageClass' => ViewScoutBadge::class,
            ])
            ->callAction(TestAction::make('deactivate')->table($task));

        $this->assertDatabaseHas(BadgesScout::class, [
            'id' => $awarded->id,
            'firstID' => $badge->id,
            'secondID' => $task->id,
            'active' => 1,
        ]);
    }

    #[Test]
    public function scout_badge_auto_sign_off_links_can_be_created_and_deactivated(): void
    {
        $badge = SystemBadgeScoutsFirst::factory()->create();
        $otherBadgeTask = SystemBadgeScoutsSecond::factory()->create();

        $relationManager = Livewire::actingAs($this->superAdmin)
            ->test(AutoSignOffTasksRelationManager::class, [
                'ownerRecord' => $badge,
                'pageClass' => ViewScoutBadge::class,
            ])
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'toBadgeTaskID' => $otherBadgeTask->id,
                'active' => true,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('system_badge_scouts_to_badge', [
            'badgeID' => $badge->id,
            'toBadgeTaskID' => $otherBadgeTask->id,
            'active' => 1,
        ]);

        $link = $badge->toBadgeLinks()->firstOrFail();

        $relationManager->callAction(TestAction::make('deactivate')->table($link));

        $this->assertDatabaseHas('system_badge_scouts_to_badge', [
            'id' => $link->id,
            'active' => 0,
        ]);
    }
}

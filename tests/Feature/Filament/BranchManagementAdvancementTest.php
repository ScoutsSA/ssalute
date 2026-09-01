<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Cubs\CubAdvancementLevelResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Cubs\Pages\ListCubAdvancementLevels;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Cubs\Pages\ViewCubAdvancementLevel;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Meerkats\MeerkatAdvancementLevelResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Meerkats\Pages\ListMeerkatAdvancementLevels;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Meerkats\Pages\ViewMeerkatAdvancementLevel;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers\CubAreasRelationManager;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers\CubTasksRelationManager;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers\MeerkatTasksRelationManager;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers\RoverTasksRelationManager;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers\ScoutTasksRelationManager;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Rovers\Pages\ListRoverAdvancementLevels;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Rovers\Pages\ViewRoverAdvancementLevel;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Rovers\RoverAdvancementLevelResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Scouts\Pages\ListScoutAdvancementLevels;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Scouts\Pages\ViewScoutAdvancementLevel;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Scouts\ScoutAdvancementLevelResource;
use App\Models\AdvancementCub;
use App\Models\SystemAdvancementCubsChallenge;
use App\Models\SystemAdvancementCubsLevel;
use App\Models\SystemAdvancementCubsSecond;
use App\Models\SystemAdvancementCubsThird;
use App\Models\SystemAdvancementMeerkatsLevel;
use App\Models\SystemAdvancementMeerkatsSecond;
use App\Models\SystemAdvancementRoversLevel;
use App\Models\SystemAdvancementRoversSecond;
use App\Models\SystemAdvancementScoutsLevel;
use App\Models\SystemAdvancementScoutsSecond;
use App\Models\SystemAdvancementScoutsSecondEntshaTheme;
use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use Filament\Actions\CreateAction;
use Filament\Actions\Testing\TestAction;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class BranchManagementAdvancementTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    /** @return array<string, array{class-string}> */
    public static function advancementResourceProvider(): array
    {
        return [
            'meerkat advancement' => [MeerkatAdvancementLevelResource::class],
            'cub advancement' => [CubAdvancementLevelResource::class],
            'scout advancement' => [ScoutAdvancementLevelResource::class],
            'rover advancement' => [RoverAdvancementLevelResource::class],
        ];
    }

    /** @return array<string, array{class-string, class-string}> */
    public static function advancementListPageProvider(): array
    {
        return [
            'meerkat advancement' => [ListMeerkatAdvancementLevels::class, SystemAdvancementMeerkatsLevel::class],
            'cub advancement' => [ListCubAdvancementLevels::class, SystemAdvancementCubsLevel::class],
            'scout advancement' => [ListScoutAdvancementLevels::class, SystemAdvancementScoutsLevel::class],
            'rover advancement' => [ListRoverAdvancementLevels::class, SystemAdvancementRoversLevel::class],
        ];
    }

    #[Test]
    #[DataProvider('advancementResourceProvider')]
    public function super_admin_can_access_advancement_level_list(string $resourceClass): void
    {
        $this->actingAs($this->superAdmin)
            ->get($resourceClass::getUrl('index'))
            ->assertOk();
    }

    #[Test]
    #[DataProvider('advancementResourceProvider')]
    public function regular_user_is_forbidden_from_advancement_levels(string $resourceClass): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get($resourceClass::getUrl('index'))
            ->assertForbidden();
    }

    #[Test]
    public function guest_is_redirected_when_accessing_advancement_levels(): void
    {
        $this->get(MeerkatAdvancementLevelResource::getUrl('index'))
            ->assertRedirect();
    }

    #[Test]
    #[DataProvider('advancementListPageProvider')]
    public function level_list_shows_levels(string $listPageClass, string $modelClass): void
    {
        $levels = $modelClass::factory()->count(3)->create();

        Livewire::actingAs($this->superAdmin)
            ->test($listPageClass)
            ->assertOk()
            ->assertCanSeeTableRecords($levels);
    }

    #[Test]
    public function creating_a_level_appends_it_to_the_end(): void
    {
        SystemAdvancementMeerkatsLevel::factory()->create(['position' => 7]);

        Livewire::actingAs($this->superAdmin)
            ->test(ListMeerkatAdvancementLevels::class)
            ->callAction(CreateAction::class, data: [
                'name' => 'Copper Meerkat',
                'description' => 'A new level.',
                'highLevel' => true,
                'investment' => false,
                'active' => true,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(SystemAdvancementMeerkatsLevel::class, [
            'name' => 'Copper Meerkat',
            'position' => 8,
            'highLevel' => 1,
            'active' => 1,
        ]);
    }

    #[Test]
    public function super_admin_can_edit_a_level(): void
    {
        $level = SystemAdvancementScoutsLevel::factory()->create(['name' => 'Old Level']);

        Livewire::actingAs($this->superAdmin)
            ->test(ListScoutAdvancementLevels::class)
            ->callAction(TestAction::make('edit')->table($level), data: [
                'name' => 'Renamed Level',
                'colour' => 'Green',
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(SystemAdvancementScoutsLevel::class, [
            'id' => $level->id,
            'name' => 'Renamed Level',
            'colour' => 'Green',
        ]);
    }

    #[Test]
    public function deactivate_action_toggles_a_level_without_deleting(): void
    {
        $level = SystemAdvancementRoversLevel::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ListRoverAdvancementLevels::class)
            ->callAction(TestAction::make('deactivate')->table($level));

        $this->assertDatabaseHas(SystemAdvancementRoversLevel::class, [
            'id' => $level->id,
            'active' => 0,
        ]);

        Livewire::actingAs($this->superAdmin)
            ->test(ListRoverAdvancementLevels::class)
            ->callAction(TestAction::make('activate')->table($level->refresh()));

        $this->assertDatabaseHas(SystemAdvancementRoversLevel::class, [
            'id' => $level->id,
            'active' => 1,
        ]);
    }

    #[Test]
    public function levels_can_be_reordered(): void
    {
        [$first, $second, $third] = SystemAdvancementMeerkatsLevel::factory()
            ->count(3)
            ->sequence(['position' => 1], ['position' => 2], ['position' => 3])
            ->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ListMeerkatAdvancementLevels::class)
            ->call('reorderTable', [$third->id, $first->id, $second->id]);

        $this->assertSame(2, $first->refresh()->position);
        $this->assertSame(3, $second->refresh()->position);
        $this->assertSame(1, $third->refresh()->position);
    }

    #[Test]
    public function meerkat_tasks_can_be_created_with_appended_position(): void
    {
        $level = SystemAdvancementMeerkatsLevel::factory()->create();
        SystemAdvancementMeerkatsSecond::factory()->for($level, 'advancement')->create(['position' => 2]);

        Livewire::actingAs($this->superAdmin)
            ->test(MeerkatTasksRelationManager::class, [
                'ownerRecord' => $level,
                'pageClass' => ViewMeerkatAdvancementLevel::class,
            ])
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'name' => 'Tie a knot',
                'short' => 'Knot',
                'description' => 'Tie a simple knot.',
                'badgeTask' => false,
                'active' => true,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(SystemAdvancementMeerkatsSecond::class, [
            'advancmentID' => $level->id,
            'name' => 'Tie a knot',
            'position' => 3,
        ]);
    }

    #[Test]
    public function cub_areas_can_be_created_and_have_no_deactivate_action(): void
    {
        $level = SystemAdvancementCubsLevel::factory()->create();
        $area = SystemAdvancementCubsSecond::factory()->for($level, 'advancement')->create();

        Livewire::actingAs($this->superAdmin)
            ->test(CubAreasRelationManager::class, [
                'ownerRecord' => $level,
                'pageClass' => ViewCubAdvancementLevel::class,
            ])
            ->assertOk()
            ->assertCanSeeTableRecords([$area])
            ->assertActionDoesNotExist(TestAction::make('deactivate')->table($area))
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'name' => 'Living Outdoors',
                'description' => 'Outdoor area.',
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(SystemAdvancementCubsSecond::class, [
            'advancmentID' => $level->id,
            'name' => 'Living Outdoors',
        ]);
    }

    #[Test]
    public function cub_tasks_can_be_created_with_area_and_challenge(): void
    {
        $level = SystemAdvancementCubsLevel::factory()->create();
        $area = SystemAdvancementCubsSecond::factory()->for($level, 'advancement')->create();
        SystemAdvancementCubsChallenge::factory()->create(['name' => 'Outdoor Challenge']);

        Livewire::actingAs($this->superAdmin)
            ->test(CubTasksRelationManager::class, [
                'ownerRecord' => $level,
                'pageClass' => ViewCubAdvancementLevel::class,
            ])
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'secondID' => $area->id,
                'name' => 'Pitch a tent',
                'short' => 'Tent',
                'description' => 'Pitch a tent with your six.',
                'challenge' => 'Outdoor Challenge',
                'note' => '',
                'campingTask' => true,
                'badgeTask' => false,
                'active' => true,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(SystemAdvancementCubsThird::class, [
            'advancmentID' => $level->id,
            'secondID' => $area->id,
            'name' => 'Pitch a tent',
            'challenge' => 'Outdoor Challenge',
            'campingTask' => 1,
        ]);
    }

    #[Test]
    public function scout_tasks_can_be_created_with_an_entsha_theme(): void
    {
        $level = SystemAdvancementScoutsLevel::factory()->create();
        $theme = SystemAdvancementScoutsSecondEntshaTheme::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ScoutTasksRelationManager::class, [
                'ownerRecord' => $level,
                'pageClass' => ViewScoutAdvancementLevel::class,
            ])
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'name' => 'Plan a hike',
                'short' => 'Hike',
                'description' => 'Plan a day hike.',
                'theme' => $theme->id,
                'campingTask' => false,
                'badgeTask' => false,
                'PGATask' => true,
                'active' => true,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(SystemAdvancementScoutsSecond::class, [
            'advancmentID' => $level->id,
            'name' => 'Plan a hike',
            'theme' => $theme->id,
            'PGATask' => 1,
        ]);
    }

    #[Test]
    public function rover_tasks_can_be_created(): void
    {
        $level = SystemAdvancementRoversLevel::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(RoverTasksRelationManager::class, [
                'ownerRecord' => $level,
                'pageClass' => ViewRoverAdvancementLevel::class,
            ])
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'name' => 'Community project',
                'short' => 'Project',
                'description' => 'Complete a community project.',
                'campingTask' => false,
                'badgeTask' => false,
                'active' => true,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(SystemAdvancementRoversSecond::class, [
            'advancmentID' => $level->id,
            'name' => 'Community project',
            'position' => 1,
        ]);
    }

    #[Test]
    public function deactivating_catalogue_rows_leaves_awarded_advancements_untouched(): void
    {
        $level = SystemAdvancementCubsLevel::factory()->create();
        $area = SystemAdvancementCubsSecond::factory()->for($level, 'advancement')->create();
        $task = SystemAdvancementCubsThird::factory()->for($level, 'advancement')->create(['secondID' => $area->id]);
        $cub = SystemUser::factory()->create();

        $awarded = AdvancementCub::query()->create([
            'assocToGroup' => 1,
            'cubID' => $cub->id,
            'userID' => $cub->id,
            'advancementID' => $level->id,
            'advancementSecondID' => $area->id,
            'advancementThirdID' => $task->id,
            'advancementDate' => '2026-02-01',
            'latest' => 1,
            'active' => 1,
            'createdby' => $this->superAdmin->id,
        ]);

        Livewire::actingAs($this->superAdmin)
            ->test(ListCubAdvancementLevels::class)
            ->callAction(TestAction::make('deactivate')->table($level));

        Livewire::actingAs($this->superAdmin)
            ->test(CubTasksRelationManager::class, [
                'ownerRecord' => $level->refresh(),
                'pageClass' => ViewCubAdvancementLevel::class,
            ])
            ->callAction(TestAction::make('deactivate')->table($task));

        $this->assertDatabaseHas(AdvancementCub::class, [
            'id' => $awarded->id,
            'advancementID' => $level->id,
            'advancementSecondID' => $area->id,
            'advancementThirdID' => $task->id,
            'active' => 1,
        ]);
    }

    #[Test]
    public function view_pages_render_their_relation_managers(): void
    {
        $meerkatLevel = SystemAdvancementMeerkatsLevel::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewMeerkatAdvancementLevel::class, ['record' => $meerkatLevel->id])
            ->assertOk()
            ->assertSeeLivewire(MeerkatTasksRelationManager::class);

        $registered = array_map(
            fn ($manager): string => $manager->relationManager,
            CubAdvancementLevelResource::getRelations(),
        );

        $this->assertSame([CubAreasRelationManager::class, CubTasksRelationManager::class], $registered);
    }
}

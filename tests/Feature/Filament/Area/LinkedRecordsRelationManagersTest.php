<?php

namespace Tests\Feature\Filament\Area;

use App\Filament\Admin\Clusters\Area\RelationManagers\Linked\LinkedRecordsRelationManager;
use App\Filament\Admin\Clusters\Area\RelationManagers\Linked\LinkedRelationManagers;
use App\Filament\Admin\Clusters\Area\RelationManagers\Linked\LinkedSystemUsersRelationManager;
use App\Filament\Admin\Clusters\Area\RelationManagers\Linked\LinkedSystemUsersRoverGroupIDRelationManager;
use App\Filament\Admin\Clusters\Area\Resources\Districts\DistrictResource;
use App\Filament\Admin\Clusters\Area\Resources\Groups\GroupResource;
use App\Filament\Admin\Clusters\Area\Resources\Groups\Pages\ViewGroup;
use App\Filament\Admin\Clusters\Area\Resources\Regions\Pages\ViewRegion;
use App\Filament\Admin\Clusters\Area\Resources\Regions\RegionResource;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use App\Services\Areas\AreaReferenceMap;
use App\Settings\GeneralSettings;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class LinkedRecordsRelationManagersTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    /**
     * @return array<string, array{class-string, class-string}>
     */
    public static function levels(): array
    {
        return [
            'region' => [Region::class, RegionResource::class],
            'district' => [District::class, DistrictResource::class],
            'group' => [Group::class, GroupResource::class],
        ];
    }

    #[Test]
    #[DataProvider('levels')]
    public function every_referencing_column_is_covered_by_exactly_one_relation_manager(string $modelClass, string $resourceClass): void
    {
        $registered = array_map(
            fn (string|RelationManagerConfiguration $manager): string => $manager instanceof RelationManagerConfiguration ? $manager->relationManager : $manager,
            $resourceClass::getRelations(),
        );

        $this->assertSame(count($registered), count(array_unique($registered)), 'A relation manager is registered twice.');

        foreach (AreaReferenceMap::for($modelClass) as $table => $columns) {
            foreach ($columns as $column) {
                if (in_array($table, AreaReferenceMap::TABLES_WITHOUT_MODELS, true)) {
                    continue;
                }

                if (LinkedRelationManagers::isBespoke($modelClass, $table, $column)) {
                    continue;
                }

                $isExtra = in_array($column, AreaReferenceMap::extraFor($modelClass)[$table] ?? [], true);
                $class = LinkedRelationManagers::className($table, $isExtra ? $column : null);

                $this->assertTrue(class_exists($class), "{$class} is missing for {$table}.{$column}.");
                $this->assertTrue(is_subclass_of($class, LinkedRecordsRelationManager::class));
                $this->assertContains($class, $registered, "{$class} is not registered on {$resourceClass}.");
                $this->assertSame($table, $class::getLinkedTable());

                $relationship = (new $modelClass)->{LinkedRelationManagers::relationshipName($table, $isExtra ? $column : null)}();

                $this->assertInstanceOf(HasMany::class, $relationship);
                $this->assertSame($table, $relationship->getRelated()->getTable());
                $this->assertSame($column, $relationship->getForeignKeyName());
            }
        }
    }

    #[Test]
    public function bespoke_pairs_map_to_a_real_relationship_on_the_model(): void
    {
        $this->assertSame('regionID', (new Region)->districts()->getForeignKeyName());
        $this->assertSame('assoc_to_region', (new Region)->groups()->getForeignKeyName());
        $this->assertSame('regionID', (new Region)->roleAttachments()->getForeignKeyName());
        $this->assertSame('assoc_to_district', (new District)->groups()->getForeignKeyName());
        $this->assertSame('districtID', (new District)->roleAttachments()->getForeignKeyName());
        $this->assertSame('assocToGroup', (new Group)->cubPacks()->getForeignKeyName());
        $this->assertSame('assocToGroup', (new Group)->committees()->getForeignKeyName());
        $this->assertSame('groupID', (new Group)->roleAttachments()->getForeignKeyName());
    }

    #[Test]
    public function a_linked_tab_is_hidden_when_empty_and_shown_with_a_badge_when_rows_exist(): void
    {
        $region = Region::factory()->create();

        $this->assertFalse(LinkedSystemUsersRelationManager::canViewForRecord($region, ViewRegion::class));

        SystemUser::factory()->count(2)->create(['assoc_to_region' => $region->id]);

        resolve(\App\Services\Areas\AreaDeletionGuard::class)->forget($region);

        $this->assertTrue(LinkedSystemUsersRelationManager::canViewForRecord($region, ViewRegion::class));
        $this->assertSame('2', LinkedSystemUsersRelationManager::getBadge($region, ViewRegion::class));
    }

    #[Test]
    public function a_secondary_column_tab_only_shows_when_that_column_matches(): void
    {
        $group = Group::factory()->create();
        SystemUser::factory()->create(['assoc_to_group' => $group->id]);

        $this->assertTrue(LinkedSystemUsersRelationManager::canViewForRecord($group, ViewGroup::class));
        $this->assertFalse(LinkedSystemUsersRoverGroupIDRelationManager::canViewForRecord($group, ViewGroup::class));
    }

    #[Test]
    public function a_linked_tab_lists_the_rows_and_links_to_their_admin_resource(): void
    {
        $region = Region::factory()->create();
        $user = SystemUser::factory()->create(['assoc_to_region' => $region->id]);
        $otherUser = SystemUser::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(LinkedSystemUsersRelationManager::class, ['ownerRecord' => $region, 'pageClass' => ViewRegion::class])
            ->assertCanSeeTableRecords([$user])
            ->assertCanNotSeeTableRecords([$otherUser])
            ->assertTableColumnExists('username')
            ->assertSee(UserResource::getUrl('view', ['record' => $user]));
    }

    #[Test]
    public function the_view_page_shows_linked_tabs_only_for_tables_with_rows(): void
    {
        $region = Region::factory()->create();
        SystemUser::factory()->create(['assoc_to_region' => $region->id]);

        $this->actingAs($this->superAdmin)
            ->get(RegionResource::getUrl('view', ['record' => $region]))
            ->assertOk()
            ->assertSee('Users (home area)')
            ->assertDontSee('Advancement Cubs');
    }
}

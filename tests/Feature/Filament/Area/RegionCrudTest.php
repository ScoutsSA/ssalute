<?php

namespace Tests\Feature\Filament\Area;

use App\Filament\Admin\Clusters\Area\Resources\Regions\Pages\CreateRegion;
use App\Filament\Admin\Clusters\Area\Resources\Regions\Pages\EditRegion;
use App\Filament\Admin\Clusters\Area\Resources\Regions\Pages\ListRegions;
use App\Filament\Admin\Clusters\Area\Resources\Regions\Pages\ViewRegion;
use App\Filament\Admin\Clusters\Area\Resources\Regions\RegionResource;
use App\Models\District;
use App\Models\GroupAccount;
use App\Models\Region;
use App\Models\SystemCountryName;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Settings\GeneralSettings;
use Filament\Actions\Testing\TestAction;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class RegionCrudTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();

        SystemCountryName::factory()->create(['country_id' => 196, 'country_code' => 'ZA', 'country_name' => 'South Africa']);
    }

    #[Test]
    public function list_page_offers_a_create_action(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ListRegions::class)
            ->assertActionExists('create');
    }

    #[Test]
    public function a_region_can_be_created_with_every_column(): void
    {
        $account = GroupAccount::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(CreateRegion::class)
            ->fillForm([
                'name' => 'Northern Cape',
                'short' => 'NC',
                'position' => 7,
                'countryID' => 196,
                'accountID' => $account->id,
                'active' => true,
                'usingAMS' => false,
                'censusDone' => false,
                'description' => 'Test description',
                'phys_address' => '1 Test Street',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('regions', [
            'name' => 'Northern Cape',
            'short' => 'NC',
            'position' => 7,
            'countryID' => 196,
            'accountID' => $account->id,
            'active' => 1,
            'usingAMS' => 0,
            'censusDone' => 0,
            'description' => 'Test description',
            'phys_address' => '1 Test Street',
        ]);
    }

    #[Test]
    public function a_region_created_with_the_defaults_persists_the_country_and_empty_text_columns(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(CreateRegion::class)
            ->fillForm(['name' => 'Free State', 'short' => 'FS'])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('regions', ['name' => 'Free State', 'countryID' => 196, 'accountID' => 0, 'description' => '', 'phys_address' => '']);
    }

    #[Test]
    public function region_name_and_short_code_must_be_unique(): void
    {
        Region::factory()->create(['name' => 'Gauteng', 'short' => 'GP']);

        Livewire::actingAs($this->superAdmin)
            ->test(CreateRegion::class)
            ->fillForm(['name' => 'Gauteng', 'short' => 'GP'])
            ->call('create')
            ->assertHasFormErrors(['name' => 'unique', 'short' => 'unique']);
    }

    #[Test]
    public function a_region_can_be_edited_including_the_newly_exposed_columns(): void
    {
        $region = Region::factory()->create(['name' => 'Old', 'short' => 'OLD', 'position' => 0, 'accountID' => 0, 'censusDone' => 1]);
        $account = GroupAccount::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(EditRegion::class, ['record' => $region->id])
            ->fillForm([
                'name' => 'New Name',
                'short' => 'NEW',
                'position' => 3,
                'usingAMS' => false,
                'countryID' => 196,
                'accountID' => $account->id,
                'censusDone' => false,
                'description' => 'Updated',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('regions', [
            'id' => $region->id,
            'name' => 'New Name',
            'short' => 'NEW',
            'position' => 3,
            'usingAMS' => 0,
            'accountID' => $account->id,
            'censusDone' => 0,
            'description' => 'Updated',
        ]);
    }

    #[Test]
    public function editing_a_region_ignores_its_own_name_for_uniqueness(): void
    {
        $region = Region::factory()->create(['name' => 'Same', 'short' => 'SM']);

        Livewire::actingAs($this->superAdmin)
            ->test(EditRegion::class, ['record' => $region->id])
            ->fillForm(['name' => 'Same', 'short' => 'SM', 'position' => 1])
            ->call('save')
            ->assertHasNoFormErrors();
    }

    #[Test]
    public function clearing_the_account_stores_zero(): void
    {
        $region = Region::factory()->create(['accountID' => 5]);

        Livewire::actingAs($this->superAdmin)
            ->test(EditRegion::class, ['record' => $region->id])
            ->fillForm(['accountID' => null])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('regions', ['id' => $region->id, 'accountID' => 0]);
    }

    #[Test]
    public function an_unreferenced_region_can_be_deleted_from_the_edit_page(): void
    {
        $region = Region::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(EditRegion::class, ['record' => $region->id])
            ->callAction('delete')
            ->assertHasNoErrors()
            ->assertRedirect(RegionResource::getUrl('index'));

        $this->assertDatabaseMissing('regions', ['id' => $region->id]);
    }

    #[Test]
    public function an_unreferenced_region_can_be_deleted_from_the_view_page_and_the_list(): void
    {
        $fromView = Region::factory()->create();
        $fromList = Region::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewRegion::class, ['record' => $fromView->id])
            ->callAction('delete')
            ->assertHasNoErrors();

        Livewire::actingAs($this->superAdmin)
            ->test(ListRegions::class)
            ->callAction(TestAction::make('delete')->table($fromList))
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('regions', ['id' => $fromView->id]);
        $this->assertDatabaseMissing('regions', ['id' => $fromList->id]);
    }

    #[Test]
    public function deleting_a_region_with_districts_is_refused_with_a_notification(): void
    {
        $region = Region::factory()->create(['name' => 'Gauteng']);
        District::factory()->forRegion($region)->create();

        Livewire::actingAs($this->superAdmin)
            ->test(EditRegion::class, ['record' => $region->id])
            ->callAction('delete')
            ->assertNotified("Cannot delete Gauteng (#{$region->id})")
            ->assertNoRedirect();

        $this->assertDatabaseHas('regions', ['id' => $region->id]);
    }

    #[Test]
    public function deleting_a_region_with_a_role_attachment_or_a_user_is_refused(): void
    {
        $withRole = Region::factory()->create();
        SystemUsersOtherRole::factory()->create(['regionID' => $withRole->id]);

        $withUser = Region::factory()->create();
        SystemUser::factory()->create(['assoc_to_region' => $withUser->id]);

        Livewire::actingAs($this->superAdmin)
            ->test(ViewRegion::class, ['record' => $withRole->id])
            ->callAction('delete')
            ->assertNotified();

        Livewire::actingAs($this->superAdmin)
            ->test(ListRegions::class)
            ->callAction(TestAction::make('delete')->table($withUser))
            ->assertNotified();

        $this->assertDatabaseHas('regions', ['id' => $withRole->id]);
        $this->assertDatabaseHas('regions', ['id' => $withUser->id]);
    }

    #[Test]
    public function the_view_page_lists_the_linked_records_that_block_deletion(): void
    {
        $region = Region::factory()->create();
        District::factory()->count(2)->forRegion($region)->create();

        $this->actingAs($this->superAdmin)
            ->get(RegionResource::getUrl('view', ['record' => $region]))
            ->assertOk()
            ->assertSee('Districts: 2');
    }

    #[Test]
    public function a_non_super_admin_cannot_reach_the_create_page(): void
    {
        $this->actingAs(SystemUser::factory()->withRole()->create())
            ->get(RegionResource::getUrl('create'))
            ->assertForbidden();
    }
}

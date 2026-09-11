<?php

namespace Tests\Feature\Filament\Area;

use App\Filament\Admin\Clusters\Area\Resources\Districts\Pages\CreateDistrict;
use App\Filament\Admin\Clusters\Area\Resources\Districts\Pages\EditDistrict;
use App\Filament\Admin\Clusters\Area\Resources\Districts\Pages\ListDistricts;
use App\Filament\Admin\Clusters\Area\Resources\Districts\Pages\ViewDistrict;
use App\Models\District;
use App\Models\Group;
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

class DistrictCrudTest extends SdCoreTestCase
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
            ->test(ListDistricts::class)
            ->assertActionExists('create');
    }

    #[Test]
    public function a_district_can_be_created_and_is_stamped_with_the_creator(): void
    {
        $region = Region::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(CreateDistrict::class)
            ->fillForm([
                'regionID' => $region->id,
                'name' => 'Sandton',
                'countryID' => 196,
                'active' => true,
                'censusDone' => false,
                'description' => 'Northern suburbs',
                'phys_address' => 'Sandton',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('districts', [
            'regionID' => $region->id,
            'name' => 'Sandton',
            'countryID' => 196,
            'superDistrictID' => 0,
            'accountID' => 0,
            'active' => 1,
            'censusDone' => 0,
            'createdby' => $this->superAdmin->id,
            'modifiedby' => $this->superAdmin->id,
        ]);

        $this->assertNotNull(District::query()->where('name', 'Sandton')->sole()->created);
    }

    #[Test]
    public function district_name_must_be_unique_within_its_region_only(): void
    {
        $region = Region::factory()->create();
        $otherRegion = Region::factory()->create();
        District::factory()->forRegion($region)->create(['name' => 'Central']);

        Livewire::actingAs($this->superAdmin)
            ->test(CreateDistrict::class)
            ->fillForm(['regionID' => $region->id, 'name' => 'Central'])
            ->call('create')
            ->assertHasFormErrors(['name' => 'unique']);

        Livewire::actingAs($this->superAdmin)
            ->test(CreateDistrict::class)
            ->fillForm(['regionID' => $otherRegion->id, 'name' => 'Central'])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('districts', ['regionID' => $otherRegion->id, 'name' => 'Central']);
    }

    #[Test]
    public function a_district_can_be_edited_including_the_newly_exposed_columns(): void
    {
        $district = District::factory()->create(['createdby' => 9]);
        $newRegion = Region::factory()->create();
        $account = GroupAccount::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(EditDistrict::class, ['record' => $district->id])
            ->fillForm([
                'regionID' => $newRegion->id,
                'name' => 'Renamed',
                'countryID' => 196,
                'accountID' => $account->id,
                'active' => false,
                'censusDone' => false,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('districts', [
            'id' => $district->id,
            'regionID' => $newRegion->id,
            'name' => 'Renamed',
            'accountID' => $account->id,
            'active' => 0,
            'censusDone' => 0,
            'createdby' => 9,
            'modifiedby' => $this->superAdmin->id,
        ]);
    }

    #[Test]
    public function an_unreferenced_district_can_be_deleted(): void
    {
        $district = District::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(EditDistrict::class, ['record' => $district->id])
            ->callAction('delete')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('districts', ['id' => $district->id]);
    }

    #[Test]
    public function deleting_a_district_with_groups_roles_or_users_is_refused(): void
    {
        $withGroup = District::factory()->create(['name' => 'Busy']);
        Group::factory()->forDistrict($withGroup)->create();

        $withRole = District::factory()->create();
        SystemUsersOtherRole::factory()->create(['districtID' => $withRole->id]);

        $withUser = District::factory()->create();
        SystemUser::factory()->create(['assoc_to_district' => $withUser->id]);

        Livewire::actingAs($this->superAdmin)
            ->test(EditDistrict::class, ['record' => $withGroup->id])
            ->callAction('delete')
            ->assertNotified("Cannot delete Busy (#{$withGroup->id})");

        Livewire::actingAs($this->superAdmin)
            ->test(ViewDistrict::class, ['record' => $withRole->id])
            ->callAction('delete')
            ->assertNotified();

        Livewire::actingAs($this->superAdmin)
            ->test(ListDistricts::class)
            ->callAction(TestAction::make('delete')->table($withUser))
            ->assertNotified();

        $this->assertDatabaseHas('districts', ['id' => $withGroup->id]);
        $this->assertDatabaseHas('districts', ['id' => $withRole->id]);
        $this->assertDatabaseHas('districts', ['id' => $withUser->id]);
    }
}

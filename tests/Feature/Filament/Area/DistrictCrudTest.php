<?php

namespace Tests\Feature\Filament\Area;

use App\Filament\Admin\Clusters\Area\Resources\Districts\Pages\CreateDistrict;
use App\Filament\Admin\Clusters\Area\Resources\Districts\Pages\EditDistrict;
use App\Filament\Admin\Clusters\Area\Resources\Districts\Pages\ListDistricts;
use App\Filament\Admin\Clusters\Area\Resources\Districts\Pages\ViewDistrict;
use App\Models\District;
use App\Models\DistrictsSuper;
use App\Models\Group;
use App\Models\GroupAccount;
use App\Models\Region;
use App\Models\SystemCountryName;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Settings\GeneralSettings;
use Filament\Actions\Testing\TestAction;
use Filament\Forms\Components\Select;
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
    public function deleting_a_referenced_district_without_acknowledging_the_consequences_is_refused(): void
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
            ->assertHasActionErrors(['acknowledged', 'confirmation']);

        Livewire::actingAs($this->superAdmin)
            ->test(ViewDistrict::class, ['record' => $withRole->id])
            ->callAction('delete')
            ->assertHasActionErrors(['acknowledged', 'confirmation']);

        Livewire::actingAs($this->superAdmin)
            ->test(ListDistricts::class)
            ->callAction(TestAction::make('delete')->table($withUser))
            ->assertHasActionErrors(['acknowledged', 'confirmation']);

        $this->assertDatabaseHas('districts', ['id' => $withGroup->id]);
        $this->assertDatabaseHas('districts', ['id' => $withRole->id]);
        $this->assertDatabaseHas('districts', ['id' => $withUser->id]);
    }

    #[Test]
    public function a_referenced_district_can_be_force_deleted_and_its_groups_are_left_pointing_at_it(): void
    {
        $district = District::factory()->create(['name' => 'Sandton']);
        $group = Group::factory()->forDistrict($district)->create();

        Livewire::actingAs($this->superAdmin)
            ->test(EditDistrict::class, ['record' => $district->id])
            ->callAction('delete', data: ['acknowledged' => true, 'confirmation' => 'Sandton'])
            ->assertHasNoActionErrors()
            ->assertNotified("Forced delete of Sandton (#{$district->id})");

        $this->assertDatabaseMissing('districts', ['id' => $district->id]);
        $this->assertDatabaseHas('groups', ['id' => $group->id, 'assoc_to_district' => $district->id]);
    }

    #[Test]
    public function a_reference_created_after_the_delete_dialog_opened_stops_the_delete_with_a_notification(): void
    {
        $district = District::factory()->create(['name' => 'Quiet']);

        $component = Livewire::actingAs($this->superAdmin)
            ->test(EditDistrict::class, ['record' => $district->id])
            ->mountAction('delete');

        Group::factory()->forDistrict($district)->create();

        $component
            ->callMountedAction()
            ->assertActionHalted('delete')
            ->assertNotified("Quiet (#{$district->id}) was not deleted");

        $this->assertDatabaseHas('districts', ['id' => $district->id]);
    }

    #[Test]
    public function a_district_whose_super_district_is_in_another_region_can_still_be_edited(): void
    {
        $district = District::factory()->create();
        $strayRegion = Region::factory()->create(['name' => 'Elsewhere']);
        $straySuperDistrict = DistrictsSuper::query()->create([
            'regionID' => $strayRegion->id,
            'name' => 'Stray Super',
            'description' => '',
            'created' => now(),
            'createdby' => 1,
        ]);
        District::query()->whereKey($district->id)->update(['superDistrictID' => $straySuperDistrict->id]);

        Livewire::actingAs($this->superAdmin)
            ->test(EditDistrict::class, ['record' => $district->id])
            ->assertFormFieldExists('superDistrictID', function (Select $select) use ($straySuperDistrict, $strayRegion): bool {
                $label = $select->getOptions()[$straySuperDistrict->id] ?? '';

                return str_contains($label, 'Stray Super') && str_contains($label, "Elsewhere (#{$strayRegion->id})") && str_contains($label, 'not this region');
            })
            ->fillForm(['name' => 'Renamed Only'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('districts', ['id' => $district->id, 'name' => 'Renamed Only', 'superDistrictID' => $straySuperDistrict->id]);
    }

    #[Test]
    public function an_acknowledged_force_delete_whose_references_were_cleared_meanwhile_is_a_plain_delete(): void
    {
        $district = District::factory()->create(['name' => 'Emptied']);
        $group = Group::factory()->forDistrict($district)->create();

        $component = Livewire::actingAs($this->superAdmin)
            ->test(EditDistrict::class, ['record' => $district->id])
            ->mountAction('delete')
            ->setActionData(['acknowledged' => true, 'confirmation' => 'Emptied']);

        $group->delete();

        $component
            ->callMountedAction()
            ->assertHasNoActionErrors()
            ->assertNotNotified("Forced delete of Emptied (#{$district->id})");

        $this->assertDatabaseMissing('districts', ['id' => $district->id]);
    }
}

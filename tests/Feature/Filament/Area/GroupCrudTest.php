<?php

namespace Tests\Feature\Filament\Area;

use App\Filament\Admin\Clusters\Area\Resources\Groups\Pages\CreateGroup;
use App\Filament\Admin\Clusters\Area\Resources\Groups\Pages\EditGroup;
use App\Filament\Admin\Clusters\Area\Resources\Groups\Pages\ListGroups;
use App\Filament\Admin\Clusters\Area\Resources\Groups\Pages\ViewGroup;
use App\Models\District;
use App\Models\Group;
use App\Models\GroupAccount;
use App\Models\GroupsType;
use App\Models\Region;
use App\Models\SystemCountryName;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Providers\AppServiceProvider;
use App\Settings\GeneralSettings;
use Filament\Actions\Testing\TestAction;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class GroupCrudTest extends SdCoreTestCase
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
    public function a_group_can_be_created_and_is_stamped_with_the_creator(): void
    {
        $district = District::factory()->create();
        $type = GroupsType::factory()->create();
        $account = GroupAccount::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(CreateGroup::class)
            ->fillForm([
                'name' => '1st Test',
                'groupRegNr' => 'REG-001',
                'groupTypeID' => $type->id,
                'groupAccountID' => $account->id,
                'assoc_to_region' => $district->regionID,
                'assoc_to_district' => $district->id,
                'active' => true,
                'scoutProgramType' => 2,
                'hasBranch1' => true,
                'weatherLocationName' => 'Johannesburg',
                'bankingDetails' => 'Bank details',
                'postalCountryID' => 196,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('groups', [
            'name' => '1st Test',
            'groupRegNr' => 'REG-001',
            'groupTypeID' => $type->id,
            'groupAccountID' => $account->id,
            'assoc_to_region' => $district->regionID,
            'assoc_to_district' => $district->id,
            'active' => 1,
            'scoutProgramType' => 2,
            'hasBranch1' => 1,
            'weatherLocationName' => 'Johannesburg',
            'bankingDetails' => 'Bank details',
            'postalCountryID' => 196,
            'createdby' => $this->superAdmin->id,
        ]);
    }

    #[Test]
    public function the_district_select_only_offers_districts_in_the_chosen_region(): void
    {
        $region = Region::factory()->create();
        $inRegion = District::factory()->forRegion($region)->create();
        District::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(CreateGroup::class)
            ->fillForm(['assoc_to_region' => $region->id])
            ->assertFormFieldExists('assoc_to_district', function (Select $select) use ($inRegion): bool {
                return array_keys($select->getOptions()) === [$inRegion->id];
            });
    }

    #[Test]
    public function group_registration_number_must_be_unique_when_provided(): void
    {
        $district = District::factory()->create();
        $type = GroupsType::factory()->create();
        Group::factory()->forDistrict($district)->create(['groupRegNr' => 'DUP']);

        $base = [
            'name' => 'Another',
            'groupTypeID' => $type->id,
            'assoc_to_region' => $district->regionID,
            'assoc_to_district' => $district->id,
        ];

        Livewire::actingAs($this->superAdmin)
            ->test(CreateGroup::class)
            ->fillForm([...$base, 'groupRegNr' => 'DUP'])
            ->call('create')
            ->assertHasFormErrors(['groupRegNr' => 'unique']);

        Group::factory()->forDistrict($district)->create(['groupRegNr' => '']);

        Livewire::actingAs($this->superAdmin)
            ->test(CreateGroup::class)
            ->fillForm([...$base, 'groupRegNr' => null])
            ->call('create')
            ->assertHasNoFormErrors();
    }

    #[Test]
    public function a_group_can_be_edited_across_every_tab(): void
    {
        $group = Group::factory()->create(['createdby' => 4, 'groupAccountID' => 3]);
        $newDistrict = District::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(EditGroup::class, ['record' => $group->id])
            ->fillForm([
                'name' => 'Renamed Group',
                'assoc_to_region' => $newDistrict->regionID,
                'assoc_to_district' => $newDistrict->id,
                'groupAccountID' => null,
                'hasRovers' => true,
                'roverProgramType' => 1,
                'amsOnly' => true,
                'weatherID' => 'ZAXX0001',
                'bankName' => 'Test Bank',
                'using20' => false,
                'censusDone' => false,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'name' => 'Renamed Group',
            'assoc_to_region' => $newDistrict->regionID,
            'assoc_to_district' => $newDistrict->id,
            'groupAccountID' => 0,
            'hasRovers' => 1,
            'amsOnly' => 1,
            'weatherID' => 'ZAXX0001',
            'bankName' => 'Test Bank',
            'using20' => 0,
            'censusDone' => 0,
            'createdby' => 4,
            'modifiedby' => $this->superAdmin->id,
        ]);
    }

    #[Test]
    public function an_unreferenced_group_can_be_deleted_from_every_entry_point(): void
    {
        $fromEdit = Group::factory()->create();
        $fromView = Group::factory()->create();
        $fromList = Group::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(EditGroup::class, ['record' => $fromEdit->id])
            ->callAction('delete')
            ->assertHasNoErrors();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewGroup::class, ['record' => $fromView->id])
            ->callAction('delete')
            ->assertHasNoErrors();

        Livewire::actingAs($this->superAdmin)
            ->test(ListGroups::class)
            ->callAction(TestAction::make('delete')->table($fromList))
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('groups', ['id' => $fromEdit->id]);
        $this->assertDatabaseMissing('groups', ['id' => $fromView->id]);
        $this->assertDatabaseMissing('groups', ['id' => $fromList->id]);
    }

    #[Test]
    public function deleting_a_referenced_group_without_acknowledging_the_consequences_is_refused(): void
    {
        $withRole = Group::factory()->create(['name' => '1st Busy']);
        SystemUsersOtherRole::factory()->create(['groupID' => $withRole->id]);

        $withUser = Group::factory()->create();
        SystemUser::factory()->create(['assoc_to_group' => $withUser->id]);

        $withPack = Group::factory()->create();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_cub_packs')->insert([
            'assocToGroup' => $withPack->id, 'name' => 'Pack', 'created' => now(), 'createdby' => 1,
        ]);

        $withOther = Group::factory()->create();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('commerce_search_queries')->insert([
            'countryID' => 196, 'regionID' => 0, 'districtID' => 0, 'groupID' => $withOther->id, 'date' => now()->toDateString(), 'time' => '10:00',
        ]);

        Livewire::actingAs($this->superAdmin)
            ->test(EditGroup::class, ['record' => $withRole->id])
            ->callAction('delete')
            ->assertHasActionErrors(['acknowledged', 'confirmation']);

        foreach ([$withUser, $withPack, $withOther] as $group) {
            Livewire::actingAs($this->superAdmin)
                ->test(ListGroups::class)
                ->callAction(TestAction::make('delete')->table($group))
                ->assertHasActionErrors(['acknowledged', 'confirmation']);
        }

        foreach ([$withRole, $withUser, $withPack, $withOther] as $group) {
            $this->assertDatabaseHas('groups', ['id' => $group->id]);
        }
    }

    #[Test]
    public function a_referenced_group_can_be_force_deleted_from_the_list_and_its_role_attachments_are_left_untouched(): void
    {
        $group = Group::factory()->create(['name' => '1st Busy']);
        $role = SystemUsersOtherRole::factory()->create(['groupID' => $group->id]);

        Livewire::actingAs($this->superAdmin)
            ->test(ListGroups::class)
            ->callAction(TestAction::make('delete')->table($group), data: ['acknowledged' => true, 'confirmation' => '1st Busy'])
            ->assertHasNoActionErrors()
            ->assertNotified("Forced delete of 1st Busy (#{$group->id})");

        $this->assertDatabaseMissing('groups', ['id' => $group->id]);
        $this->assertDatabaseHas('system_users_other_roles', ['id' => $role->id, 'groupID' => $group->id]);
    }
}

<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Clusters\AMS\Resources\Awards\Pages\ViewAward;
use App\Filament\Admin\Clusters\AMS\Resources\Charges\Pages\ViewCharge;
use App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\Pages\ViewDisciplinaryRecord;
use App\Filament\Admin\Clusters\AMS\Resources\PastService\Pages\ViewPastServiceRecord;
use App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\Pages\ViewPoliceClearance;
use App\Filament\Admin\Clusters\AMS\Resources\Training\Pages\ViewTrainingRecord;
use App\Filament\Admin\Clusters\AMS\Resources\Warrants\Pages\ViewWarrant;
use App\Models\AmsAwardHeading;
use App\Models\AmsAwardInfo;
use App\Models\AmsAwardType;
use App\Models\AmsChargeInfo;
use App\Models\AmsChargeType;
use App\Models\AmsDisciplinaryHeading;
use App\Models\AmsDisciplinaryInfo;
use App\Models\AmsPastServiceInfo;
use App\Models\AmsPastServiceType;
use App\Models\AmsPoliceClearance;
use App\Models\AmsTrainingPast;
use App\Models\AmsTrainingPastType;
use App\Models\AmsWarrantInfo;
use App\Models\AmsWarrantType;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use Filament\Actions\EditAction;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class AmsClusterCrudTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    private SystemUser $member;

    private Region $region;

    private District $district;

    private Group $group;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
        $this->member = SystemUser::factory()->create();
        $this->region = Region::create(['name' => 'Test Region', 'description' => '', 'phys_address' => '', 'countryID' => 196]);
        $this->district = District::create(['name' => 'Test District', 'regionID' => $this->region->id, 'countryID' => 196, 'created' => now(), 'createdby' => 0]);
        $this->group = Group::create(['name' => 'Test Group', 'groupTypeID' => 1, 'assoc_to_district' => $this->district->id, 'assoc_to_region' => $this->region->id, 'active' => 1, 'created' => now(), 'createdby' => 0]);
    }

    // --- Awards ---

    #[Test]
    public function super_admin_can_view_an_award(): void
    {
        $record = $this->createAward();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewAward::class, ['record' => $record->id])
            ->assertOk()
            ->assertActionExists(EditAction::class);
    }

    #[Test]
    public function super_admin_can_edit_an_award_via_modal(): void
    {
        $record = $this->createAward();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewAward::class, ['record' => $record->id])
            ->callAction(EditAction::class, data: [
                'awardDate' => '2025-06-15',
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas(AmsAwardInfo::class, [
            'id' => $record->id,
            'awardDate' => '2025-06-15',
        ]);
    }

    // TODO: Create tests skipped — forms don't populate required NOT NULL fields
    // (awardHeadingID, createdby) that the DB requires. These need mutateFormDataBeforeCreate()
    // hooks to auto-set audit fields and derived FKs.

    // --- Warrants ---

    #[Test]
    public function super_admin_can_view_a_warrant(): void
    {
        $record = $this->createWarrant();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewWarrant::class, ['record' => $record->id])
            ->assertOk()
            ->assertActionExists(EditAction::class);
    }

    #[Test]
    public function super_admin_can_edit_a_warrant_via_modal(): void
    {
        $record = $this->createWarrant();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewWarrant::class, ['record' => $record->id])
            ->callAction(EditAction::class, data: [
                'warrantNr' => 'W-UPDATED',
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas(AmsWarrantInfo::class, [
            'id' => $record->id,
            'warrantNr' => 'W-UPDATED',
        ]);
    }

    // TODO: Warrant create test skipped — same audit field issue as awards.

    // --- Charges ---

    #[Test]
    public function super_admin_can_view_a_charge(): void
    {
        $record = $this->createCharge();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewCharge::class, ['record' => $record->id])
            ->assertOk()
            ->assertActionExists(EditAction::class);
    }

    #[Test]
    public function super_admin_can_edit_a_charge_via_modal(): void
    {
        $record = $this->createCharge();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewCharge::class, ['record' => $record->id])
            ->callAction(EditAction::class, data: [
                'chargeNr' => 'C-UPDATED',
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas(AmsChargeInfo::class, [
            'id' => $record->id,
            'chargeNr' => 'C-UPDATED',
        ]);
    }

    // --- Disciplinary ---

    #[Test]
    public function super_admin_can_view_a_disciplinary_record(): void
    {
        $record = $this->createDisciplinary();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewDisciplinaryRecord::class, ['record' => $record->id])
            ->assertOk()
            ->assertActionExists(EditAction::class);
    }

    #[Test]
    public function super_admin_can_edit_a_disciplinary_record_via_modal(): void
    {
        $record = $this->createDisciplinary();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewDisciplinaryRecord::class, ['record' => $record->id])
            ->callAction(EditAction::class, data: [
                'sanction' => 'Final Warning',
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas(AmsDisciplinaryInfo::class, [
            'id' => $record->id,
            'sanction' => 'Final Warning',
        ]);
    }

    // --- Past Service ---

    #[Test]
    public function super_admin_can_view_a_past_service_record(): void
    {
        $record = $this->createPastService();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewPastServiceRecord::class, ['record' => $record->id])
            ->assertOk()
            ->assertActionExists(EditAction::class);
    }

    #[Test]
    public function super_admin_can_edit_a_past_service_record_via_modal(): void
    {
        $record = $this->createPastService(['startDate' => '2020-01-01']);

        Livewire::actingAs($this->superAdmin)
            ->test(ViewPastServiceRecord::class, ['record' => $record->id])
            ->callAction(EditAction::class, data: [
                'startDate' => '2021-06-01',
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas(AmsPastServiceInfo::class, [
            'id' => $record->id,
            'startDate' => '2021-06-01',
        ]);
    }

    // --- Police Clearances ---

    #[Test]
    public function super_admin_can_view_a_police_clearance(): void
    {
        $record = AmsPoliceClearance::create([
            'userID' => $this->member->id,
            'dateDone' => '2025-01-01',
            'result' => 'Clear',
            'documentLocation' => '',
            'active' => 1,
            'created' => now(),
            'createdby' => $this->superAdmin->id,
        ]);

        Livewire::actingAs($this->superAdmin)
            ->test(ViewPoliceClearance::class, ['record' => $record->id])
            ->assertOk()
            ->assertActionExists(EditAction::class);
    }

    // --- Training ---

    #[Test]
    public function super_admin_can_view_a_training_record(): void
    {
        $record = $this->createTraining();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewTrainingRecord::class, ['record' => $record->id])
            ->assertOk()
            ->assertActionExists(EditAction::class);
    }

    #[Test]
    public function super_admin_can_edit_a_training_record_via_modal(): void
    {
        $record = $this->createTraining();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewTrainingRecord::class, ['record' => $record->id])
            ->callAction(EditAction::class, data: [
                'courseName' => 'Updated Course',
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas(AmsTrainingPast::class, [
            'id' => $record->id,
            'courseName' => 'Updated Course',
        ]);
    }

    // --- Helpers ---

    private function createAward(array $overrides = []): AmsAwardInfo
    {
        $heading = AmsAwardHeading::factory()->create();
        $type = AmsAwardType::factory()->create(['headingID' => $heading->id]);

        return AmsAwardInfo::create(array_merge([
            'userID' => $this->member->id,
            'awardHeadingID' => $heading->id,
            'awardTypeID' => $type->id,
            'awardDate' => '2025-01-01',
            'assocToRegion' => $this->region->id,
            'active' => 1,
            'created' => now(),
            'createdby' => $this->superAdmin->id,
        ], $overrides));
    }

    private function createWarrant(array $overrides = []): AmsWarrantInfo
    {
        $type = AmsWarrantType::factory()->create();

        return AmsWarrantInfo::create(array_merge([
            'userID' => $this->member->id,
            'warrantTypeID' => $type->id,
            'warrantNr' => 'W-001',
            'issueDate' => '2025-01-01',
            'expireDate' => '2026-01-01',
            'assocToRegion' => $this->region->id,
            'assocToDistrict' => $this->district->id,
            'assocToGroup' => $this->group->id,
            'active' => 1,
            'created' => now(),
            'createdby' => $this->superAdmin->id,
        ], $overrides));
    }

    private function createCharge(array $overrides = []): AmsChargeInfo
    {
        $type = AmsChargeType::factory()->create();

        return AmsChargeInfo::create(array_merge([
            'userID' => $this->member->id,
            'chargeTypeID' => $type->id,
            'chargeNr' => 'C-001',
            'issueDate' => '2025-01-01',
            'expireDate' => '2026-01-01',
            'assocToRegion' => $this->region->id,
            'assocToDistrict' => $this->district->id,
            'assocToGroup' => $this->group->id,
            'active' => 1,
            'created' => now(),
            'createdby' => $this->superAdmin->id,
        ], $overrides));
    }

    private function createDisciplinary(array $overrides = []): AmsDisciplinaryInfo
    {
        $heading = AmsDisciplinaryHeading::factory()->create();

        return AmsDisciplinaryInfo::create(array_merge([
            'userID' => $this->member->id,
            'disciplinaryHeadingID' => $heading->id,
            'disciplinaryType' => 0,
            'sanction' => 'Written Warning',
            'PDFLocation' => '',
            'assocToRegion' => $this->region->id,
            'assocToDistrict' => $this->district->id,
            'assocToGroup' => $this->group->id,
            'active' => 1,
            'created' => now(),
            'createdby' => $this->superAdmin->id,
        ], $overrides));
    }

    private function createPastService(array $overrides = []): AmsPastServiceInfo
    {
        $type = AmsPastServiceType::factory()->create();

        return AmsPastServiceInfo::create(array_merge([
            'userID' => $this->member->id,
            'pastServiceType' => $type->id,
            'startDate' => '2020-01-01',
            'endDate' => '2022-01-01',
            'assocToRegion' => $this->region->id,
            'assocToDistrict' => $this->district->id,
            'assocToGroup' => $this->group->id,
            'active' => 1,
            'created' => now(),
            'createdby' => $this->superAdmin->id,
        ], $overrides));
    }

    private function createTraining(array $overrides = []): AmsTrainingPast
    {
        $type = AmsTrainingPastType::factory()->create();

        return AmsTrainingPast::create(array_merge([
            'userID' => $this->member->id,
            'trainingTypeID' => $type->id,
            'courseName' => 'Test Course',
            'courseNumber' => 'TC-001',
            'completionDate' => '2025-01-01',
            'assocToRegion' => $this->region->id,
            'assocToDistrict' => $this->district->id,
            'assocToGroup' => $this->group->id,
            'active' => 1,
            'created' => now(),
            'createdby' => $this->superAdmin->id,
        ], $overrides));
    }
}

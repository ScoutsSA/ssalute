<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Clusters\LookupTables\Resources\AccountTypes\AccountTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\AssetConditions\AssetConditionResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\AwardHeadings\AwardHeadingResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\AwardTypes\AwardTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\ChargeTypes\ChargeTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\CommitteeTypes\CommitteeTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\CommitteeTypes\Pages\ManageCommitteeTypes;
use App\Filament\Admin\Clusters\LookupTables\Resources\CouncilTypes\CouncilTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\CubLevels\CubLevelResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\CubLevels\Pages\ManageCubLevels;
use App\Filament\Admin\Clusters\LookupTables\Resources\DisciplinaryHeadings\DisciplinaryHeadingResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\DisciplinaryHeadings\Pages\ManageDisciplinaryHeadings;
use App\Filament\Admin\Clusters\LookupTables\Resources\DocumentGroupTypes\DocumentGroupTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\DocumentTypes\DocumentTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\EventTypes\EventTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\FinancialFeeTypes\FinancialFeeTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\GroupManagementLevels\GroupManagementLevelResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\HighestEducations\HighestEducationResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\Languages\LanguageResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\MaritalStatuses\MaritalStatusResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\MeerkatLevels\MeerkatLevelResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\ParentTypes\ParentTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\PastServiceTypes\PastServiceTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\ProgramTypes\ProgramTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\ResignReasons\ResignReasonResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\RetireReasons\RetireReasonResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\RoverLevels\RoverLevelResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\RoverMeetingTypes\RoverMeetingTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\ScoutLevels\ScoutLevelResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\StarAwardTypes\StarAwardTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\SuspendReasons\SuspendReasonResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\TerminateReasons\TerminateReasonResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\Titles\TitleResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\TrainingCourseTypes\TrainingCourseTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\TrainingPastTypes\TrainingPastTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\WarrantCancellationTypes\WarrantCancellationTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\WarrantTypes\Pages\ManageWarrantTypes;
use App\Filament\Admin\Clusters\LookupTables\Resources\WarrantTypes\WarrantTypeResource;
use App\Models\AmsDisciplinaryHeading;
use App\Models\AmsWarrantType;
use App\Models\SystemAdvancementCubsLevel;
use App\Models\SystemCommitteeType;
use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class SettingsReferenceDataTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    /** @return array<string, array{class-string}> */
    public static function referenceDataResourceProvider(): array
    {
        return [
            'marital statuses' => [MaritalStatusResource::class],
            'highest educations' => [HighestEducationResource::class],
            'languages' => [LanguageResource::class],
            'committee types' => [CommitteeTypeResource::class],
            'council types' => [CouncilTypeResource::class],
            'event types' => [EventTypeResource::class],
            'titles' => [TitleResource::class],
            'parent types' => [ParentTypeResource::class],
            'group management levels' => [GroupManagementLevelResource::class],
            'account types' => [AccountTypeResource::class],
            'asset conditions' => [AssetConditionResource::class],
            'financial fee types' => [FinancialFeeTypeResource::class],
            'star award types' => [StarAwardTypeResource::class],
            'program types' => [ProgramTypeResource::class],
            'rover meeting types' => [RoverMeetingTypeResource::class],
            'award types' => [AwardTypeResource::class],
            'award headings' => [AwardHeadingResource::class],
            'warrant types' => [WarrantTypeResource::class],
            'warrant cancellation types' => [WarrantCancellationTypeResource::class],
            'document types' => [DocumentTypeResource::class],
            'document group types' => [DocumentGroupTypeResource::class],
            'charge types' => [ChargeTypeResource::class],
            'disciplinary headings' => [DisciplinaryHeadingResource::class],
            'resign reasons' => [ResignReasonResource::class],
            'retire reasons' => [RetireReasonResource::class],
            'suspend reasons' => [SuspendReasonResource::class],
            'terminate reasons' => [TerminateReasonResource::class],
            'past service types' => [PastServiceTypeResource::class],
            'training course types' => [TrainingCourseTypeResource::class],
            'training past types' => [TrainingPastTypeResource::class],
            'cub levels' => [CubLevelResource::class],
            'meerkat levels' => [MeerkatLevelResource::class],
            'scout levels' => [ScoutLevelResource::class],
            'rover levels' => [RoverLevelResource::class],
        ];
    }

    #[Test]
    #[DataProvider('referenceDataResourceProvider')]
    public function super_admin_can_access_settings_reference_data_resource(string $resourceClass): void
    {
        $url = $resourceClass::getUrl('index');

        $this->actingAs($this->superAdmin)
            ->get($url)
            ->assertOk();
    }

    #[Test]
    #[DataProvider('referenceDataResourceProvider')]
    public function regular_user_is_forbidden_from_settings_reference_data(string $resourceClass): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $url = $resourceClass::getUrl('index');

        $this->actingAs($user)
            ->get($url)
            ->assertForbidden();
    }

    #[Test]
    public function guest_is_redirected_when_accessing_settings_reference_data(): void
    {
        $url = MaritalStatusResource::getUrl('index');

        $this->get($url)
            ->assertRedirect();
    }

    // --- CommitteeType representative CRUD tests ---

    #[Test]
    public function committee_type_table_renders_records(): void
    {
        $records = SystemCommitteeType::factory()->count(3)->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ManageCommitteeTypes::class)
            ->assertOk()
            ->assertCanSeeTableRecords($records);
    }

    #[Test]
    public function committee_type_table_can_search(): void
    {
        $alpha = SystemCommitteeType::factory()->create(['name' => 'Alpha Committee']);
        $beta = SystemCommitteeType::factory()->create(['name' => 'Beta Committee']);

        Livewire::actingAs($this->superAdmin)
            ->test(ManageCommitteeTypes::class)
            ->searchTable('Alpha')
            ->assertCanSeeTableRecords([$alpha])
            ->assertCanNotSeeTableRecords([$beta]);
    }

    #[Test]
    public function committee_type_table_can_sort_by_name(): void
    {
        SystemCommitteeType::factory()->create(['name' => 'Zulu Type']);
        SystemCommitteeType::factory()->create(['name' => 'Alpha Type']);

        $sortedAsc = SystemCommitteeType::query()->orderBy('name')->get();
        $sortedDesc = SystemCommitteeType::query()->orderBy('name', 'desc')->get();

        Livewire::actingAs($this->superAdmin)
            ->test(ManageCommitteeTypes::class)
            ->sortTable('name')
            ->assertCanSeeTableRecords($sortedAsc, inOrder: true)
            ->sortTable('name', 'desc')
            ->assertCanSeeTableRecords($sortedDesc, inOrder: true);
    }

    #[Test]
    public function committee_type_can_be_created(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ManageCommitteeTypes::class)
            ->callAction('create', data: ['name' => 'New Committee Type', 'description' => 'A description', 'active' => true])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('system_committee_types', ['name' => 'New Committee Type']);
    }

    #[Test]
    public function committee_type_can_be_edited(): void
    {
        $record = SystemCommitteeType::factory()->create(['name' => 'Original Name']);

        Livewire::actingAs($this->superAdmin)
            ->test(ManageCommitteeTypes::class)
            ->callTableAction('edit', $record, data: ['name' => 'Updated Name', 'description' => 'A description'])
            ->assertHasNoTableActionErrors();

        $this->assertDatabaseHas('system_committee_types', ['id' => $record->id, 'name' => 'Updated Name']);
    }

    #[Test]
    public function committee_type_can_be_deleted(): void
    {
        $record = SystemCommitteeType::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ManageCommitteeTypes::class)
            ->callTableAction('delete', $record)
            ->assertHasNoTableActionErrors();

        $this->assertDatabaseMissing('system_committee_types', ['id' => $record->id]);
    }

    // --- WarrantType representative CRUD tests ---

    #[Test]
    public function warrant_type_table_renders_records(): void
    {
        $records = AmsWarrantType::factory()->count(3)->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ManageWarrantTypes::class)
            ->assertOk()
            ->assertCanSeeTableRecords($records);
    }

    #[Test]
    public function warrant_type_table_can_search(): void
    {
        $alpha = AmsWarrantType::factory()->create(['name' => 'Alpha Warrant']);
        $beta = AmsWarrantType::factory()->create(['name' => 'Beta Warrant']);

        Livewire::actingAs($this->superAdmin)
            ->test(ManageWarrantTypes::class)
            ->searchTable('Alpha')
            ->assertCanSeeTableRecords([$alpha])
            ->assertCanNotSeeTableRecords([$beta]);
    }

    #[Test]
    public function warrant_type_table_can_sort_by_name(): void
    {
        AmsWarrantType::factory()->create(['name' => 'Zulu Warrant']);
        AmsWarrantType::factory()->create(['name' => 'Alpha Warrant']);

        $sortedAsc = AmsWarrantType::query()->orderBy('name')->get();
        $sortedDesc = AmsWarrantType::query()->orderBy('name', 'desc')->get();

        Livewire::actingAs($this->superAdmin)
            ->test(ManageWarrantTypes::class)
            ->sortTable('name')
            ->assertCanSeeTableRecords($sortedAsc, inOrder: true)
            ->sortTable('name', 'desc')
            ->assertCanSeeTableRecords($sortedDesc, inOrder: true);
    }

    #[Test]
    public function warrant_type_can_be_created(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ManageWarrantTypes::class)
            ->callAction('create', data: [
                'name' => 'New Warrant Type',
                'shortName' => 'NWT',
                'description' => 'A description',
                'national' => false,
                'region' => false,
                'district' => false,
                'group' => true,
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('ams_warrant_types', ['name' => 'New Warrant Type']);
    }

    #[Test]
    public function warrant_type_can_be_edited(): void
    {
        $record = AmsWarrantType::factory()->create(['name' => 'Original Warrant']);

        Livewire::actingAs($this->superAdmin)
            ->test(ManageWarrantTypes::class)
            ->callTableAction('edit', $record, data: [
                'name' => 'Updated Warrant',
                'shortName' => 'UW',
                'description' => 'A description',
            ])
            ->assertHasNoTableActionErrors();

        $this->assertDatabaseHas('ams_warrant_types', ['id' => $record->id, 'name' => 'Updated Warrant']);
    }

    #[Test]
    public function warrant_type_can_be_deleted(): void
    {
        $record = AmsWarrantType::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ManageWarrantTypes::class)
            ->callTableAction('delete', $record)
            ->assertHasNoTableActionErrors();

        $this->assertDatabaseMissing('ams_warrant_types', ['id' => $record->id]);
    }

    // --- DisciplinaryHeading representative CRUD tests (uses `reason` field) ---

    #[Test]
    public function disciplinary_heading_table_renders_records(): void
    {
        $records = AmsDisciplinaryHeading::factory()->count(3)->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ManageDisciplinaryHeadings::class)
            ->assertOk()
            ->assertCanSeeTableRecords($records);
    }

    #[Test]
    public function disciplinary_heading_can_be_created(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ManageDisciplinaryHeadings::class)
            ->callAction('create', data: ['reason' => 'Misconduct of a serious nature'])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('ams_disciplinary_headings', ['reason' => 'Misconduct of a serious nature']);
    }

    #[Test]
    public function disciplinary_heading_can_be_edited(): void
    {
        $record = AmsDisciplinaryHeading::factory()->create(['reason' => 'Original Reason']);

        Livewire::actingAs($this->superAdmin)
            ->test(ManageDisciplinaryHeadings::class)
            ->callTableAction('edit', $record, data: ['reason' => 'Updated Reason'])
            ->assertHasNoTableActionErrors();

        $this->assertDatabaseHas('ams_disciplinary_headings', ['id' => $record->id, 'reason' => 'Updated Reason']);
    }

    #[Test]
    public function disciplinary_heading_can_be_deleted(): void
    {
        $record = AmsDisciplinaryHeading::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ManageDisciplinaryHeadings::class)
            ->callTableAction('delete', $record)
            ->assertHasNoTableActionErrors();

        $this->assertDatabaseMissing('ams_disciplinary_headings', ['id' => $record->id]);
    }

    // --- CubLevel representative CRUD tests ---

    #[Test]
    public function cub_level_table_renders_records(): void
    {
        $records = SystemAdvancementCubsLevel::factory()->count(3)->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ManageCubLevels::class)
            ->assertOk()
            ->assertCanSeeTableRecords($records);
    }

    #[Test]
    public function cub_level_table_can_search(): void
    {
        $alpha = SystemAdvancementCubsLevel::factory()->create(['name' => 'Alpha Cub Level']);
        $beta = SystemAdvancementCubsLevel::factory()->create(['name' => 'Beta Cub Level']);

        Livewire::actingAs($this->superAdmin)
            ->test(ManageCubLevels::class)
            ->searchTable('Alpha')
            ->assertCanSeeTableRecords([$alpha])
            ->assertCanNotSeeTableRecords([$beta]);
    }

    #[Test]
    public function cub_level_can_be_created(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ManageCubLevels::class)
            ->callAction('create', data: ['name' => 'New Cub Level', 'description' => 'A cub level description', 'active' => true])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('system_advancement_cubs_levels', ['name' => 'New Cub Level']);
    }

    #[Test]
    public function cub_level_can_be_edited(): void
    {
        $record = SystemAdvancementCubsLevel::factory()->create(['name' => 'Original Cub Level']);

        Livewire::actingAs($this->superAdmin)
            ->test(ManageCubLevels::class)
            ->callTableAction('edit', $record, data: ['name' => 'Updated Cub Level', 'description' => 'A description'])
            ->assertHasNoTableActionErrors();

        $this->assertDatabaseHas('system_advancement_cubs_levels', ['id' => $record->id, 'name' => 'Updated Cub Level']);
    }

    #[Test]
    public function cub_level_can_be_deleted(): void
    {
        $record = SystemAdvancementCubsLevel::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ManageCubLevels::class)
            ->callTableAction('delete', $record)
            ->assertHasNoTableActionErrors();

        $this->assertDatabaseMissing('system_advancement_cubs_levels', ['id' => $record->id]);
    }

    // --- Empty optional fields regression tests ---

    #[Test]
    public function warrant_type_can_be_created_with_empty_optional_fields(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ManageWarrantTypes::class)
            ->callAction('create', data: [
                'name' => 'Minimal Warrant Type',
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('ams_warrant_types', [
            'name' => 'Minimal Warrant Type',
            'shortName' => '',
            'description' => '',
        ]);
    }

    #[Test]
    public function warrant_type_can_be_edited_with_empty_optional_fields(): void
    {
        $record = AmsWarrantType::factory()->create(['name' => 'Original', 'shortName' => 'OG', 'description' => 'Test']);

        Livewire::actingAs($this->superAdmin)
            ->test(ManageWarrantTypes::class)
            ->callTableAction('edit', $record, data: [
                'name' => 'Updated',
                'shortName' => '',
                'description' => '',
            ])
            ->assertHasNoTableActionErrors();

        $this->assertDatabaseHas('ams_warrant_types', [
            'id' => $record->id,
            'name' => 'Updated',
            'shortName' => '',
            'description' => '',
        ]);
    }

    #[Test]
    public function committee_type_can_be_created_with_empty_description(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ManageCommitteeTypes::class)
            ->callAction('create', data: [
                'name' => 'Minimal Committee',
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('system_committee_types', [
            'name' => 'Minimal Committee',
            'description' => '',
        ]);
    }
}

<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Resources\Users\Pages\ViewUser;
use App\Filament\Admin\Resources\Users\RelationManagers\UserAwardsRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserDocumentsRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserLicencesRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserPastServiceRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserTrainingHistoryRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserWarrantsRelationManager;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Models\AmsAwardHeading;
use App\Models\AmsAwardType;
use App\Models\AmsDocumentType;
use App\Models\AmsLicenceInfo;
use App\Models\AmsLicenceType;
use App\Models\AmsPastServiceType;
use App\Models\AmsTrainingPastType;
use App\Models\AmsWarrantCancellationType;
use App\Models\AmsWarrantInfo;
use App\Models\AmsWarrantType;
use App\Models\Award;
use App\Models\Document;
use App\Models\PastService;
use App\Models\PastTraining;
use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\Testing\TestAction;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

/**
 * The AMS record tabs on the BackOffice user page (awards, documents, past service, training,
 * warrants, licences) read their lookup labels from the legacy `ams_*` type tables. Ticket 029
 * found every one of them pointing at a `typeName` column that does not exist, so the tabs
 * rendered blank and the create forms crashed. These tests pin the real column names, the
 * `Name (#id)` display convention of the admin panel, and the create path that copies the
 * member's home area and the acting admin onto the legacy `NOT NULL` columns.
 */
class UserRecordRelationManagersTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    private SystemUser $member;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();

        $this->member = SystemUser::factory()->create([
            'assoc_to_region' => 3,
            'assoc_to_district' => 5,
            'assoc_to_group' => 7,
        ]);
    }

    #[Test]
    public function the_awards_tab_shows_the_award_type_and_heading_by_name_and_id(): void
    {
        $heading = AmsAwardHeading::factory()->create(['reason' => 'Gallantry']);
        $type = AmsAwardType::factory()->create(['name' => 'Silver Wolf', 'headingID' => $heading->id]);
        $award = Award::factory()->create([
            'userID' => $this->member->id,
            'awardTypeID' => $type->id,
            'awardHeadingID' => $heading->id,
        ]);

        $this->relationManager(UserAwardsRelationManager::class)
            ->assertCanSeeTableRecords([$award])
            ->assertSee("Silver Wolf (#{$type->id})")
            ->assertSee("Gallantry (#{$heading->id})");
    }

    #[Test]
    public function an_award_can_be_created_from_the_tab_and_takes_the_members_home_area(): void
    {
        $heading = AmsAwardHeading::factory()->create();
        $type = AmsAwardType::factory()->create(['headingID' => $heading->id]);

        $this->relationManager(UserAwardsRelationManager::class)
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'awardTypeID' => $type->id,
                'awardHeadingID' => $heading->id,
                'awardDate' => '2026-08-01',
            ])
            ->assertHasNoFormErrors()
            ->assertNotified();

        $award = $this->member->awards()->sole();

        $this->assertSame($type->id, $award->awardTypeID);
        $this->assertSame($heading->id, $award->awardHeadingID);
        $this->assertSame('2026-08-01', $award->awardDate->toDateString());
        $this->assertSame(3, $award->assocToRegion);
        $this->assertSame(5, $award->assocToDistrict);
        $this->assertSame(7, $award->assocToGroup);
        $this->assertSame($this->superAdmin->id, $award->createdby);
    }

    #[Test]
    public function picking_an_award_type_fills_in_its_heading(): void
    {
        $heading = AmsAwardHeading::factory()->create();
        $type = AmsAwardType::factory()->create(['headingID' => $heading->id]);

        $this->relationManager(UserAwardsRelationManager::class)
            ->mountAction(TestAction::make(CreateAction::class)->table())
            ->fillForm(['awardTypeID' => $type->id], 'mountedActionSchema0')
            ->assertSchemaStateSet(['awardHeadingID' => $heading->id], 'mountedActionSchema0');
    }

    #[Test]
    public function the_documents_tab_shows_the_document_type_by_name_and_id(): void
    {
        $type = AmsDocumentType::factory()->create(['name' => 'Identity Document']);
        $document = Document::factory()->create([
            'userID' => $this->member->id,
            'documentTypeID' => $type->id,
        ]);

        $this->relationManager(UserDocumentsRelationManager::class)
            ->assertCanSeeTableRecords([$document])
            ->assertSee("Identity Document (#{$type->id})");
    }

    #[Test]
    public function every_create_form_lists_and_searches_its_lookup_by_name_and_id(): void
    {
        $heading = AmsAwardHeading::factory()->create(['reason' => 'Gallantry']);
        $awardType = AmsAwardType::factory()->create(['name' => 'Silver Wolf', 'headingID' => $heading->id]);
        $documentType = AmsDocumentType::factory()->create(['name' => 'Identity Document']);
        $serviceType = AmsPastServiceType::factory()->create(['name' => 'Troop Scouter']);
        $trainingType = AmsTrainingPastType::factory()->create(['name' => 'Wood Badge']);
        $warrantType = AmsWarrantType::factory()->create(['name' => 'Scouter Warrant']);
        $licenceType = AmsLicenceType::factory()->create(['name' => 'First Aid']);

        $this->assertSelectOffers(UserAwardsRelationManager::class, Award::class, 'awardTypeID', $awardType->id, "Silver Wolf (#{$awardType->id})", 'Silver');
        $this->assertSelectOffers(UserAwardsRelationManager::class, Award::class, 'awardHeadingID', $heading->id, "Gallantry (#{$heading->id})", 'Gallan');
        $this->assertSelectOffers(UserDocumentsRelationManager::class, Document::class, 'documentTypeID', $documentType->id, "Identity Document (#{$documentType->id})", 'Identity');
        $this->assertSelectOffers(UserPastServiceRelationManager::class, PastService::class, 'pastServiceType', $serviceType->id, "Troop Scouter (#{$serviceType->id})", 'Troop');
        $this->assertSelectOffers(UserTrainingHistoryRelationManager::class, PastTraining::class, 'trainingTypeID', $trainingType->id, "Wood Badge (#{$trainingType->id})", 'Wood');
        $this->assertSelectOffers(UserWarrantsRelationManager::class, AmsWarrantInfo::class, 'warrantTypeID', $warrantType->id, "Scouter Warrant (#{$warrantType->id})", 'Scouter');
        $this->assertSelectOffers(UserLicencesRelationManager::class, AmsLicenceInfo::class, 'chargeTypeID', $licenceType->id, "First Aid (#{$licenceType->id})", 'First');
    }

    #[Test]
    public function the_past_service_tab_shows_the_service_type_by_name_and_id(): void
    {
        $type = AmsPastServiceType::factory()->create(['name' => 'Troop Scouter']);
        $record = PastService::factory()->create([
            'userID' => $this->member->id,
            'pastServiceType' => $type->id,
        ]);

        $this->relationManager(UserPastServiceRelationManager::class)
            ->assertCanSeeTableRecords([$record])
            ->assertSee("Troop Scouter (#{$type->id})");
    }

    #[Test]
    public function a_past_service_record_can_be_created_from_the_tab(): void
    {
        $type = AmsPastServiceType::factory()->create();

        $this->relationManager(UserPastServiceRelationManager::class)
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'pastServiceType' => $type->id,
                'startDate' => '2020-01-01',
                'endDate' => '2022-12-31',
                'otherGroupName' => '1st Somewhere',
            ])
            ->assertHasNoFormErrors()
            ->assertNotified();

        $record = $this->member->pastService()->sole();

        $this->assertSame($type->id, $record->pastServiceType);
        $this->assertSame('1st Somewhere', $record->otherGroupName);
        $this->assertSame(3, $record->assocToRegion);
        $this->assertSame($this->superAdmin->id, $record->createdby);
    }

    #[Test]
    public function the_training_tab_shows_the_training_type_by_name_and_id(): void
    {
        $type = AmsTrainingPastType::factory()->create(['name' => 'Wood Badge']);
        $record = PastTraining::factory()->create([
            'userID' => $this->member->id,
            'trainingTypeID' => $type->id,
        ]);

        $this->relationManager(UserTrainingHistoryRelationManager::class)
            ->assertCanSeeTableRecords([$record])
            ->assertSee("Wood Badge (#{$type->id})");
    }

    #[Test]
    public function a_training_record_can_be_created_from_the_tab(): void
    {
        $type = AmsTrainingPastType::factory()->create();

        $this->relationManager(UserTrainingHistoryRelationManager::class)
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'courseName' => 'Warrant Course',
                'courseNumber' => 'WC-42',
                'trainingTypeID' => $type->id,
                'completionDate' => '2026-03-15',
            ])
            ->assertHasNoFormErrors()
            ->assertNotified();

        $record = $this->member->trainingHistory()->sole();

        $this->assertSame($type->id, $record->trainingTypeID);
        $this->assertSame('Warrant Course', $record->courseName);
        $this->assertSame(3, $record->assocToRegion);
        $this->assertSame($this->superAdmin->id, $record->createdby);
    }

    #[Test]
    public function the_warrants_tab_shows_the_warrant_type_and_the_view_shows_the_cancellation_type(): void
    {
        $type = AmsWarrantType::factory()->create(['name' => 'Scouter Warrant']);
        $cancellation = AmsWarrantCancellationType::factory()->create(['name' => 'Resigned']);
        $warrant = AmsWarrantInfo::factory()->create([
            'userID' => $this->member->id,
            'warrantTypeID' => $type->id,
            'cancellationTypeID' => $cancellation->id,
        ]);

        $component = $this->relationManager(UserWarrantsRelationManager::class)
            ->assertCanSeeTableRecords([$warrant])
            ->assertSee("Scouter Warrant (#{$type->id})");

        $relationManager = $component->instance();
        $infolist = $relationManager->infolist(Schema::make($relationManager))->record($warrant);

        /** @var TextEntry $entry */
        $entry = collect($infolist->getFlatComponents())
            ->first(fn ($component): bool => $component instanceof TextEntry && $component->getName() === 'cancellationType.name');

        $this->assertSame("Resigned (#{$cancellation->id})", $entry->getState());
    }

    #[Test]
    public function a_warrant_can_be_created_from_the_tab(): void
    {
        $type = AmsWarrantType::factory()->create();

        $this->relationManager(UserWarrantsRelationManager::class)
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'warrantNr' => 'SSA9001',
                'warrantName' => 'Troop Scouter',
                'warrantTypeID' => $type->id,
                'issueDate' => '2026-01-01',
                'expireDate' => '2029-01-01',
            ])
            ->assertHasNoFormErrors()
            ->assertNotified();

        $warrant = $this->member->warrants()->sole();

        $this->assertSame($type->id, $warrant->warrantTypeID);
        $this->assertSame('SSA9001', $warrant->warrantNr);
        $this->assertSame(3, $warrant->assocToRegion);
        $this->assertSame($this->superAdmin->id, $warrant->createdby);
    }

    #[Test]
    public function the_user_page_has_a_licences_tab(): void
    {
        $this->assertContains(UserLicencesRelationManager::class, UserResource::getRelations());
    }

    #[Test]
    public function the_licences_tab_shows_the_type_number_and_expiry_date(): void
    {
        $type = AmsLicenceType::factory()->create(['name' => 'First Aid']);
        $licence = AmsLicenceInfo::factory()->create([
            'userID' => $this->member->id,
            'chargeTypeID' => $type->id,
            'chargeNr' => 'FA-123',
            'issueDate' => '2025-02-10',
            'expireDate' => '2030-02-10',
        ]);

        $this->relationManager(UserLicencesRelationManager::class)
            ->assertCanSeeTableRecords([$licence])
            ->assertTableColumnExists('expireDate')
            ->assertSee("First Aid (#{$type->id})")
            ->assertSee('FA-123')
            ->assertSee($licence->expireDate->translatedFormat('M j, Y'));
    }

    #[Test]
    public function a_licence_can_be_created_from_the_tab(): void
    {
        $type = AmsLicenceType::factory()->create(['expiryYears' => 3]);

        $this->relationManager(UserLicencesRelationManager::class)
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'chargeTypeID' => $type->id,
                'chargeNr' => 'FA-999',
                'issueDate' => '2026-05-01',
                'expireDate' => '2029-05-01',
                'active' => true,
            ])
            ->assertHasNoFormErrors()
            ->assertNotified();

        $licence = $this->member->licenceInfos()->sole();

        $this->assertSame($type->id, $licence->chargeTypeID);
        $this->assertSame('FA-999', $licence->chargeNr);
        $this->assertSame('2029-05-01', $licence->expireDate->toDateString());
        $this->assertSame(1, $licence->active);
        $this->assertSame(3, $licence->assocToRegion);
        $this->assertSame(5, $licence->assocToDistrict);
        $this->assertSame(7, $licence->assocToGroup);
        $this->assertSame($this->superAdmin->id, $licence->createdby);
    }

    #[Test]
    public function a_licence_expiry_date_can_be_edited_from_the_tab(): void
    {
        $licence = AmsLicenceInfo::factory()->create([
            'userID' => $this->member->id,
            'expireDate' => '2030-02-10',
        ]);

        $this->relationManager(UserLicencesRelationManager::class)
            ->callAction(TestAction::make(EditAction::class)->table($licence), [
                'expireDate' => '2031-06-30',
            ])
            ->assertHasNoFormErrors()
            ->assertNotified();

        $this->assertSame('2031-06-30', $licence->refresh()->expireDate->toDateString());
    }

    /**
     * A relationship select on a create form lists the lookup with the preloaded options and, because
     * every one of them is searchable, runs a `like` on its title column when the admin types. Both
     * paths break on a title column that does not exist, so both are asserted.
     *
     * @param  class-string  $relationManager
     * @param  class-string  $model
     */
    private function assertSelectOffers(string $relationManager, string $model, string $field, int $id, string $label, string $search): void
    {
        $instance = $this->relationManager($relationManager)->instance();
        $form = $instance->form(Schema::make($instance)->model($model));

        /** @var Select $select */
        $select = collect($form->getFlatComponents())
            ->first(fn ($component): bool => $component instanceof Select && $component->getName() === $field);

        $this->assertSame($label, $select->getOptions()[$id] ?? null, "{$field} options");
        $this->assertSame($label, $select->getSearchResults($search)[$id] ?? null, "{$field} search");
    }

    /**
     * @param  class-string  $relationManager
     */
    private function relationManager(string $relationManager): Testable
    {
        return Livewire::actingAs($this->superAdmin)
            ->test($relationManager, [
                'ownerRecord' => $this->member,
                'pageClass' => ViewUser::class,
            ]);
    }
}

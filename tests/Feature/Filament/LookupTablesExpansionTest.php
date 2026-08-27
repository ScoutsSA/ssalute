<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Clusters\LookupTables\Resources\ArticleCategories\ArticleCategoryResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\ArticleCategories\Pages\ManageArticleCategories;
use App\Filament\Admin\Clusters\LookupTables\Resources\Articles\ArticleResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\Articles\Pages\ManageArticles;
use App\Filament\Admin\Clusters\LookupTables\Resources\Cities\CityResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\Cities\Pages\ManageCities;
use App\Filament\Admin\Clusters\LookupTables\Resources\CompetitionJudgeTypes\CompetitionJudgeTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\CompetitionJudgeTypes\Pages\ManageCompetitionJudgeTypes;
use App\Filament\Admin\Clusters\LookupTables\Resources\Countries\CountryResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\Countries\Pages\ManageCountries;
use App\Filament\Admin\Clusters\LookupTables\Resources\CubProgramTypes\CubProgramTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\CubProgramTypes\Pages\ManageCubProgramTypes;
use App\Filament\Admin\Clusters\LookupTables\Resources\DisciplinaryOffences\DisciplinaryOffenceResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\DisciplinaryOffences\Pages\ManageDisciplinaryOffences;
use App\Filament\Admin\Clusters\LookupTables\Resources\FaqCategories\FaqCategoryResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\FaqCategories\Pages\ManageFaqCategories;
use App\Filament\Admin\Clusters\LookupTables\Resources\FaqCategories\Pages\ViewFaqCategory;
use App\Filament\Admin\Clusters\LookupTables\Resources\FaqCategories\RelationManagers\FaqsRelationManager;
use App\Filament\Admin\Clusters\LookupTables\Resources\FaqEntries\FaqEntryResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\FaqEntries\Pages\ManageFaqEntries;
use App\Filament\Admin\Clusters\LookupTables\Resources\GroupTypes\GroupTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\GroupTypes\Pages\ManageGroupTypes;
use App\Filament\Admin\Clusters\LookupTables\Resources\InfoSharingTypes\InfoSharingTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\InfoSharingTypes\Pages\ManageInfoSharingTypes;
use App\Filament\Admin\Clusters\LookupTables\Resources\MeerkatProgramTypes\MeerkatProgramTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\MeerkatProgramTypes\Pages\ManageMeerkatProgramTypes;
use App\Filament\Admin\Clusters\LookupTables\Resources\ProjectAudiences\Pages\ManageProjectAudiences;
use App\Filament\Admin\Clusters\LookupTables\Resources\ProjectAudiences\ProjectAudienceResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\PropertyOwnershipTypes\Pages\ManagePropertyOwnershipTypes;
use App\Filament\Admin\Clusters\LookupTables\Resources\PropertyOwnershipTypes\PropertyOwnershipTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\RoadmapItems\Pages\ManageRoadmapItems;
use App\Filament\Admin\Clusters\LookupTables\Resources\RoadmapItems\RoadmapItemResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\RoverProgramTypes\Pages\ManageRoverProgramTypes;
use App\Filament\Admin\Clusters\LookupTables\Resources\RoverProgramTypes\RoverProgramTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\ScoutProgramTypes\Pages\ManageScoutProgramTypes;
use App\Filament\Admin\Clusters\LookupTables\Resources\ScoutProgramTypes\ScoutProgramTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\SupportChatStandardAnswers\Pages\ManageSupportChatStandardAnswers;
use App\Filament\Admin\Clusters\LookupTables\Resources\SupportChatStandardAnswers\SupportChatStandardAnswerResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\SupportChatTypes\Pages\ManageSupportChatTypes;
use App\Filament\Admin\Clusters\LookupTables\Resources\SupportChatTypes\SupportChatTypeResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\TrainingCourses\Pages\ManageTrainingCourses;
use App\Filament\Admin\Clusters\LookupTables\Resources\TrainingCourses\TrainingCourseResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\TrainingLocations\Pages\ManageTrainingLocations;
use App\Filament\Admin\Clusters\LookupTables\Resources\TrainingLocations\TrainingLocationResource;
use App\Filament\Admin\Clusters\LookupTables\Resources\YouthDocumentTypes\Pages\ManageYouthDocumentTypes;
use App\Filament\Admin\Clusters\LookupTables\Resources\YouthDocumentTypes\YouthDocumentTypeResource;
use App\Models\AmsDisciplinaryHeading;
use App\Models\AmsDisciplinaryOffence;
use App\Models\AmsTrainingCourse;
use App\Models\AmsTrainingLocation;
use App\Models\EventCompetitionsJudgesType;
use App\Models\GroupsPropertyOwnershipType;
use App\Models\GroupsType;
use App\Models\InfoSharingType;
use App\Models\ProjectsFor;
use App\Models\Region;
use App\Models\SdArticle;
use App\Models\SdArticleCat;
use App\Models\SupportChatsStandardAnswer;
use App\Models\SupportChatsType;
use App\Models\SystemCity;
use App\Models\SystemCountryName;
use App\Models\SystemDocumentType;
use App\Models\SystemFaq;
use App\Models\SystemFaqCat;
use App\Models\SystemProgramTypesCub;
use App\Models\SystemProgramTypesMeerkat;
use App\Models\SystemProgramTypesRover;
use App\Models\SystemProgramTypesScout;
use App\Models\SystemRoadmapLittle;
use App\Models\SystemUser;
use App\Services\LegacyHtmlService;
use App\Settings\GeneralSettings;
use Closure;
use Filament\Actions\Testing\TestAction;
use Filament\Support\Enums\Width;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class LookupTablesExpansionTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    /** @return array<string, array{class-string}> */
    public static function resourceProvider(): array
    {
        return [
            'youth document types' => [YouthDocumentTypeResource::class],
            'meerkat program types' => [MeerkatProgramTypeResource::class],
            'cub program types' => [CubProgramTypeResource::class],
            'scout program types' => [ScoutProgramTypeResource::class],
            'rover program types' => [RoverProgramTypeResource::class],
            'competition judge types' => [CompetitionJudgeTypeResource::class],
            'group types' => [GroupTypeResource::class],
            'property ownership types' => [PropertyOwnershipTypeResource::class],
            'disciplinary offences' => [DisciplinaryOffenceResource::class],
            'training locations' => [TrainingLocationResource::class],
            'training courses' => [TrainingCourseResource::class],
            'faq categories' => [FaqCategoryResource::class],
            'faq entries' => [FaqEntryResource::class],
            'articles' => [ArticleResource::class],
            'article categories' => [ArticleCategoryResource::class],
            'roadmap items' => [RoadmapItemResource::class],
            'support chat types' => [SupportChatTypeResource::class],
            'support chat standard answers' => [SupportChatStandardAnswerResource::class],
            'info sharing types' => [InfoSharingTypeResource::class],
            'project audiences' => [ProjectAudienceResource::class],
            'countries' => [CountryResource::class],
            'cities' => [CityResource::class],
        ];
    }

    /**
     * Each entry: manage page, model, table, create data (closure so factories run
     * inside the test), expected row after create, edit data, expected row after edit.
     *
     * @return array<string, array{class-string, class-string, string, Closure, array<string, mixed>, array<string, mixed>, array<string, mixed>}>
     */
    public static function crudProvider(): array
    {
        return [
            'youth document types' => [
                ManageYouthDocumentTypes::class,
                SystemDocumentType::class,
                'system_document_types',
                fn (): array => ['name' => 'Safe From Harm 3 WOSM Certificate', 'description' => 'SFH level three certificate', 'youth' => true],
                ['name' => 'Safe From Harm 3 WOSM Certificate', 'youth' => 1],
                ['name' => 'Renamed Document Type'],
                ['name' => 'Renamed Document Type'],
            ],
            'meerkat program types' => [
                ManageMeerkatProgramTypes::class,
                SystemProgramTypesMeerkat::class,
                'system_program_types_meerkats',
                fn (): array => ['name' => 'Den Meeting', 'active' => true],
                ['name' => 'Den Meeting', 'active' => 1],
                ['name' => 'Renamed Den Meeting'],
                ['name' => 'Renamed Den Meeting'],
            ],
            'cub program types' => [
                ManageCubProgramTypes::class,
                SystemProgramTypesCub::class,
                'system_program_types_cubs',
                fn (): array => ['name' => 'Pack Meeting', 'active' => true],
                ['name' => 'Pack Meeting', 'active' => 1],
                ['name' => 'Renamed Pack Meeting'],
                ['name' => 'Renamed Pack Meeting'],
            ],
            'scout program types' => [
                ManageScoutProgramTypes::class,
                SystemProgramTypesScout::class,
                'system_program_types_scouts',
                fn (): array => ['name' => 'Troop Meeting', 'active' => true],
                ['name' => 'Troop Meeting', 'active' => 1],
                ['name' => 'Renamed Troop Meeting'],
                ['name' => 'Renamed Troop Meeting'],
            ],
            'rover program types' => [
                ManageRoverProgramTypes::class,
                SystemProgramTypesRover::class,
                'system_program_types_rovers',
                fn (): array => ['name' => 'Crew Meeting', 'active' => true],
                ['name' => 'Crew Meeting', 'active' => 1],
                ['name' => 'Renamed Crew Meeting'],
                ['name' => 'Renamed Crew Meeting'],
            ],
            'competition judge types' => [
                ManageCompetitionJudgeTypes::class,
                EventCompetitionsJudgesType::class,
                'event_competitions_judges_types',
                fn (): array => ['name' => 'Score Capturer', 'canCaptureScores' => true, 'active' => true],
                ['name' => 'Score Capturer', 'canCaptureScores' => 1],
                ['name' => 'Renamed Judge Type'],
                ['name' => 'Renamed Judge Type'],
            ],
            'group types' => [
                ManageGroupTypes::class,
                GroupsType::class,
                'groups_types',
                fn (): array => ['name' => 'Homeschool Group', 'description' => 'Groups based at homeschool co-ops'],
                ['name' => 'Homeschool Group'],
                ['name' => 'Renamed Group Type'],
                ['name' => 'Renamed Group Type'],
            ],
            'property ownership types' => [
                ManagePropertyOwnershipTypes::class,
                GroupsPropertyOwnershipType::class,
                'groups_property_ownership_types',
                fn (): array => ['name' => 'Owned By District', 'owned' => true, 'active' => true],
                ['name' => 'Owned By District', 'owned' => 1],
                ['name' => 'Renamed Ownership Type'],
                ['name' => 'Renamed Ownership Type'],
            ],
            'disciplinary offences' => [
                ManageDisciplinaryOffences::class,
                AmsDisciplinaryOffence::class,
                'ams_disciplinary_offences',
                fn (): array => [
                    'headingID' => AmsDisciplinaryHeading::factory()->create()->id,
                    'offense' => 'Testing offence',
                    'active' => true,
                ],
                ['offense' => 'Testing offence'],
                ['offense' => 'Updated offence'],
                ['offense' => 'Updated offence'],
            ],
            'training locations' => [
                ManageTrainingLocations::class,
                AmsTrainingLocation::class,
                'ams_training_locations',
                fn (): array => [
                    'name' => 'Arrowe Park Training Centre',
                    'assocToRegion' => self::createRegion()->id,
                    'address' => '1 Test Road',
                    'trainingSeats' => 25,
                    'active' => true,
                ],
                ['name' => 'Arrowe Park Training Centre', 'trainingSeats' => 25],
                ['name' => 'Renamed Training Centre'],
                ['name' => 'Renamed Training Centre'],
            ],
            'training courses' => [
                ManageTrainingCourses::class,
                AmsTrainingCourse::class,
                'ams_training_courses',
                fn (): array => [
                    'name' => 'Warrant Course',
                    'assocToRegion' => self::createRegion()->id,
                    'nrOfDays' => 2,
                    'active' => true,
                ],
                ['name' => 'Warrant Course', 'nrOfDays' => 2],
                ['name' => 'Renamed Course'],
                ['name' => 'Renamed Course'],
            ],
            'faq categories' => [
                ManageFaqCategories::class,
                SystemFaqCat::class,
                'system_faq_cats',
                fn (): array => ['name' => 'Census Questions', 'faqGroup' => 0, 'position' => 3, 'forGroupAdults' => true, 'active' => true],
                ['name' => 'Census Questions', 'position' => 3, 'forGroupAdults' => 1],
                ['name' => 'Renamed FAQ Category'],
                ['name' => 'Renamed FAQ Category'],
            ],
            'faq entries' => [
                ManageFaqEntries::class,
                SystemFaq::class,
                'system_faq',
                fn (): array => [
                    'catID' => SystemFaqCat::factory()->create()->id,
                    'q' => 'How Do I Test This?',
                    'a' => '<p>Like this.</p>',
                    'position' => 1,
                    'active' => true,
                ],
                ['q' => 'How Do I Test This?', 'position' => 1],
                ['q' => 'How Do I Test This Again?'],
                ['q' => 'How Do I Test This Again?'],
            ],
            'articles' => [
                ManageArticles::class,
                SdArticle::class,
                'sd_articles',
                fn (): array => [
                    'catID' => SdArticleCat::factory()->create()->id,
                    'title' => 'A Test Article',
                    'slug' => 'a-test-article',
                    'intro' => 'A teaser paragraph.',
                    'article' => '<p>The body.</p>',
                    'active' => true,
                ],
                ['title' => 'A Test Article', 'slug' => 'a-test-article'],
                ['title' => 'A Renamed Article'],
                ['title' => 'A Renamed Article'],
            ],
            'article categories' => [
                ManageArticleCategories::class,
                SdArticleCat::class,
                'sd_article_cats',
                fn (): array => ['name' => 'Camping Skills', 'slug' => 'camping-skills'],
                ['name' => 'Camping Skills', 'slug' => 'camping-skills'],
                ['name' => 'Renamed Article Category'],
                ['name' => 'Renamed Article Category'],
            ],
            'roadmap items' => [
                ManageRoadmapItems::class,
                SystemRoadmapLittle::class,
                'system_roadmap_little',
                fn (): array => ['area' => 'Advancement', 'text' => 'New advancement flow coming', 'releaseDate' => '2026-09-01', 'active' => true],
                ['area' => 'Advancement'],
                ['area' => 'Badges'],
                ['area' => 'Badges'],
            ],
            'support chat types' => [
                ManageSupportChatTypes::class,
                SupportChatsType::class,
                'support_chats_types',
                fn (): array => ['name' => 'A Data Problem', 'active' => true],
                ['name' => 'A Data Problem'],
                ['name' => 'Renamed Chat Type'],
                ['name' => 'Renamed Chat Type'],
            ],
            'support chat standard answers' => [
                ManageSupportChatStandardAnswers::class,
                SupportChatsStandardAnswer::class,
                'support_chats_standard_answers',
                fn (): array => ['answer' => 'Thank you, we will investigate.', 'autoClose' => true, 'active' => true],
                ['answer' => 'Thank you, we will investigate.', 'autoClose' => 1],
                ['answer' => 'Updated canned answer'],
                ['answer' => 'Updated canned answer'],
            ],
            'info sharing types' => [
                ManageInfoSharingTypes::class,
                InfoSharingType::class,
                'info_sharing_types',
                fn (): array => ['name' => 'Service Providers', 'active' => true],
                ['name' => 'Service Providers'],
                ['name' => 'Renamed Sharing Type'],
                ['name' => 'Renamed Sharing Type'],
            ],
            'project audiences' => [
                ManageProjectAudiences::class,
                ProjectsFor::class,
                'projects_for',
                fn (): array => ['name' => 'Rovers Only', 'active' => true],
                ['name' => 'Rovers Only'],
                ['name' => 'Renamed Audience'],
                ['name' => 'Renamed Audience'],
            ],
            'countries' => [
                ManageCountries::class,
                SystemCountryName::class,
                'system_country_names',
                fn (): array => ['country_code' => 'ZZ', 'country_name' => 'Testland', 'usingSD' => true],
                ['country_code' => 'ZZ', 'country_name' => 'Testland', 'usingSD' => 1],
                ['country_name' => 'Renamed Land'],
                ['country_name' => 'Renamed Land'],
            ],
            'cities' => [
                ManageCities::class,
                SystemCity::class,
                'system_cities',
                fn (): array => ['name' => 'Testville', 'active' => true],
                ['name' => 'Testville'],
                ['name' => 'Renamed City'],
                ['name' => 'Renamed City'],
            ],
        ];
    }

    private static function createRegion(): Region
    {
        return Region::query()->create(['name' => 'Test Region', 'description' => '', 'phys_address' => '', 'countryID' => 196]);
    }

    #[Test]
    #[DataProvider('resourceProvider')]
    public function super_admin_can_access_lookup_resource(string $resourceClass): void
    {
        $url = $resourceClass::getUrl('index');

        $this->actingAs($this->superAdmin)
            ->get($url)
            ->assertOk();
    }

    #[Test]
    #[DataProvider('resourceProvider')]
    public function regular_user_is_forbidden_from_lookup_resource(string $resourceClass): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $url = $resourceClass::getUrl('index');

        $this->actingAs($user)
            ->get($url)
            ->assertForbidden();
    }

    #[Test]
    public function guest_is_redirected_when_accessing_lookup_resource(): void
    {
        $url = YouthDocumentTypeResource::getUrl('index');

        $this->get($url)
            ->assertRedirect();
    }

    #[Test]
    #[DataProvider('crudProvider')]
    public function lookup_table_renders_records(string $pageClass, string $modelClass, string $table, Closure $createData, array $expectedAfterCreate, array $editData, array $expectedAfterEdit): void
    {
        $records = $modelClass::factory()->count(3)->create();

        Livewire::actingAs($this->superAdmin)
            ->test($pageClass)
            ->assertOk()
            ->assertCanSeeTableRecords($records);
    }

    #[Test]
    #[DataProvider('crudProvider')]
    public function lookup_record_can_be_created(string $pageClass, string $modelClass, string $table, Closure $createData, array $expectedAfterCreate, array $editData, array $expectedAfterEdit): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test($pageClass)
            ->callAction('create', data: $createData())
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas($table, $expectedAfterCreate);
    }

    #[Test]
    #[DataProvider('crudProvider')]
    public function lookup_record_can_be_edited(string $pageClass, string $modelClass, string $table, Closure $createData, array $expectedAfterCreate, array $editData, array $expectedAfterEdit): void
    {
        $record = $modelClass::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test($pageClass)
            ->callAction(TestAction::make('edit')->table($record), data: $editData)
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas($table, array_merge(
            [$record->getKeyName() => $record->getKey()],
            $expectedAfterEdit,
        ));
    }

    #[Test]
    #[DataProvider('crudProvider')]
    public function lookup_record_can_be_deleted(string $pageClass, string $modelClass, string $table, Closure $createData, array $expectedAfterCreate, array $editData, array $expectedAfterEdit): void
    {
        $record = $modelClass::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test($pageClass)
            ->callAction(TestAction::make('delete')->table($record))
            ->assertHasNoFormErrors();

        $this->assertDatabaseMissing($table, [$record->getKeyName() => $record->getKey()]);
    }

    // --- Regression tests for NOT NULL columns and defaults ---

    #[Test]
    public function youth_document_type_can_be_created_with_empty_description(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ManageYouthDocumentTypes::class)
            ->callAction('create', data: ['name' => 'Minimal Youth Type'])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('system_document_types', [
            'name' => 'Minimal Youth Type',
            'description' => '',
        ]);
    }

    #[Test]
    public function youth_document_type_flag_can_be_turned_off(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ManageYouthDocumentTypes::class)
            ->callAction('create', data: ['name' => 'Adult Only Type', 'youth' => false])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('system_document_types', [
            'name' => 'Adult Only Type',
            'youth' => 0,
        ]);
    }

    #[Test]
    public function group_type_can_be_created_with_empty_description(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ManageGroupTypes::class)
            ->callAction('create', data: ['name' => 'Minimal Group Type'])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('groups_types', [
            'name' => 'Minimal Group Type',
            'description' => '',
        ]);
    }

    #[Test]
    public function training_location_can_be_created_without_optional_contact_details(): void
    {
        $region = self::createRegion();

        Livewire::actingAs($this->superAdmin)
            ->test(ManageTrainingLocations::class)
            ->callAction('create', data: [
                'name' => 'Minimal Venue',
                'assocToRegion' => $region->id,
            ])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('ams_training_locations', [
            'name' => 'Minimal Venue',
            'address' => '',
            'gpsLat' => '',
            'gpsLon' => '',
            'contact' => '',
            'trainingSeats' => 0,
        ]);
    }

    #[Test]
    public function country_create_applies_branch_age_defaults(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ManageCountries::class)
            ->callAction('create', data: ['country_code' => 'ZY', 'country_name' => 'Defaultland'])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('system_country_names', [
            'country_name' => 'Defaultland',
            'branch1StartingAge' => 5.0,
            'branch5EndingAge' => 35.0,
        ]);
    }

    #[Test]
    public function program_type_create_records_the_acting_admin(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ManageScoutProgramTypes::class)
            ->callAction('create', data: ['name' => 'Audited Meeting', 'active' => true])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('system_program_types_scouts', [
            'name' => 'Audited Meeting',
            'createdby' => $this->superAdmin->id,
        ]);
    }

    #[Test]
    public function faq_category_audience_label_reflects_the_flags(): void
    {
        $region = SystemFaqCat::factory()->create(['forRegion' => 1]);
        $multi = SystemFaqCat::factory()->create(['forNational' => 1, 'forAlumni' => 1]);
        $none = SystemFaqCat::factory()->create();

        $this->assertSame('Region', $region->audience);
        $this->assertSame('National, Alumni', $multi->audience);
        $this->assertSame('Not Displayed', $none->audience);
    }

    #[Test]
    public function faq_categories_are_grouped_by_audience(): void
    {
        $records = collect([
            SystemFaqCat::factory()->create(['forNational' => 1]),
            SystemFaqCat::factory()->create(['forGroupScouts' => 1]),
            SystemFaqCat::factory()->create(),
        ]);

        $component = Livewire::actingAs($this->superAdmin)
            ->test(ManageFaqCategories::class)
            ->assertOk()
            ->assertCanSeeTableRecords($records);

        $this->assertSame('audience', $component->instance()->getTable()->getDefaultGroup()?->getId());
    }

    #[Test]
    public function faq_categories_can_be_filtered_by_audience(): void
    {
        $region = SystemFaqCat::factory()->create(['forRegion' => 1]);
        $national = SystemFaqCat::factory()->create(['forNational' => 1]);
        $none = SystemFaqCat::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ManageFaqCategories::class)
            ->filterTable('audience', 'forRegion')
            ->assertCanSeeTableRecords([$region])
            ->assertCanNotSeeTableRecords([$national, $none])
            ->filterTable('audience', 'none')
            ->assertCanSeeTableRecords([$none])
            ->assertCanNotSeeTableRecords([$region, $national]);
    }

    #[Test]
    public function faq_categories_reorder_renumbers_positions_within_each_audience(): void
    {
        [$regionFirst, $regionSecond] = SystemFaqCat::factory()->count(2)->create(['forRegion' => 1, 'position' => 0])->all();
        $national = SystemFaqCat::factory()->create(['forNational' => 1, 'position' => 5]);

        Livewire::actingAs($this->superAdmin)
            ->test(ManageFaqCategories::class)
            ->call('reorderTable', [$regionSecond->id, $national->id, $regionFirst->id]);

        $this->assertSame(1, $regionSecond->refresh()->position);
        $this->assertSame(2, $regionFirst->refresh()->position);
        $this->assertSame(1, $national->refresh()->position);
    }

    #[Test]
    public function faq_entries_reorder_renumbers_positions_within_each_category(): void
    {
        $category = SystemFaqCat::factory()->create();
        $otherCategory = SystemFaqCat::factory()->create();
        [$first, $second] = SystemFaq::factory()->count(2)->create(['catID' => $category->id, 'position' => 0])->all();
        $otherEntry = SystemFaq::factory()->create(['catID' => $otherCategory->id, 'position' => 9]);

        Livewire::actingAs($this->superAdmin)
            ->test(ManageFaqEntries::class)
            ->call('reorderTable', [$second->id, $otherEntry->id, $first->id]);

        $this->assertSame(1, $second->refresh()->position);
        $this->assertSame(2, $first->refresh()->position);
        $this->assertSame(1, $otherEntry->refresh()->position);
    }

    #[Test]
    public function content_editor_modals_are_wide(): void
    {
        foreach ([ManageFaqEntries::class, ManageArticles::class, ManageRoadmapItems::class] as $pageClass) {
            $page = Livewire::actingAs($this->superAdmin)->test($pageClass)->instance();

            $this->assertSame(Width::SevenExtraLarge, $page->getAction('create')?->getModalWidth(), "{$pageClass} create modal is not wide");
        }
    }

    #[Test]
    public function faq_category_view_page_shows_the_category(): void
    {
        $category = SystemFaqCat::factory()->create(['forRegion' => 1, 'name' => 'A Category To View']);

        $this->actingAs($this->superAdmin)
            ->get(FaqCategoryResource::getUrl('view', ['record' => $category]))
            ->assertOk();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewFaqCategory::class, ['record' => $category->getRouteKey()])
            ->assertOk()
            ->assertSee('A Category To View')
            ->assertSee('Region');
    }

    #[Test]
    public function faq_category_relation_manager_lists_only_its_own_entries(): void
    {
        $category = SystemFaqCat::factory()->create();
        $entries = SystemFaq::factory()->count(2)->create(['catID' => $category->id]);
        $otherEntry = SystemFaq::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(FaqsRelationManager::class, ['ownerRecord' => $category, 'pageClass' => ViewFaqCategory::class])
            ->assertOk()
            ->assertCanSeeTableRecords($entries)
            ->assertCanNotSeeTableRecords([$otherEntry]);
    }

    #[Test]
    public function faq_category_relation_manager_can_create_an_entry(): void
    {
        $category = SystemFaqCat::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(FaqsRelationManager::class, ['ownerRecord' => $category, 'pageClass' => ViewFaqCategory::class])
            ->callAction(TestAction::make('create')->table(), data: ['q' => 'A New Question?', 'a' => '<p>An answer.</p>'])
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('system_faq', ['q' => 'A New Question?', 'catID' => $category->id]);
    }

    #[Test]
    public function legacy_html_service_decodes_multi_encoded_content(): void
    {
        $encoded = '&amp;lt;p&amp;gt;Hello &amp;amp;amp; goodbye&amp;lt;/p&amp;gt;';

        $this->assertSame('<p>Hello & goodbye</p>', LegacyHtmlService::decode($encoded));
        $this->assertSame('Hello & goodbye', LegacyHtmlService::preview($encoded));
        $this->assertSame('<p>Clean.</p>', LegacyHtmlService::decode('<p>Clean.</p>'));
        $this->assertNull(LegacyHtmlService::decode(null));
        $this->assertTrue(LegacyHtmlService::usesOnlyLegacyWhitelistedTags('<p>Hello <b>there</b><br></p>'));
        $this->assertTrue(LegacyHtmlService::usesOnlyLegacyWhitelistedTags('No tags at all'));
        $this->assertFalse(LegacyHtmlService::usesOnlyLegacyWhitelistedTags('<p><a href="x">link</a></p>'));
    }

    #[Test]
    public function editing_a_legacy_encoded_faq_entry_normalises_the_answer(): void
    {
        $entry = SystemFaq::factory()->create(['a' => '&amp;lt;p&amp;gt;Old answer&amp;lt;/p&amp;gt;']);

        Livewire::actingAs($this->superAdmin)
            ->test(ManageFaqEntries::class)
            ->callAction(TestAction::make('edit')->table($entry), data: ['q' => 'Updated Question?'])
            ->assertHasNoFormErrors();

        $entry->refresh();
        $this->assertStringContainsString('<p>Old answer</p>', $entry->a);
        $this->assertStringNotContainsString('&amp;', $entry->a);
        $this->assertStringNotContainsString('&lt;', $entry->a);
        $this->assertSame('Updated Question?', $entry->q);
    }

    #[Test]
    public function normalization_migration_decodes_safe_rows_and_skips_whitelist_breaking_rows(): void
    {
        $safe = SystemFaq::factory()->create(['a' => '&amp;lt;p&amp;gt;Safe answer&amp;lt;/p&amp;gt;']);
        $linkEncoded = '&amp;lt;a href=&amp;quot;https://example.test&amp;quot;&amp;gt;A link&amp;lt;/a&amp;gt;';
        $link = SystemFaq::factory()->create(['a' => $linkEncoded]);
        $clean = SystemFaq::factory()->create(['a' => '<p>Already clean.</p>']);
        $article = SdArticle::factory()->create(['intro' => 'Plain &amp;amp; encoded intro', 'article' => '&amp;lt;p&amp;gt;Body&amp;lt;/p&amp;gt;']);
        $roadmap = SystemRoadmapLittle::factory()->create(['text' => '&amp;lt;p&amp;gt;Roadmap&amp;lt;/p&amp;gt;']);

        $migration = include database_path('migrations/2026_08_27_120000_normalize_legacy_html_entity_encoding.php');
        $migration->up();

        $this->assertSame('<p>Safe answer</p>', $safe->refresh()->a);
        $this->assertSame($linkEncoded, $link->refresh()->a);
        $this->assertSame('<p>Already clean.</p>', $clean->refresh()->a);
        $this->assertSame('Plain & encoded intro', $article->refresh()->intro);
        $this->assertSame('<p>Body</p>', $article->article);
        $this->assertSame('<p>Roadmap</p>', $roadmap->refresh()->text);
    }

    #[Test]
    public function every_lookup_resource_defaults_to_twenty_five_rows_per_page(): void
    {
        $resourceFiles = glob(app_path('Filament/Admin/Clusters/LookupTables/Resources/*/*Resource.php'));

        $this->assertNotEmpty($resourceFiles);

        foreach ($resourceFiles as $file) {
            $relativePath = substr($file, strlen(app_path()) + 1, -strlen('.php'));
            $resourceClass = 'App\\' . str_replace('/', '\\', $relativePath);
            $pageClass = $resourceClass::getPages()['index']->getPage();

            $table = Livewire::actingAs($this->superAdmin)
                ->test($pageClass)
                ->instance()
                ->getTable();

            $this->assertSame(25, $table->getDefaultPaginationPageOption(), "{$resourceClass} does not default to 25 rows per page");
        }
    }
}

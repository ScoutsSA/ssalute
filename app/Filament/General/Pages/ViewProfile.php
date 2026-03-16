<?php

namespace App\Filament\General\Pages;

use App\Enums\UserEnglishProficiency;
use App\Enums\UserRace;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Mail\Profile\ReportIssueEmail;
use App\Models\AmsAwardHeading;
use App\Models\AmsAwardInfo;
use App\Models\AmsAwardType;
use App\Models\AmsDocument;
use App\Models\AmsDocumentType;
use App\Models\AmsPastServiceInfo;
use App\Models\AmsPastServiceType;
use App\Models\AmsTrainingPast;
use App\Models\AmsTrainingPastType;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Services\FileUrlService;
use App\Settings\FeatureSettings;
use App\Settings\GeneralSettings;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Mail;

class ViewProfile extends Page
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::UserCircle;

    protected static ?string $navigationLabel = 'My Profile';

    protected static ?string $title = 'My Profile';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.general.pages.view-profile';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->record(auth()->user())
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->persistTabInQueryString('tab')
                    ->tabs([
                        Tab::make('Profile')
                            ->icon(Heroicon::User)
                            ->schema([
                                Section::make('Profile Photo')
                                    ->collapsible()
                                    ->columns(['sm' => 1, 'md' => 2])
                                    ->schema([
                                        ImageEntry::make('thumb')
                                            ->label('Current Thumbnail')
                                            ->getStateUsing(fn ($record) => $record->thumb
                                                ? app(FileUrlService::class)->url($record->thumb)
                                                : null)
                                            ->circular()
                                            ->height(120),
                                        ImageEntry::make('photo')
                                            ->label('Current Photo')
                                            ->getStateUsing(fn ($record) => $record->photo
                                                ? app(FileUrlService::class)->url($record->photo)
                                                : null),
                                        RepeatableEntry::make('pictureChanges')
                                            ->label('Photo History')
                                            ->schema([
                                                ImageEntry::make('pictureLocation')
                                                    ->label('')
                                                    ->getStateUsing(fn ($record) => $record->pictureLocation
                                                        ? app(FileUrlService::class)->url($record->pictureLocation)
                                                        : null)
                                                    ->circular()
                                                    ->height(80),
                                                TextEntry::make('created')
                                                    ->label('Uploaded')
                                                    ->dateTime(),
                                            ])
                                            ->columns(2)
                                            ->hidden(fn ($record) => $record->pictureChanges->isEmpty()),
                                    ])
                                    ->hidden(fn ($record) => ! $record->thumb && $record->pictureChanges->isEmpty()),

                                Section::make('Personal Information')
                                    ->collapsible()
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('ssaId')
                                            ->label('SSA ID')
                                            ->badge()
                                            ->color('primary'),
                                        TextEntry::make('title')
                                            ->formatStateUsing(fn ($state) => $state instanceof UserTitle ? $state->getLabel() : $state)
                                            ->placeholder('-'),
                                        TextEntry::make('first_name')
                                            ->label('First Name')
                                            ->placeholder('-'),
                                        TextEntry::make('otherName')
                                            ->label('Other Name')
                                            ->placeholder('-'),
                                        TextEntry::make('surname')
                                            ->placeholder('-'),
                                        TextEntry::make('previousSurname')
                                            ->label('Previous Surname')
                                            ->placeholder('-'),
                                        TextEntry::make('knownName')
                                            ->label('Known As')
                                            ->placeholder('-'),
                                        TextEntry::make('scoutName')
                                            ->label('Scout Name')
                                            ->placeholder('-'),
                                        TextEntry::make('sex')
                                            ->formatStateUsing(fn ($state) => $state instanceof UserSex ? $state->getLabel() : $state)
                                            ->placeholder('-'),
                                        TextEntry::make('race')
                                            ->formatStateUsing(fn ($state) => $state instanceof UserRace ? $state->getLabel() : $state)
                                            ->placeholder('-'),
                                        TextEntry::make('dob')
                                            ->label('Date of Birth')
                                            ->date()
                                            ->placeholder('-'),
                                        TextEntry::make('dateInvested')
                                            ->label('Date Invested')
                                            ->date()
                                            ->placeholder('-'),
                                        TextEntry::make('startDate')
                                            ->label('Start Date')
                                            ->date()
                                            ->placeholder('-'),
                                        TextEntry::make('lastLoginDate')
                                            ->label('Last SD Login Date')
                                            ->dateTime()
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Identity Documents')
                                    ->collapsible()
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('idNumber')
                                            ->label('ID Number')
                                            ->placeholder('-'),
                                        TextEntry::make('passportNumber')
                                            ->label('Passport Number')
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Contact Details')
                                    ->collapsible()
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('username')
                                            ->label('Email / Username')
                                            ->placeholder('-'),
                                        TextEntry::make('cellNr')
                                            ->label('Cell Number')
                                            ->placeholder('-'),
                                        TextEntry::make('officeNr')
                                            ->label('Office Number')
                                            ->placeholder('-'),
                                        TextEntry::make('homeNr')
                                            ->label('Home Number')
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Address')
                                    ->collapsible()
                                    ->columns(1)
                                    ->schema([
                                        TextEntry::make('phys_address')
                                            ->label('Physical Address')
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                        TextEntry::make('postal_address')
                                            ->label('Postal Address')
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Background')
                                    ->collapsible()
                                    ->collapsed()
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('occupation')
                                            ->placeholder('-'),
                                        TextEntry::make('employer')
                                            ->placeholder('-'),
                                        TextEntry::make('typeOfEmployment')
                                            ->label('Employment Type')
                                            ->placeholder('-'),
                                        TextEntry::make('religiousBelief')
                                            ->label('Religious Belief')
                                            ->placeholder('-'),
                                        TextEntry::make('maritalStatusInfo.name')
                                            ->label('Marital Status')
                                            ->placeholder('-'),
                                        TextEntry::make('highestEducationInfo.name')
                                            ->label('Highest Education')
                                            ->placeholder('-'),
                                        TextEntry::make('hobbies')
                                            ->placeholder('-'),
                                        TextEntry::make('sports')
                                            ->placeholder('-'),
                                        TextEntry::make('interests')
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Languages')
                                    ->collapsible()
                                    ->collapsed()
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('homeLanguageInfo.language')
                                            ->label('Home Language')
                                            ->placeholder('-'),
                                        TextEntry::make('otherLanguageInfo.language')
                                            ->label('Other Language')
                                            ->placeholder('-'),
                                        TextEntry::make('otherLanguages')
                                            ->label('Additional Languages')
                                            ->placeholder('-'),
                                        TextEntry::make('proficiencyInEnglish')
                                            ->label('English Proficiency')
                                            ->formatStateUsing(fn ($state) => $state instanceof UserEnglishProficiency ? $state->getLabel() : $state)
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Medical')
                                    ->collapsible()
                                    ->collapsed()
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('medicalAidName')
                                            ->label('Medical Aid Name')
                                            ->placeholder('-'),
                                        TextEntry::make('medicalAidNr')
                                            ->label('Medical Aid Number')
                                            ->placeholder('-'),
                                        TextEntry::make('medicalAidPrincipalMember')
                                            ->label('Principal Member')
                                            ->placeholder('-'),
                                        TextEntry::make('doctorsName')
                                            ->label("Doctor's Name")
                                            ->placeholder('-'),
                                        TextEntry::make('doctorsPhone')
                                            ->label("Doctor's Phone")
                                            ->placeholder('-'),
                                        TextEntry::make('allergies')
                                            ->placeholder('-'),
                                        TextEntry::make('allergiesInstructions')
                                            ->label('Allergy Instructions')
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                        TextEntry::make('disabilities')
                                            ->placeholder('-'),
                                        TextEntry::make('disabilitiesInstructions')
                                            ->label('Disability Instructions')
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                        TextEntry::make('medicalConditions')
                                            ->label('Medical Conditions')
                                            ->placeholder('-'),
                                        TextEntry::make('medicalConditionsInstructions')
                                            ->label('Conditions Instructions')
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                        TextEntry::make('currentMedication')
                                            ->label('Current Medication')
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                        TextEntry::make('specialMealRequirements')
                                            ->label('Special Meal Requirements')
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Emergency Contact')
                                    ->collapsible()
                                    ->collapsed()
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('emergencyContactName')
                                            ->label('Name')
                                            ->placeholder('-'),
                                        TextEntry::make('emergencyContactCell')
                                            ->label('Cell Number')
                                            ->placeholder('-'),
                                        TextEntry::make('emergencyContactTel')
                                            ->label('Telephone')
                                            ->placeholder('-'),
                                        TextEntry::make('emergencyContactRelationship')
                                            ->label('Relationship')
                                            ->placeholder('-'),
                                    ]),
                            ]),

                        Tab::make('Roles')
                            ->icon(Heroicon::Identification)
                            ->schema([
                                Section::make('Active Roles')
                                    ->collapsible()
                                    ->schema([
                                        RepeatableEntry::make('activeRoleAttachments')
                                            ->label('')
                                            ->schema([
                                                TextEntry::make('role.name')
                                                    ->label('Role'),
                                                TextEntry::make('roleTypeName')
                                                    ->label('Level')
                                                    ->badge()
                                                    ->color('primary'),
                                                TextEntry::make('region.name')
                                                    ->label('Region')
                                                    ->placeholder('-'),
                                                TextEntry::make('district.name')
                                                    ->label('District')
                                                    ->placeholder('-'),
                                                TextEntry::make('group.name')
                                                    ->label('Group')
                                                    ->placeholder('-'),
                                                TextEntry::make('created')
                                                    ->label('Since')
                                                    ->date(),
                                            ])
                                            ->columns(3),
                                    ]),

                                Section::make('Past Roles')
                                    ->collapsed()
                                    ->schema([
                                        RepeatableEntry::make('inactiveRoleAttachments')
                                            ->label('')
                                            ->schema([
                                                TextEntry::make('role.name')
                                                    ->label('Role'),
                                                TextEntry::make('roleTypeName')
                                                    ->label('Level')
                                                    ->badge()
                                                    ->color('gray'),
                                                TextEntry::make('region.name')
                                                    ->label('Region')
                                                    ->placeholder('-'),
                                                TextEntry::make('district.name')
                                                    ->label('District')
                                                    ->placeholder('-'),
                                                TextEntry::make('group.name')
                                                    ->label('Group')
                                                    ->placeholder('-'),
                                                TextEntry::make('created')
                                                    ->label('Since')
                                                    ->date(),
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        Tab::make('Warrants')
                            ->icon(Heroicon::DocumentCheck)
                            ->schema([
                                Section::make('Warrants')
                                    ->schema([
                                        RepeatableEntry::make('warrants')
                                            ->label('')
                                            ->getStateUsing(fn ($record) => $record->warrants()->orderByDesc('active')->orderByDesc('issueDate')->get())
                                            ->schema([
                                                TextEntry::make('warrantNr')
                                                    ->label('Warrant Nr')
                                                    ->badge()
                                                    ->color('primary'),
                                                TextEntry::make('warrantType.name')
                                                    ->label('Type'),
                                                TextEntry::make('role.name')
                                                    ->label('Role')
                                                    ->placeholder('-'),
                                                TextEntry::make('region.name')
                                                    ->label('Region')
                                                    ->placeholder('-'),
                                                TextEntry::make('district.name')
                                                    ->label('District')
                                                    ->placeholder('-'),
                                                TextEntry::make('group.name')
                                                    ->label('Group')
                                                    ->placeholder('-'),
                                                TextEntry::make('issueDate')
                                                    ->label('Issued')
                                                    ->date(),
                                                TextEntry::make('expireDate')
                                                    ->label('Expires')
                                                    ->date(),
                                                TextEntry::make('active')
                                                    ->label('Status')
                                                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                                                    ->badge()
                                                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                                                TextEntry::make('PDFLocation')
                                                    ->label('Document')
                                                    ->formatStateUsing(fn ($state) => $state ? 'View Document' : null)
                                                    ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                                                    ->openUrlInNewTab()
                                                    ->badge()
                                                    ->color('primary')
                                                    ->placeholder('-'),
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        Tab::make('Training')
                            ->icon(Heroicon::AcademicCap)
                            ->schema([
                                Section::make('Training History')
                                    ->afterHeader([
                                        Action::make('addTraining')
                                            ->label('Add Training')
                                            ->icon(Heroicon::Plus)
                                            ->visible(fn () => resolve(FeatureSettings::class)->users_can_add_past_training)
                                            ->modalHeading('Add Past Training')
                                            ->schema([
                                                Select::make('trainingTypeID')
                                                    ->label('Training Type')
                                                    ->options(fn () => AmsTrainingPastType::where('active', 1)->pluck('name', 'id'))
                                                    ->searchable(),
                                                TextInput::make('courseName')
                                                    ->label('Course Name')
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('courseNumber')
                                                    ->label('Course Number')
                                                    ->maxLength(255),
                                                DatePicker::make('completionDate')
                                                    ->label('Completion Date'),
                                            ])
                                            ->action(function (array $data): void {
                                                $user = auth()->user();
                                                $tenant = Filament::getTenant();

                                                AmsTrainingPast::create([
                                                    'userID' => $user->id,
                                                    'countryID' => $tenant->countryID ?? 196,
                                                    'assocToRegion' => $tenant->regionID,
                                                    'assocToDistrict' => $tenant->districtID,
                                                    'assocToGroup' => $tenant->groupID,
                                                    'trainingTypeID' => $data['trainingTypeID'] ?? null,
                                                    'courseName' => $data['courseName'],
                                                    'courseNumber' => $data['courseNumber'] ?? null,
                                                    'completionDate' => $data['completionDate'] ?? null,
                                                    'active' => 1,
                                                    'validated' => 0,
                                                    'createdby' => $user->id,
                                                ]);

                                                Notification::make()->title('Training record added')->success()->send();
                                            }),
                                    ])
                                    ->schema([
                                        RepeatableEntry::make('trainingHistory')
                                            ->label('')
                                            ->schema([
                                                TextEntry::make('trainingType.name')
                                                    ->label('Type')
                                                    ->placeholder('-'),
                                                TextEntry::make('courseName')
                                                    ->label('Course Name')
                                                    ->placeholder('-'),
                                                TextEntry::make('courseNumber')
                                                    ->label('Course Nr')
                                                    ->placeholder('-'),
                                                TextEntry::make('completionDate')
                                                    ->label('Completed')
                                                    ->date(),
                                                TextEntry::make('validated')
                                                    ->label('Validated')
                                                    ->formatStateUsing(fn ($state) => $state ? 'Validated' : 'Pending')
                                                    ->badge()
                                                    ->color(fn ($state) => $state ? 'success' : 'warning'),
                                                TextEntry::make('PDFLocation')
                                                    ->label('Certificate')
                                                    ->formatStateUsing(fn ($state) => $state ? 'View Certificate' : null)
                                                    ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                                                    ->openUrlInNewTab()
                                                    ->badge()
                                                    ->color('primary')
                                                    ->placeholder('-'),
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        Tab::make('Awards')
                            ->icon(Heroicon::Trophy)
                            ->schema([
                                Section::make('Awards')
                                    ->afterHeader([
                                        Action::make('addAward')
                                            ->label('Add Award')
                                            ->icon(Heroicon::Plus)
                                            ->visible(fn () => resolve(FeatureSettings::class)->users_can_add_awards)
                                            ->modalHeading('Add Award')
                                            ->schema([
                                                Select::make('awardHeadingID')
                                                    ->label('Award Category')
                                                    ->options(fn () => AmsAwardHeading::pluck('reason', 'id'))
                                                    ->required()
                                                    ->searchable()
                                                    ->live(),
                                                Select::make('awardTypeID')
                                                    ->label('Award')
                                                    ->options(fn (Get $get) => AmsAwardType::query()
                                                        ->when($get('awardHeadingID'), fn ($q, $headingId) => $q->where('headingID', $headingId))
                                                        ->where('active', 1)
                                                        ->pluck('name', 'id'))
                                                    ->required()
                                                    ->searchable(),
                                                DatePicker::make('awardDate')
                                                    ->label('Award Date'),
                                            ])
                                            ->action(function (array $data): void {
                                                $user = auth()->user();
                                                $tenant = Filament::getTenant();

                                                AmsAwardInfo::create([
                                                    'userID' => $user->id,
                                                    'countryID' => $tenant->countryID ?? 196,
                                                    'assocToRegion' => $tenant->regionID,
                                                    'assocToDistrict' => $tenant->districtID,
                                                    'assocToGroup' => $tenant->groupID,
                                                    'awardHeadingID' => $data['awardHeadingID'],
                                                    'awardTypeID' => $data['awardTypeID'],
                                                    'awardDate' => $data['awardDate'] ?? null,
                                                    'active' => 1,
                                                    'createdby' => $user->id,
                                                ]);

                                                Notification::make()->title('Award added')->success()->send();
                                            }),
                                    ])
                                    ->schema([
                                        RepeatableEntry::make('awards')
                                            ->label('')
                                            ->schema([
                                                TextEntry::make('heading.reason')
                                                    ->label('Category'),
                                                TextEntry::make('awardType.name')
                                                    ->label('Award'),
                                                TextEntry::make('awardDate')
                                                    ->label('Date')
                                                    ->date(),
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        Tab::make('Documents')
                            ->icon(Heroicon::FolderOpen)
                            ->schema([
                                Section::make('Documents on File')
                                    ->afterHeader([
                                        Action::make('addDocument')
                                            ->label('Add Document')
                                            ->icon(Heroicon::Plus)
                                            ->visible(fn () => resolve(FeatureSettings::class)->users_can_add_documents)
                                            ->modalHeading('Upload Document')
                                            ->schema([
                                                Select::make('documentTypeID')
                                                    ->label('Document Type')
                                                    ->options(fn () => AmsDocumentType::where('active', 1)->pluck('name', 'id'))
                                                    ->required()
                                                    ->searchable(),
                                                TextInput::make('description')
                                                    ->label('Description')
                                                    ->required()
                                                    ->maxLength(255),
                                            ])
                                            ->action(function (array $data): void {
                                                $user = auth()->user();
                                                $tenant = Filament::getTenant();

                                                AmsDocument::create([
                                                    'userID' => $user->id,
                                                    'countryID' => $tenant->countryID ?? 196,
                                                    'assocToRegion' => $tenant->regionID,
                                                    'assocToDistrict' => $tenant->districtID,
                                                    'assocToGroup' => $tenant->groupID,
                                                    'documentTypeID' => $data['documentTypeID'],
                                                    'description' => $data['description'],
                                                    'active' => 1,
                                                    'createdby' => $user->id,
                                                ]);

                                                Notification::make()->title('Document added')->success()->send();
                                            }),
                                    ])
                                    ->schema([
                                        RepeatableEntry::make('documents')
                                            ->label('')
                                            ->schema([
                                                TextEntry::make('documentType.name')
                                                    ->label('Document Type'),
                                                TextEntry::make('description')
                                                    ->label('Description')
                                                    ->placeholder('-'),
                                                TextEntry::make('active')
                                                    ->label('Status')
                                                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                                                    ->badge()
                                                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                                                TextEntry::make('created')
                                                    ->label('Uploaded')
                                                    ->date(),
                                                TextEntry::make('PDFLocation')
                                                    ->label('File')
                                                    ->formatStateUsing(fn ($state) => $state ? 'View Document' : null)
                                                    ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                                                    ->openUrlInNewTab()
                                                    ->placeholder('-'),
                                            ])
                                            ->columns(2),
                                    ]),
                            ]),

                        Tab::make('Clearances & Service')
                            ->icon(Heroicon::ShieldCheck)
                            ->schema([
                                Section::make('Police Clearances')
                                    ->schema([
                                        RepeatableEntry::make('policeClearances')
                                            ->label('')
                                            ->schema([
                                                TextEntry::make('result')
                                                    ->label('Result'),
                                                TextEntry::make('dateDone')
                                                    ->label('Date Done')
                                                    ->date(),
                                                TextEntry::make('active')
                                                    ->label('Status')
                                                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                                                    ->badge()
                                                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                                                TextEntry::make('documentLocation')
                                                    ->label('Document')
                                                    ->formatStateUsing(fn ($state) => $state ? 'View Document' : null)
                                                    ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                                                    ->openUrlInNewTab()
                                                    ->badge()
                                                    ->color('primary')
                                                    ->placeholder('-'),
                                            ])
                                            ->columns(3),
                                    ]),

                                Section::make('Service History')
                                    ->afterHeader([
                                        Action::make('addPastService')
                                            ->label('Add Past Service')
                                            ->icon(Heroicon::Plus)
                                            ->visible(fn () => resolve(FeatureSettings::class)->users_can_add_past_service)
                                            ->modalHeading('Add Past Service')
                                            ->schema([
                                                Select::make('pastServiceType')
                                                    ->label('Service Type')
                                                    ->options(fn () => AmsPastServiceType::pluck('name', 'id'))
                                                    ->required()
                                                    ->searchable(),
                                                DatePicker::make('startDate')
                                                    ->label('Start Date')
                                                    ->required(),
                                                DatePicker::make('endDate')
                                                    ->label('End Date'),
                                                TextInput::make('otherRegionName')
                                                    ->label('Region')
                                                    ->maxLength(255),
                                                TextInput::make('otherDistrictName')
                                                    ->label('District')
                                                    ->maxLength(255),
                                                TextInput::make('otherGroupName')
                                                    ->label('Group')
                                                    ->maxLength(255),
                                            ])
                                            ->action(function (array $data): void {
                                                $user = auth()->user();
                                                $tenant = Filament::getTenant();

                                                AmsPastServiceInfo::create([
                                                    'userID' => $user->id,
                                                    'countryID' => $tenant->countryID ?? 196,
                                                    'assocToRegion' => $tenant->regionID,
                                                    'assocToDistrict' => $tenant->districtID,
                                                    'assocToGroup' => $tenant->groupID,
                                                    'pastServiceType' => $data['pastServiceType'],
                                                    'startDate' => $data['startDate'],
                                                    'endDate' => $data['endDate'] ?? null,
                                                    'otherRegionName' => $data['otherRegionName'] ?? null,
                                                    'otherDistrictName' => $data['otherDistrictName'] ?? null,
                                                    'otherGroupName' => $data['otherGroupName'] ?? null,
                                                    'active' => 1,
                                                    'createdby' => $user->id,
                                                ]);

                                                Notification::make()->title('Past service added')->success()->send();
                                            }),
                                    ])
                                    ->schema([
                                        RepeatableEntry::make('pastService')
                                            ->label('')
                                            ->schema([
                                                TextEntry::make('serviceType.name')
                                                    ->label('Service Type')
                                                    ->placeholder('-'),
                                                TextEntry::make('startDate')
                                                    ->label('Start Date')
                                                    ->date(),
                                                TextEntry::make('endDate')
                                                    ->label('End Date')
                                                    ->date()
                                                    ->placeholder('-'),
                                                TextEntry::make('otherRegionName')
                                                    ->label('Region')
                                                    ->placeholder('-'),
                                                TextEntry::make('otherDistrictName')
                                                    ->label('District')
                                                    ->placeholder('-'),
                                                TextEntry::make('otherGroupName')
                                                    ->label('Group')
                                                    ->placeholder('-'),
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit Profile')
                ->icon(Heroicon::PencilSquare)
                ->url(fn () => EditProfile::getUrl())
                ->visible(fn () => resolve(FeatureSettings::class)->users_can_edit_profiles),

            Action::make('reportIssue')
                ->label('Report Issue')
                ->icon(Heroicon::Flag)
                ->color('danger')
                ->modalHeading('Report an Issue')
                ->modalDescription('Describe the issue you are experiencing. It will be sent to your next in line scouter, or to the national adult support team.')
                ->schema([
                    Textarea::make('description')
                        ->label('Describe the issue')
                        ->required()
                        ->rows(5)
                        ->columnSpanFull(),
                    ToggleButtons::make('send_to_national')
                        ->label('Send to')
                        ->options(function () {
                            $scouter = $this->resolveNextInLineScouters(auth()->user(), app(GeneralSettings::class))->first();
                            $name = $scouter ? trim("{$scouter->first_name} {$scouter->surname}") : null;
                            $label = $name ? 'Next in Line Scouter - ' . (mb_strlen($name) > 15 ? mb_substr($name, 0, 15) . '…' : $name) : 'Next in Line Scouter';

                            return [
                                false => $label,
                                true => 'National Adult Support Team',
                            ];
                        })
                        ->icons([
                            false => Heroicon::UserGroup,
                            true => Heroicon::BuildingOffice2,
                        ])
                        ->colors([
                            false => 'primary',
                            true => 'danger',
                        ])
                        ->default(false)
                        ->helperText('Please only escalate to the National Adult Support Team if your next in line scouter has been unable to help.')
                        ->columnSpanFull(),
                ])
                ->action(function (array $data): void {
                    $reporter = auth()->user();
                    $sendToNational = $data['send_to_national'];
                    $generalSettings = app(GeneralSettings::class);

                    $nationalUsers = $this->resolveNationalSupportUsers($generalSettings);
                    $nationalEmails = $nationalUsers->map(fn ($u) => $u->username)->filter()->all();

                    if ($sendToNational) {
                        $to = $nationalEmails;
                        $sentToNational = true;
                    } else {
                        $scouters = $this->resolveNextInLineScouters($reporter, $generalSettings);
                        $to = $scouters->isEmpty()
                            ? $nationalEmails
                            : $scouters->map(fn ($u) => $u->username)->filter()->all();
                        $sentToNational = $scouters->isEmpty();
                    }

                    $to = array_filter($to, fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL));

                    if (empty($to)) {
                        Notification::make()
                            ->title('No valid email recipients found')
                            ->danger()
                            ->send();

                        return;
                    }

                    Mail::to($to)
                        ->cc($reporter->username)
                        ->send(new ReportIssueEmail($reporter, $data['description'], $sentToNational));

                    Notification::make()
                        ->title('Issue reported successfully')
                        ->success()
                        ->send();
                }),
        ];
    }

    /**
     * Resolve all active users who hold a National Adult Support role.
     *
     * @return \Illuminate\Support\Collection<int, \App\Models\SystemUser>
     */
    private function resolveNationalSupportUsers(GeneralSettings $generalSettings): \Illuminate\Support\Collection
    {
        $roleIds = $generalSettings->national_support_role_ids ?? [];

        if (empty($roleIds)) {
            return collect();
        }

        return SystemUsersOtherRole::query()
            ->whereIn('roleID', $roleIds)
            ->where('active', 1)
            ->with('user')
            ->get()
            ->map(fn ($attachment) => $attachment->user)
            ->filter()
            ->unique('id')
            ->values();
    }

    /**
     * Resolve next-in-line scouter users for the reporter.
     * Walks from group → district → regional → national until recipients are found.
     *
     * @return \Illuminate\Support\Collection<int, \App\Models\SystemUser>
     */
    private function resolveNextInLineScouters(SystemUser $reporter, GeneralSettings $generalSettings): \Illuminate\Support\Collection
    {
        $levels = [
            ['roleKey' => 'next_in_line_role_group',    'fk' => 'groupID'],
            ['roleKey' => 'next_in_line_role_district', 'fk' => 'districtID'],
            ['roleKey' => 'next_in_line_role_regional', 'fk' => 'regionID'],
            ['roleKey' => 'next_in_line_role_national', 'fk' => null],
        ];

        $primaryRole = Filament::getTenant();

        foreach ($levels as $level) {
            $roleId = $generalSettings->{$level['roleKey']};

            if (! $roleId) {
                continue;
            }

            $query = SystemUsersOtherRole::query()
                ->where('roleID', $roleId)
                ->where('active', 1)
                ->with('user');

            if ($level['fk'] && $primaryRole?->{$level['fk']}) {
                $query->where($level['fk'], $primaryRole->{$level['fk']});
            }

            $users = $query->get()
                ->map(fn ($attachment) => $attachment->user)
                ->filter()
                ->values();

            if ($users->isNotEmpty()) {
                return $users;
            }
        }

        return collect();
    }
}

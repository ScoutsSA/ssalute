<?php

namespace App\Filament\General\Pages;

use App\Enums\UserEnglishProficiency;
use App\Enums\UserRace;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Models\AmsHighestEducation;
use App\Models\AmsLanguage;
use App\Models\AmsMaritalStatus;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class EditProfile extends Page
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::PencilSquare;

    protected static ?string $title = 'Edit Profile';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    protected string $view = 'filament.general.pages.edit-profile';

    public function mount(): void
    {
        $user = auth()->user();

        $this->form->fill([
            'title' => $user->title,
            'first_name' => $user->first_name,
            'otherName' => $user->otherName,
            'surname' => $user->surname,
            'previousSurname' => $user->previousSurname,
            'knownName' => $user->knownName,
            'scoutName' => $user->scoutName,
            'sex' => $user->sex,
            'race' => $user->race,
            'dob' => $user->dob,
            'idNumber' => $user->idNumber,
            'passportNumber' => $user->passportNumber,
            'username' => $user->username,
            'cellNr' => $user->cellNr,
            'officeNr' => $user->officeNr,
            'homeNr' => $user->homeNr,
            'phys_address' => $user->phys_address,
            'postal_address' => $user->postal_address,
            'occupation' => $user->occupation,
            'typeOfEmployment' => $user->typeOfEmployment,
            'employer' => $user->employer,
            'maritalStatus' => $user->maritalStatus,
            'highestEducation' => $user->highestEducation,
            'religiousBelief' => $user->religiousBelief,
            'hobbies' => $user->hobbies,
            'sports' => $user->sports,
            'interests' => $user->interests,
            'homeLanguage' => $user->homeLanguage,
            'otherLanguage' => $user->otherLanguage,
            'otherLanguages' => $user->otherLanguages,
            'proficiencyInEnglish' => $user->proficiencyInEnglish,
            'medicalAidName' => $user->medicalAidName,
            'medicalAidNr' => $user->medicalAidNr,
            'medicalAidPrincipalMember' => $user->medicalAidPrincipalMember,
            'doctorsName' => $user->doctorsName,
            'doctorsPhone' => $user->doctorsPhone,
            'allergies' => $user->allergies,
            'allergiesInstructions' => $user->allergiesInstructions,
            'disabilities' => $user->disabilities,
            'disabilitiesInstructions' => $user->disabilitiesInstructions,
            'medicalConditions' => $user->medicalConditions,
            'medicalConditionsInstructions' => $user->medicalConditionsInstructions,
            'currentMedication' => $user->currentMedication,
            'specialMealRequirements' => $user->specialMealRequirements,
            'emergencyContactName' => $user->emergencyContactName,
            'emergencyContactCell' => $user->emergencyContactCell,
            'emergencyContactTel' => $user->emergencyContactTel,
            'emergencyContactRelationship' => $user->emergencyContactRelationship,
        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Exclude username — users cannot change their login email here
        unset($data['username']);

        auth()->user()->update($data);

        Notification::make()
            ->title('Profile saved')
            ->success()
            ->send();

        $this->redirect(ViewProfile::getUrl(panel: 'general', tenant: Filament::getTenant()));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->persistTabInQueryString('tab')
                    ->tabs([
                        Tab::make('Personal')
                            ->icon(Heroicon::User)
                            ->schema([
                                Section::make('Name')
                                    ->columns(3)
                                    ->schema([
                                        Select::make('title')
                                            ->options(UserTitle::class)
                                            ->placeholder('-'),
                                        TextInput::make('first_name')
                                            ->label('First Name'),
                                        TextInput::make('otherName')
                                            ->label('Other Name'),
                                        TextInput::make('surname'),
                                        TextInput::make('previousSurname')
                                            ->label('Previous Surname'),
                                        TextInput::make('knownName')
                                            ->label('Known As'),
                                        TextInput::make('scoutName')
                                            ->label('Scout Name'),
                                    ]),

                                Section::make('Details')
                                    ->columns(3)
                                    ->schema([
                                        Select::make('sex')
                                            ->options(UserSex::class),
                                        Select::make('race')
                                            ->options(UserRace::class),
                                        DatePicker::make('dob')
                                            ->label('Date of Birth')
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->helperText('Contact an administrator to change your date of birth.'),
                                        TextInput::make('idNumber')
                                            ->label('ID Number')
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->helperText('Contact an administrator to change your ID number.'),
                                        TextInput::make('passportNumber')
                                            ->label('Passport Number')
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->helperText('Contact an administrator to change your passport number.'),
                                    ]),
                            ]),

                        Tab::make('Contact')
                            ->icon(Heroicon::Phone)
                            ->schema([
                                Section::make('Contact Details')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('username')
                                            ->label('Email / Username')
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->helperText('Contact an administrator to change your login email.'),
                                        TextInput::make('cellNr')
                                            ->label('Cell Number')
                                            ->tel(),
                                        TextInput::make('officeNr')
                                            ->label('Office Number')
                                            ->tel(),
                                        TextInput::make('homeNr')
                                            ->label('Home Number')
                                            ->tel(),
                                    ]),
                            ]),

                        Tab::make('Address')
                            ->icon(Heroicon::MapPin)
                            ->schema([
                                Section::make('Address')
                                    ->columns(1)
                                    ->schema([
                                        Textarea::make('phys_address')
                                            ->label('Physical Address')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        Textarea::make('postal_address')
                                            ->label('Postal Address')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Background')
                            ->icon(Heroicon::Briefcase)
                            ->schema([
                                Section::make('Employment')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('occupation')
                                            ->label('Occupation'),
                                        TextInput::make('employer')
                                            ->label('Employer'),
                                        TextInput::make('typeOfEmployment')
                                            ->label('Employment Type'),
                                    ]),

                                Section::make('Personal Details')
                                    ->columns(3)
                                    ->schema([
                                        Select::make('maritalStatus')
                                            ->label('Marital Status')
                                            ->options(fn () => AmsMaritalStatus::orderBy('name')->pluck('name', 'id'))
                                            ->placeholder('-'),
                                        Select::make('highestEducation')
                                            ->label('Highest Education')
                                            ->options(fn () => AmsHighestEducation::orderBy('name')->pluck('name', 'id'))
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Personal Interests')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('religiousBelief')
                                            ->label('Religious Belief'),
                                        Textarea::make('hobbies')
                                            ->rows(2),
                                        Textarea::make('sports')
                                            ->rows(2),
                                        Textarea::make('interests')
                                            ->rows(2),
                                    ]),
                            ]),

                        Tab::make('Medical')
                            ->icon(Heroicon::Heart)
                            ->schema([
                                Section::make('Medical Aid')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('medicalAidName')
                                            ->label('Medical Aid Name'),
                                        TextInput::make('medicalAidNr')
                                            ->label('Medical Aid Number'),
                                        TextInput::make('medicalAidPrincipalMember')
                                            ->label('Principal Member'),
                                    ]),

                                Section::make('Doctor')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('doctorsName')
                                            ->label("Doctor's Name"),
                                        TextInput::make('doctorsPhone')
                                            ->label("Doctor's Phone")
                                            ->tel(),
                                    ]),

                                Section::make('Health Information')
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('allergies')
                                            ->label('Allergies'),
                                        Textarea::make('allergiesInstructions')
                                            ->label('Allergy Instructions')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        TextInput::make('disabilities')
                                            ->label('Disabilities'),
                                        Textarea::make('disabilitiesInstructions')
                                            ->label('Disability Instructions')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        TextInput::make('medicalConditions')
                                            ->label('Medical Conditions'),
                                        Textarea::make('medicalConditionsInstructions')
                                            ->label('Conditions Instructions')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        Textarea::make('currentMedication')
                                            ->label('Current Medication')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        TextInput::make('specialMealRequirements')
                                            ->label('Special Meal Requirements'),
                                    ]),
                            ]),

                        Tab::make('Languages')
                            ->icon(Heroicon::Language)
                            ->schema([
                                Section::make('Languages')
                                    ->columns(3)
                                    ->schema([
                                        Select::make('homeLanguage')
                                            ->label('Home Language')
                                            ->options(fn () => AmsLanguage::orderBy('language')->pluck('language', 'id'))
                                            ->searchable()
                                            ->placeholder('-'),
                                        Select::make('otherLanguage')
                                            ->label('Other Language')
                                            ->options(fn () => AmsLanguage::orderBy('language')->pluck('language', 'id'))
                                            ->searchable()
                                            ->placeholder('-'),
                                        TextInput::make('otherLanguages')
                                            ->label('Additional Languages'),
                                        Select::make('proficiencyInEnglish')
                                            ->label('English Proficiency')
                                            ->options(UserEnglishProficiency::class)
                                            ->placeholder('-'),
                                    ]),
                            ]),

                        Tab::make('Emergency Contact')
                            ->icon(Heroicon::ExclamationTriangle)
                            ->schema([
                                Section::make('Emergency Contact')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('emergencyContactName')
                                            ->label('Name'),
                                        TextInput::make('emergencyContactCell')
                                            ->label('Cell Number')
                                            ->tel(),
                                        TextInput::make('emergencyContactTel')
                                            ->label('Telephone')
                                            ->tel(),
                                        TextInput::make('emergencyContactRelationship')
                                            ->label('Relationship'),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->icon(Heroicon::Check)
                ->action(fn () => $this->save()),
            Action::make('cancel')
                ->label('Cancel')
                ->icon(Heroicon::XMark)
                ->color('gray')
                ->url(fn () => ViewProfile::getUrl(panel: 'general', tenant: Filament::getTenant())),
        ];
    }
}

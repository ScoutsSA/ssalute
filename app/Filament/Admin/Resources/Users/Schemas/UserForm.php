<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Enums\UserBranchTypes;
use App\Enums\UserEnglishProficiency;
use App\Enums\UserRace;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Models\AmsHighestEducation;
use App\Models\AmsLanguage;
use App\Models\AmsMaritalStatus;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->persistTabInQueryString('tab')
                    ->tabs([

                        Tab::make('Profile')
                            ->icon(Heroicon::User)
                            ->schema([
                                Section::make('Account')
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextInput::make('username')
                                            ->label('Email / Username')
                                            ->email()
                                            ->required(),
                                        DatePicker::make('startDate')
                                            ->label('Start Date'),
                                        DatePicker::make('dateInvested')
                                            ->label('Date Invested'),
                                        Toggle::make('active')
                                            ->inline(false),
                                        Toggle::make('canLogon')
                                            ->label('Can Log On')
                                            ->inline(false),
                                        Toggle::make('mustChangePassword')
                                            ->label('Must Change Password')
                                            ->inline(false),
                                    ]),

                                Section::make('Personal Information')
                                    ->columns(['sm' => 2, 'md' => 3])
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
                                        TextInput::make('partnersFullName')
                                            ->label("Partner's Full Name"),
                                        Select::make('sex')
                                            ->options(UserSex::class),
                                        Select::make('race')
                                            ->options(UserRace::class),
                                        DatePicker::make('dob')
                                            ->label('Date of Birth'),
                                        TextInput::make('school'),
                                        Select::make('branch')
                                            ->options(UserBranchTypes::class)
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Identity Documents')
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextInput::make('idNumber')
                                            ->label('ID Number'),
                                        TextInput::make('IDBookLocation')
                                            ->label('ID Book File'),
                                        TextInput::make('passportNumber')
                                            ->label('Passport Number'),
                                        TextInput::make('passportCountry')
                                            ->label('Passport Country')
                                            ->numeric(),
                                    ]),

                                Section::make('Contact Details')
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextInput::make('cellNr')
                                            ->label('Cell Number')
                                            ->tel(),
                                        TextInput::make('officeNr')
                                            ->label('Office Number')
                                            ->tel(),
                                        TextInput::make('homeNr')
                                            ->label('Home Number')
                                            ->tel(),
                                        TextInput::make('faxNr')
                                            ->label('Fax Number')
                                            ->tel(),
                                    ]),

                                Section::make('Address')
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

                                Section::make('Background')
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextInput::make('occupation'),
                                        TextInput::make('typeOfEmployment')
                                            ->label('Employment Type'),
                                        TextInput::make('employer'),
                                        Select::make('maritalStatus')
                                            ->label('Marital Status')
                                            ->options(fn () => AmsMaritalStatus::orderBy('name')->pluck('name', 'id'))
                                            ->placeholder('-'),
                                        Select::make('highestEducation')
                                            ->label('Highest Education')
                                            ->options(fn () => AmsHighestEducation::orderBy('name')->pluck('name', 'id'))
                                            ->placeholder('-'),
                                        TextInput::make('nrOfChildrenBoys')
                                            ->label('Children (Boys)')
                                            ->numeric(),
                                        TextInput::make('nrOfChildrenGirls')
                                            ->label('Children (Girls)')
                                            ->numeric(),
                                        TextInput::make('religiousBelief')
                                            ->label('Religious Belief'),
                                        TextInput::make('religion'),
                                        TextInput::make('religiousAffiliation')
                                            ->label('Religious Affiliation'),
                                        Textarea::make('hobbies')
                                            ->columnSpanFull(),
                                        Textarea::make('sports')
                                            ->columnSpanFull(),
                                        Textarea::make('interests')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Languages')
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        Select::make('homeLanguage')
                                            ->label('Home Language')
                                            ->options(fn () => AmsLanguage::orderBy('language')->pluck('language', 'id'))
                                            ->placeholder('-'),
                                        Select::make('otherLanguage')
                                            ->label('Other Language')
                                            ->options(fn () => AmsLanguage::orderBy('language')->pluck('language', 'id'))
                                            ->placeholder('-'),
                                        Textarea::make('otherLanguages')
                                            ->label('Additional Languages')
                                            ->columnSpanFull(),
                                        Select::make('proficiencyInEnglish')
                                            ->label('English Proficiency')
                                            ->options(UserEnglishProficiency::class)
                                            ->placeholder('-'),
                                    ]),
                            ]),

                        Tab::make('Medical & Emergency')
                            ->icon(Heroicon::Heart)
                            ->schema([
                                Section::make('Medical Aid')
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextInput::make('medicalAidName')
                                            ->label('Medical Aid Name'),
                                        TextInput::make('medicalAidNr')
                                            ->label('Medical Aid Number'),
                                        TextInput::make('medicalAidPrincipalMember')
                                            ->label('Principal Member'),
                                        TextInput::make('doctorsName')
                                            ->label("Doctor's Name"),
                                        TextInput::make('doctorsPhone')
                                            ->label("Doctor's Phone")
                                            ->tel(),
                                    ]),

                                Section::make('Health')
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextInput::make('allergies'),
                                        Textarea::make('allergiesInstructions')
                                            ->label('Allergy Instructions')
                                            ->columnSpanFull(),
                                        TextInput::make('disabilities'),
                                        Textarea::make('disabilitiesInstructions')
                                            ->label('Disability Instructions')
                                            ->columnSpanFull(),
                                        TextInput::make('medicalConditions')
                                            ->label('Medical Conditions'),
                                        Textarea::make('medicalConditionsInstructions')
                                            ->label('Conditions Instructions')
                                            ->columnSpanFull(),
                                        Textarea::make('currentMedication')
                                            ->label('Current Medication')
                                            ->columnSpanFull(),
                                        Textarea::make('specialMealRequirements')
                                            ->label('Special Meal Requirements')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Emergency Contact')
                                    ->columns(['sm' => 2, 'md' => 3])
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

                        Tab::make('References')
                            ->icon(Heroicon::UserGroup)
                            ->schema([
                                Section::make('Reference 1')
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextInput::make('ref1Name')
                                            ->label('Name'),
                                        TextInput::make('ref1Tel')
                                            ->label('Phone')
                                            ->tel(),
                                        Textarea::make('ref1Address')
                                            ->label('Address')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Reference 2')
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextInput::make('ref2Name')
                                            ->label('Name'),
                                        TextInput::make('ref2Tel')
                                            ->label('Phone')
                                            ->tel(),
                                        Textarea::make('ref2Address')
                                            ->label('Address')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('System')
                            ->icon(Heroicon::Cog6Tooth)
                            ->schema([
                                Section::make('Identifiers')
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextInput::make('SSANumber')
                                            ->label('SSA Number'),
                                        TextInput::make('oldID')
                                            ->label('Legacy ID')
                                            ->numeric(),
                                        TextInput::make('multiID')
                                            ->label('Multi ID')
                                            ->numeric(),
                                    ]),

                                Section::make('Access Flags')
                                    ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                                    ->schema([
                                        Toggle::make('active')
                                            ->inline(false),
                                        Toggle::make('canLogon')
                                            ->label('Can Log On')
                                            ->inline(false),
                                        Toggle::make('mustChangePassword')
                                            ->label('Must Change Password')
                                            ->inline(false),
                                        Toggle::make('canAdmin')
                                            ->label('Can Admin')
                                            ->inline(false),
                                        Toggle::make('infoRedacted')
                                            ->label('Info Redacted')
                                            ->inline(false),
                                        Toggle::make('orphaned')
                                            ->inline(false),
                                        Toggle::make('vulnerable')
                                            ->inline(false),
                                        Toggle::make('responsible_for_payment')
                                            ->label('Responsible For Payment')
                                            ->inline(false),
                                        Toggle::make('form29Generated')
                                            ->label('Form 29 Generated')
                                            ->inline(false),
                                        DateTimePicker::make('dateDeactivated')
                                            ->label('Date Deactivated'),
                                        TextInput::make('deactivatedBy')
                                            ->label('Deactivated By')
                                            ->numeric(),
                                    ]),

                                Section::make('Associations')
                                    ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                                    ->schema([
                                        Select::make('assoc_to_region')
                                            ->label('Home Region')
                                            ->options(fn () => Region::orderBy('name')->pluck('name', 'id'))
                                            ->searchable()
                                            ->placeholder('None')
                                            ->live()
                                            ->afterStateUpdated(function (Set $set): void {
                                                $set('assoc_to_district', null);
                                                $set('assoc_to_group', null);
                                            }),
                                        Select::make('assoc_to_district')
                                            ->label('Home District')
                                            ->options(fn (Get $get, ?SystemUser $record) => self::homeDistrictOptions(
                                                $get('assoc_to_region') !== null ? (int) $get('assoc_to_region') : null,
                                                $record?->assoc_to_district,
                                            ))
                                            ->searchable()
                                            ->placeholder('None')
                                            ->live()
                                            ->afterStateUpdated(fn (Set $set) => $set('assoc_to_group', null)),
                                        Select::make('assoc_to_group')
                                            ->label('Home Group')
                                            ->options(fn (Get $get, ?SystemUser $record) => self::homeGroupOptions(
                                                $get('assoc_to_district') !== null ? (int) $get('assoc_to_district') : null,
                                                $record?->assoc_to_group,
                                            ))
                                            ->searchable()
                                            ->placeholder('None'),
                                        TextInput::make('assoc_to_account')
                                            ->label('Account ID')
                                            ->numeric(),
                                        TextInput::make('packID')
                                            ->label('Pack ID')
                                            ->numeric(),
                                        TextInput::make('troopID')
                                            ->label('Troop ID')
                                            ->numeric(),
                                        TextInput::make('scoutPatrolID')
                                            ->label('Scout Patrol ID')
                                            ->numeric(),
                                        TextInput::make('scoutPatrolTaskID')
                                            ->label('Scout Patrol Task ID')
                                            ->numeric(),
                                        DateTimePicker::make('dateToCubs')
                                            ->label('Date To Cubs'),
                                        DateTimePicker::make('dateToScouts')
                                            ->label('Date To Scouts'),
                                        DateTimePicker::make('dateToRovers')
                                            ->label('Date To Rovers'),
                                    ]),

                                Section::make('Email Preferences')
                                    ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                                    ->schema([
                                        Toggle::make('logonEmail')
                                            ->label('Logon Email')
                                            ->inline(false),
                                        Toggle::make('weeklyProgramEmail')
                                            ->label('Weekly Program Email')
                                            ->inline(false),
                                        Toggle::make('profileChangesEmail')
                                            ->label('Profile Changes Email')
                                            ->inline(false),
                                        Toggle::make('newsletterEmail')
                                            ->label('Newsletter Email')
                                            ->inline(false),
                                        Toggle::make('lowerStaffProfileChanges')
                                            ->label('Lower Staff Profile Changes')
                                            ->inline(false),
                                        Toggle::make('weeklyEmailUnsubscribe')
                                            ->label('Weekly Email Unsubscribed')
                                            ->inline(false),
                                        DateTimePicker::make('weeklyEmailUnsubscribeDate')
                                            ->label('Weekly Unsubscribed At'),
                                        Textarea::make('weeklyEmailUnsubscribeText')
                                            ->label('Weekly Unsubscribe Reason')
                                            ->columnSpanFull(),
                                        Toggle::make('newsletterUnsubscribe')
                                            ->label('Newsletter Unsubscribed')
                                            ->inline(false),
                                        DateTimePicker::make('newsletterUnsubscribeDate')
                                            ->label('Newsletter Unsubscribed At'),
                                        Toggle::make('logonEmailSent')
                                            ->label('Logon Email Sent')
                                            ->inline(false),
                                        DateTimePicker::make('LogonEmailDate')
                                            ->label('Logon Email Sent At'),
                                    ]),

                                Section::make('Notes')
                                    ->schema([
                                        Textarea::make('generalNotes')
                                            ->label('')
                                            ->rows(5)
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Legacy / Deprecated')
                                    ->collapsible()
                                    ->collapsed()
                                    ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                                    ->schema([
                                        TextInput::make('amsRole')
                                            ->label('AMS Role')
                                            ->numeric(),
                                        Toggle::make('amsOnly')
                                            ->label('AMS Only')
                                            ->inline(false),
                                        Toggle::make('adultRecruit')
                                            ->label('Adult Recruit')
                                            ->inline(false),
                                        Toggle::make('sendAMSMail')
                                            ->label('Send AMS Mail')
                                            ->inline(false),
                                        TextInput::make('roverGroupID')
                                            ->label('Rover Group ID')
                                            ->numeric(),
                                        TextInput::make('roverGroupRoleID')
                                            ->label('Rover Group Role ID')
                                            ->numeric(),
                                        TextInput::make('roverGroupAccountID')
                                            ->label('Rover Group Account ID')
                                            ->numeric(),
                                        Toggle::make('canAdminElearning')
                                            ->label('Can Admin Elearning')
                                            ->inline(false),
                                        Toggle::make('canAdminElearningCourses')
                                            ->label('Can Admin Elearning Courses')
                                            ->inline(false),
                                        Toggle::make('canLogonTo20')
                                            ->label('Can Logon To SD 2.0')
                                            ->inline(false),
                                        Toggle::make('loggedInTo20')
                                            ->label('Logged In To SD 2.0')
                                            ->inline(false),
                                        TextInput::make('addedIn')
                                            ->label('Added In')
                                            ->numeric(),
                                        TextInput::make('ddValue')
                                            ->label('DD Value')
                                            ->numeric(),
                                        TextInput::make('reportView')
                                            ->label('Report View')
                                            ->numeric(),
                                        Toggle::make('takenSurvey')
                                            ->label('Taken Survey')
                                            ->inline(false),
                                        TextInput::make('24WSJ')
                                            ->label('24WSJ')
                                            ->numeric(),
                                        TextInput::make('24WSJRole')
                                            ->label('24WSJ Role')
                                            ->numeric(),
                                        TextInput::make('24wsjNotListedDistrict')
                                            ->label('24WSJ Not-listed District'),
                                        TextInput::make('24wsjNotListedGroup')
                                            ->label('24WSJ Not-listed Group'),
                                        TextInput::make('SANJamb2017')
                                            ->label('SANJamb2017')
                                            ->numeric(),
                                        TextInput::make('SANJamb2017Role')
                                            ->label('SANJamb2017 Role'),
                                        TextInput::make('sanJambNotListedRegion')
                                            ->label('SANJamb Not-listed Region'),
                                        TextInput::make('sanJambNotListedDistrict')
                                            ->label('SANJamb Not-listed District'),
                                        TextInput::make('sanJambNotListedGroup')
                                            ->label('SANJamb Not-listed Group'),
                                        TextInput::make('DSDHostelName')
                                            ->label('DSD Hostel Name'),
                                        TextInput::make('DSDTownshipName')
                                            ->label('DSD Township Name'),
                                        Toggle::make('DSDDisabled')
                                            ->label('DSD Disabled')
                                            ->inline(false),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    /**
     * Home-district options scoped to the selected home region. The user's currently stored district is
     * always included so an existing (possibly mismatched) value is never hidden or dropped on save.
     *
     * @return Collection<int, string>
     */
    public static function homeDistrictOptions(?int $regionId, ?int $currentDistrictId): Collection
    {
        $query = District::query()->orderBy('name');

        if ($regionId) {
            $query->where(function (Builder $scoped) use ($regionId, $currentDistrictId): void {
                $scoped->where('regionID', $regionId);

                if ($currentDistrictId) {
                    $scoped->orWhere('id', $currentDistrictId);
                }
            });
        }

        return $query->pluck('name', 'id');
    }

    /**
     * Home-group options scoped to the selected home district (active groups only). As with districts, the
     * user's currently stored group is always included so it is never hidden or dropped on save.
     *
     * @return Collection<int, string>
     */
    public static function homeGroupOptions(?int $districtId, ?int $currentGroupId): Collection
    {
        $query = Group::query()->orderBy('name');

        if ($districtId) {
            $query->where(function (Builder $scoped) use ($districtId, $currentGroupId): void {
                $scoped->where(fn (Builder $active) => $active->where('active', 1)->where('assoc_to_district', $districtId));

                if ($currentGroupId) {
                    $scoped->orWhere('id', $currentGroupId);
                }
            });

            return $query->pluck('name', 'id');
        }

        return $query->where('active', 1)->pluck('name', 'id');
    }
}

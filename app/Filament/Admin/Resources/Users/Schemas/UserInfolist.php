<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Enums\UserEnglishProficiency;
use App\Enums\UserRace;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Services\FileUrlService;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->persistTabInQueryString('tab')
                    ->tabs([

                        Tab::make('Profile')
                            ->icon(Heroicon::User)
                            ->schema([
                                Section::make('Account')
                                    ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                                    ->schema([
                                        TextEntry::make('ssaId')
                                            ->label('SSA ID')
                                            ->badge()
                                            ->color('primary'),
                                        TextEntry::make('username')
                                            ->label('Email / Username')
                                            ->placeholder('-'),
                                        IconEntry::make('active')
                                            ->boolean(),
                                        IconEntry::make('canLogon')
                                            ->label('Can Log On')
                                            ->boolean(),
                                        TextEntry::make('lastLoginDate')
                                            ->label('Last Login')
                                            ->dateTime()
                                            ->placeholder('-'),
                                        TextEntry::make('startDate')
                                            ->label('Start Date')
                                            ->date()
                                            ->placeholder('-'),
                                        TextEntry::make('lastPasswordChange')
                                            ->label('Last Password Change')
                                            ->dateTime()
                                            ->placeholder('-'),
                                        IconEntry::make('mustChangePassword')
                                            ->label('Must Change Password')
                                            ->boolean(),
                                    ]),

                                Section::make('Personal Information')
                                    ->collapsible()
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
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
                                        TextEntry::make('partnersFullName')
                                            ->label("Partner's Full Name")
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
                                        TextEntry::make('school')
                                            ->placeholder('-'),
                                        TextEntry::make('branch')
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Identity Documents')
                                    ->collapsible()
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextEntry::make('idNumber')
                                            ->label('ID Number')
                                            ->placeholder('-'),
                                        TextEntry::make('IDBookLocation')
                                            ->label('ID Book File')
                                            ->placeholder('-'),
                                        TextEntry::make('passportNumber')
                                            ->label('Passport Number')
                                            ->placeholder('-'),
                                        TextEntry::make('passportCountry')
                                            ->label('Passport Country')
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Contact Details')
                                    ->collapsible()
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextEntry::make('cellNr')
                                            ->label('Cell Number')
                                            ->placeholder('-'),
                                        TextEntry::make('officeNr')
                                            ->label('Office Number')
                                            ->placeholder('-'),
                                        TextEntry::make('homeNr')
                                            ->label('Home Number')
                                            ->placeholder('-'),
                                        TextEntry::make('faxNr')
                                            ->label('Fax Number')
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
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextEntry::make('occupation')
                                            ->placeholder('-'),
                                        TextEntry::make('typeOfEmployment')
                                            ->label('Employment Type')
                                            ->placeholder('-'),
                                        TextEntry::make('employer')
                                            ->placeholder('-'),
                                        TextEntry::make('maritalStatusInfo.name')
                                            ->label('Marital Status')
                                            ->placeholder('-'),
                                        TextEntry::make('highestEducationInfo.name')
                                            ->label('Highest Education')
                                            ->placeholder('-'),
                                        TextEntry::make('nrOfChildrenBoys')
                                            ->label('Children (Boys)')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('nrOfChildrenGirls')
                                            ->label('Children (Girls)')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('religiousBelief')
                                            ->label('Religious Belief')
                                            ->placeholder('-'),
                                        TextEntry::make('religion')
                                            ->placeholder('-'),
                                        TextEntry::make('religiousAffiliation')
                                            ->label('Religious Affiliation')
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
                                    ->columns(['sm' => 2, 'md' => 3])
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
                            ]),

                        Tab::make('Medical & Emergency')
                            ->icon(Heroicon::Heart)
                            ->schema([
                                Section::make('Medical Aid')
                                    ->collapsible()
                                    ->columns(['sm' => 2, 'md' => 3])
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
                                    ]),

                                Section::make('Health')
                                    ->collapsible()
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
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
                                    ->columns(['sm' => 2, 'md' => 3])
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

                        Tab::make('References')
                            ->icon(Heroicon::UserGroup)
                            ->schema([
                                Section::make('Reference 1')
                                    ->collapsible()
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextEntry::make('ref1Name')
                                            ->label('Name')
                                            ->placeholder('-'),
                                        TextEntry::make('ref1Tel')
                                            ->label('Phone')
                                            ->placeholder('-'),
                                        TextEntry::make('ref1Address')
                                            ->label('Address')
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Reference 2')
                                    ->collapsible()
                                    ->columns(['sm' => 2, 'md' => 3])
                                    ->schema([
                                        TextEntry::make('ref2Name')
                                            ->label('Name')
                                            ->placeholder('-'),
                                        TextEntry::make('ref2Tel')
                                            ->label('Phone')
                                            ->placeholder('-'),
                                        TextEntry::make('ref2Address')
                                            ->label('Address')
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Photo')
                            ->icon(Heroicon::Photo)
                            ->schema([
                                Section::make('Profile Photos')
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
                                    ]),
                            ]),

                        Tab::make('System')
                            ->icon(Heroicon::Cog6Tooth)
                            ->schema([
                                Section::make('Identifiers')
                                    ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                                    ->schema([
                                        TextEntry::make('ssaId')
                                            ->label('SSA ID')
                                            ->badge()
                                            ->color('primary'),
                                        TextEntry::make('SSANumber')
                                            ->label('SSA Number')
                                            ->placeholder('-'),
                                        TextEntry::make('oldID')
                                            ->label('Legacy ID')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('multiID')
                                            ->label('Multi ID')
                                            ->numeric()
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Associations')
                                    ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                                    ->schema([
                                        TextEntry::make('assoc_to_region')
                                            ->label('Region ID')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('assoc_to_district')
                                            ->label('District ID')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('assoc_to_group')
                                            ->label('Group ID')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('assoc_to_account')
                                            ->label('Account ID')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('packID')
                                            ->label('Pack ID')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('troopID')
                                            ->label('Troop ID')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('scoutPatrolID')
                                            ->label('Scout Patrol ID')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('scoutPatrolTaskID')
                                            ->label('Scout Patrol Task ID')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('dateToCubs')
                                            ->label('Date To Cubs')
                                            ->dateTime()
                                            ->placeholder('-'),
                                        TextEntry::make('dateToScouts')
                                            ->label('Date To Scouts')
                                            ->dateTime()
                                            ->placeholder('-'),
                                        TextEntry::make('dateToRovers')
                                            ->label('Date To Rovers')
                                            ->dateTime()
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Access & Flags')
                                    ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                                    ->schema([
                                        IconEntry::make('active')
                                            ->boolean(),
                                        IconEntry::make('canLogon')
                                            ->label('Can Log On')
                                            ->boolean(),
                                        IconEntry::make('mustChangePassword')
                                            ->label('Must Change Password')
                                            ->boolean(),
                                        IconEntry::make('canAdmin')
                                            ->label('Can Admin')
                                            ->boolean(),
                                        IconEntry::make('infoRedacted')
                                            ->label('Info Redacted')
                                            ->boolean(),
                                        IconEntry::make('orphaned')
                                            ->boolean(),
                                        IconEntry::make('vulnerable')
                                            ->boolean(),
                                        IconEntry::make('responsible_for_payment')
                                            ->label('Responsible For Payment')
                                            ->boolean(),
                                        IconEntry::make('form29Generated')
                                            ->label('Form 29 Generated')
                                            ->boolean(),
                                        IconEntry::make('docsDeleted')
                                            ->label('Docs Deleted')
                                            ->boolean(),
                                        TextEntry::make('user_type')
                                            ->label('User Type (Legacy)')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('parentType')
                                            ->label('Parent Type')
                                            ->numeric()
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Email Preferences')
                                    ->collapsible()
                                    ->collapsed()
                                    ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                                    ->schema([
                                        IconEntry::make('logonEmail')
                                            ->label('Logon Email')
                                            ->boolean(),
                                        IconEntry::make('weeklyProgramEmail')
                                            ->label('Weekly Program Email')
                                            ->boolean(),
                                        IconEntry::make('profileChangesEmail')
                                            ->label('Profile Changes Email')
                                            ->boolean(),
                                        IconEntry::make('newsletterEmail')
                                            ->label('Newsletter Email')
                                            ->boolean(),
                                        IconEntry::make('lowerStaffProfileChanges')
                                            ->label('Lower Staff Profile Changes')
                                            ->boolean(),
                                        IconEntry::make('weeklyEmailUnsubscribe')
                                            ->label('Weekly Email Unsubscribed')
                                            ->boolean(),
                                        TextEntry::make('weeklyEmailUnsubscribeDate')
                                            ->label('Weekly Email Unsubscribed At')
                                            ->dateTime()
                                            ->placeholder('-'),
                                        TextEntry::make('weeklyEmailUnsubscribeText')
                                            ->label('Unsubscribe Reason')
                                            ->placeholder('-'),
                                        IconEntry::make('newsletterUnsubscribe')
                                            ->label('Newsletter Unsubscribed')
                                            ->boolean(),
                                        TextEntry::make('newsletterUnsubscribeDate')
                                            ->label('Newsletter Unsubscribed At')
                                            ->dateTime()
                                            ->placeholder('-'),
                                        IconEntry::make('logonEmailSent')
                                            ->label('Logon Email Sent')
                                            ->boolean(),
                                        TextEntry::make('LogonEmailDate')
                                            ->label('Logon Email Sent At')
                                            ->dateTime()
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Notes')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        TextEntry::make('generalNotes')
                                            ->label('')
                                            ->placeholder('No notes')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Audit')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        Fieldset::make('Created')
                                            ->columns(2)
                                            ->schema([
                                                TextEntry::make('created')
                                                    ->label('At')
                                                    ->dateTime(),
                                                TextEntry::make('createdBy.name')
                                                    ->label('By'),
                                            ]),
                                        Fieldset::make('Modified')
                                            ->columns(2)
                                            ->schema([
                                                TextEntry::make('modified')
                                                    ->label('At')
                                                    ->dateTime()
                                                    ->placeholder('-'),
                                                TextEntry::make('modifiedBy.name')
                                                    ->label('By')
                                                    ->placeholder('-'),
                                            ]),
                                        Fieldset::make('Deactivated')
                                            ->columns(2)
                                            ->hidden(fn ($record) => ! $record->dateDeactivated)
                                            ->schema([
                                                TextEntry::make('dateDeactivated')
                                                    ->label('At')
                                                    ->dateTime(),
                                                TextEntry::make('deactivatedBy')
                                                    ->label('By')
                                                    ->numeric()
                                                    ->placeholder('-'),
                                            ]),
                                    ]),

                                Section::make('Legacy / Deprecated Data')
                                    ->collapsible()
                                    ->collapsed()
                                    ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                                    ->schema([
                                        TextEntry::make('amsRole')
                                            ->label('AMS Role')
                                            ->numeric()
                                            ->placeholder('-'),
                                        IconEntry::make('amsOnly')
                                            ->label('AMS Only')
                                            ->boolean(),
                                        IconEntry::make('adultRecruit')
                                            ->label('Adult Recruit')
                                            ->boolean(),
                                        IconEntry::make('sendAMSMail')
                                            ->label('Send AMS Mail')
                                            ->boolean(),
                                        TextEntry::make('roverGroupID')
                                            ->label('Rover Group ID')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('roverGroupRoleID')
                                            ->label('Rover Group Role ID')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('roverGroupAccountID')
                                            ->label('Rover Group Account ID')
                                            ->numeric()
                                            ->placeholder('-'),
                                        IconEntry::make('canAdminElearning')
                                            ->label('Can Admin Elearning')
                                            ->boolean(),
                                        IconEntry::make('canAdminElearningCourses')
                                            ->label('Can Admin Elearning Courses')
                                            ->boolean(),
                                        IconEntry::make('canLogonTo20')
                                            ->label('Can Logon To SD 2.0')
                                            ->boolean(),
                                        IconEntry::make('loggedInTo20')
                                            ->label('Logged In To SD 2.0')
                                            ->boolean(),
                                        TextEntry::make('addedIn')
                                            ->label('Added In')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('ddValue')
                                            ->label('DD Value (Per-page)')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('reportView')
                                            ->label('Report View')
                                            ->numeric()
                                            ->placeholder('-'),
                                        IconEntry::make('takenSurvey')
                                            ->label('Taken Survey')
                                            ->boolean(),

                                        Fieldset::make('World Scout Jamboree 2024')
                                            ->columnSpanFull()
                                            ->columns(['sm' => 2, 'md' => 4])
                                            ->schema([
                                                TextEntry::make('24WSJ')
                                                    ->label('24WSJ')
                                                    ->numeric()
                                                    ->placeholder('-'),
                                                TextEntry::make('24WSJRole')
                                                    ->label('24WSJ Role')
                                                    ->numeric()
                                                    ->placeholder('-'),
                                                TextEntry::make('24wsjNotListedDistrict')
                                                    ->label('Not-listed District')
                                                    ->placeholder('-'),
                                                TextEntry::make('24wsjNotListedGroup')
                                                    ->label('Not-listed Group')
                                                    ->placeholder('-'),
                                            ]),

                                        Fieldset::make('SA National Jamboree 2017')
                                            ->columnSpanFull()
                                            ->columns(['sm' => 2, 'md' => 4])
                                            ->schema([
                                                TextEntry::make('SANJamb2017')
                                                    ->label('SANJamb2017')
                                                    ->numeric()
                                                    ->placeholder('-'),
                                                TextEntry::make('SANJamb2017Role')
                                                    ->label('SANJamb2017 Role')
                                                    ->placeholder('-'),
                                                TextEntry::make('sanJambNotListedRegion')
                                                    ->label('Not-listed Region')
                                                    ->placeholder('-'),
                                                TextEntry::make('sanJambNotListedDistrict')
                                                    ->label('Not-listed District')
                                                    ->placeholder('-'),
                                                TextEntry::make('sanJambNotListedGroup')
                                                    ->label('Not-listed Group')
                                                    ->placeholder('-'),
                                            ]),

                                        Fieldset::make('DSD')
                                            ->columnSpanFull()
                                            ->columns(3)
                                            ->schema([
                                                TextEntry::make('DSDHostelName')
                                                    ->label('Hostel Name')
                                                    ->placeholder('-'),
                                                TextEntry::make('DSDTownshipName')
                                                    ->label('Township Name')
                                                    ->placeholder('-'),
                                                IconEntry::make('DSDDisabled')
                                                    ->label('DSD Disabled')
                                                    ->boolean(),
                                            ]),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}

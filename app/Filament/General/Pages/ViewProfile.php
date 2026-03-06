<?php

namespace App\Filament\General\Pages;

use App\Enums\UserRace;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

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
                    ->tabs([
                        Tab::make('Profile')
                            ->icon(Heroicon::User)
                            ->schema([
                                Section::make('Personal Information')
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
                                    ]),

                                Section::make('Identity Documents')
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
                                        TextEntry::make('hobbies')
                                            ->placeholder('-'),
                                        TextEntry::make('sports')
                                            ->placeholder('-'),
                                        TextEntry::make('interests')
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Medical')
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
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        Tab::make('Training')
                            ->icon(Heroicon::AcademicCap)
                            ->schema([
                                Section::make('Training History')
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
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        Tab::make('Awards')
                            ->icon(Heroicon::Trophy)
                            ->schema([
                                Section::make('Awards')
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
                                            ])
                                            ->columns(3),
                                    ]),

                                Section::make('Service History')
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
                ->url(fn () => EditProfile::getUrl()),
        ];
    }
}

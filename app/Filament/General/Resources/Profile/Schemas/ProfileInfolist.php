<?php

namespace App\Filament\General\Resources\Profile\Schemas;

use App\Enums\UserEnglishProficiency;
use App\Enums\UserRace;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Services\FileUrlService;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ProfileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make()
                    ->id('profile-tabs')
                    ->columnSpanFull()
                    ->persistTabInQueryString('tab')
                    ->tabs([
                        Tab::make('General')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                Flex::make([
                                    ImageEntry::make('photo')
                                        ->hiddenLabel()
                                        ->label('')
                                        ->getStateUsing(fn ($record) => $record->photo
                                            ? app(FileUrlService::class)->url($record->photo)
                                            : null)
                                        ->circular()
                                        ->height(160)
                                        ->grow(false)
                                        ->hidden(fn ($record) => ! $record->photo),
                                    Grid::make(2)
                                        ->schema([
                                            TextEntry::make('name')
                                                ->label('Name'),
                                            TextEntry::make('ssaId')
                                                ->label('SSA ID')
                                                ->badge()
                                                ->color('primary'),
                                            TextEntry::make('username')
                                                ->label('Email'),
                                            TextEntry::make('cellNr')
                                                ->label('Cell Number')
                                                ->placeholder('-'),
                                        ]),
                                ])->from('md'),
                            ]),

                        Tab::make('Personal')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make('Personal Information')
                                    ->collapsible()
                                    ->columns(3)
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
                                            ->label('Member Since')
                                            ->date()
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
                            ]),

                        Tab::make('Contact')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Section::make('Contact Details')
                                    ->collapsible()
                                    ->columns(2)
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
                            ]),

                        Tab::make('Address')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                Section::make('Address')
                                    ->collapsible()
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
                            ]),

                        Tab::make('Background')
                            ->icon('heroicon-o-briefcase')
                            ->schema([
                                Section::make('Employment')
                                    ->collapsible()
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('occupation')
                                            ->placeholder('-'),
                                        TextEntry::make('employer')
                                            ->placeholder('-'),
                                        TextEntry::make('typeOfEmployment')
                                            ->label('Employment Type')
                                            ->placeholder('-'),
                                    ]),
                                Section::make('Personal Details')
                                    ->collapsible()
                                    ->columns(3)
                                    ->schema([
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
                            ]),

                        Tab::make('Medical')
                            ->icon('heroicon-o-heart')
                            ->schema([
                                Section::make('Medical Aid')
                                    ->collapsible()
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
                                    ]),
                                Section::make('Doctor')
                                    ->collapsible()
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('doctorsName')
                                            ->label("Doctor's Name")
                                            ->placeholder('-'),
                                        TextEntry::make('doctorsPhone')
                                            ->label("Doctor's Phone")
                                            ->placeholder('-'),
                                    ]),
                                Section::make('Health Information')
                                    ->collapsible()
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('allergies')
                                            ->placeholder('-'),
                                        TextEntry::make('allergiesInstructions')
                                            ->label('Allergy Instructions')
                                            ->placeholder('-'),
                                        TextEntry::make('disabilities')
                                            ->placeholder('-'),
                                        TextEntry::make('disabilitiesInstructions')
                                            ->label('Disability Instructions')
                                            ->placeholder('-'),
                                        TextEntry::make('medicalConditions')
                                            ->label('Medical Conditions')
                                            ->placeholder('-'),
                                        TextEntry::make('medicalConditionsInstructions')
                                            ->label('Conditions Instructions')
                                            ->placeholder('-'),
                                        TextEntry::make('currentMedication')
                                            ->label('Current Medication')
                                            ->placeholder('-'),
                                        TextEntry::make('specialMealRequirements')
                                            ->label('Special Meal Requirements')
                                            ->placeholder('-'),
                                    ]),
                            ]),

                        Tab::make('Languages')
                            ->icon('heroicon-o-language')
                            ->schema([
                                Section::make('Languages')
                                    ->collapsible()
                                    ->columns(2)
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

                        Tab::make('Emergency Contact')
                            ->icon('heroicon-o-exclamation-triangle')
                            ->schema([
                                Section::make('Emergency Contact')
                                    ->collapsible()
                                    ->columns(2)
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
                    ]),
            ]);
    }
}

<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Groups\Schemas;

use App\Enums\ProgramTypes\ProgramCubsType;
use App\Enums\ProgramTypes\ProgramMeerkatsType;
use App\Enums\ProgramTypes\ProgramRoversType;
use App\Enums\ProgramTypes\ProgramScoutsType;
use App\Filament\Admin\Clusters\Area\Schemas\AreaFormComponents;
use App\Models\District;
use App\Models\GroupsType;
use App\Models\Region;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class GroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Details')
                            ->schema([
                                Section::make('General')
                                    ->columns(2)
                                    ->collapsible()
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('groupRegNr')
                                            ->label('Group Registration Number')
                                            ->maxLength(25)
                                            ->unique(ignoreRecord: true),
                                        TextInput::make('scarf')
                                            ->label('Scarf Colour'),
                                        Select::make('groupTypeID')
                                            ->label('Group Type')
                                            ->options(fn (): array => GroupsType::query()
                                                ->orderBy('name')
                                                ->get()
                                                ->mapWithKeys(fn (GroupsType $type): array => [$type->id => "{$type->name} (#{$type->id})"])
                                                ->all())
                                            ->required(),
                                        AreaFormComponents::accountSelect('groupAccountID', 'Group Account'),
                                        Toggle::make('active')
                                            ->default(true)
                                            ->inline(false),
                                        Toggle::make('managedRegionally')
                                            ->label('Managed Regionally')
                                            ->default(false)
                                            ->inline(false),
                                        Toggle::make('censusDone')
                                            ->label('Census Done')
                                            ->default(true)
                                            ->inline(false),
                                        Textarea::make('description')
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Location')
                                    ->columns(2)
                                    ->collapsible()
                                    ->schema([
                                        Select::make('assoc_to_region')
                                            ->label('Region')
                                            ->options(fn (): array => Region::query()
                                                ->orderBy('name')
                                                ->get()
                                                ->mapWithKeys(fn (Region $region): array => [$region->id => "{$region->name} (#{$region->id})"])
                                                ->all())
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(fn (Set $set) => $set('assoc_to_district', null)),
                                        Select::make('assoc_to_district')
                                            ->label('District')
                                            ->options(fn (Get $get, mixed $state): array => AreaFormComponents::keepingCurrent(
                                                District::query()
                                                    ->where('regionID', (int) $get('assoc_to_region'))
                                                    ->orderBy('name')
                                                    ->get()
                                                    ->mapWithKeys(fn (District $district): array => [$district->id => "{$district->name} (#{$district->id})"])
                                                    ->all(),
                                                $state,
                                                fn (int $id): string => AreaFormComponents::strayAreaLabel(District::query()->with('region')->find($id), 'district', $id),
                                            ))
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        AreaFormComponents::countrySelect('phys_country_id', 'Physical Country', required: false),
                                        AreaFormComponents::countrySelect('postalCountryID', 'Postal Country', required: false),
                                        Textarea::make('phys_address')
                                            ->label('Physical Address')
                                            ->columnSpanFull(),
                                        Textarea::make('postalAddress')
                                            ->label('Postal Address')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Sections')
                            ->schema([
                                Section::make('Active Sections')
                                    ->columns(4)
                                    ->collapsible()
                                    ->schema([
                                        Toggle::make('hasMeerkats')->label('Meerkats')->default(false)->inline(false),
                                        Toggle::make('hasCubs')->label('Cubs')->default(true)->inline(false),
                                        Toggle::make('hasScouts')->label('Scouts')->default(true)->inline(false),
                                        Toggle::make('hasRovers')->label('Rovers')->default(false)->inline(false),
                                    ]),
                                Section::make('Multi-Section')
                                    ->description('Allow multiple dens/packs/troops/crews per group')
                                    ->columns(4)
                                    ->collapsible()
                                    ->schema([
                                        Toggle::make('multiDen')->label('Multi Den')->default(false)->inline(false),
                                        Toggle::make('multiPack')->label('Multi Pack')->default(false)->inline(false),
                                        Toggle::make('multiTroop')->label('Multi Troop')->default(false)->inline(false),
                                        Toggle::make('multiCrew')->label('Multi Crew')->default(false)->inline(false),
                                    ]),
                                Section::make('Program Types')
                                    ->description('Legacy per group program selection. Newer data sets this per section.')
                                    ->columns(4)
                                    ->collapsible()
                                    ->schema([
                                        Select::make('meerkatProgramType')->label('Meerkats')->options(ProgramMeerkatsType::options())->default(1)->required(),
                                        Select::make('cubProgramType')->label('Cubs')->options(ProgramCubsType::options())->default(1)->required(),
                                        Select::make('scoutProgramType')->label('Scouts')->options(ProgramScoutsType::options())->default(2)->required(),
                                        Select::make('roverProgramType')->label('Rovers')->options(ProgramRoversType::options())->default(1)->required(),
                                    ]),
                                Section::make('Branches (legacy)')
                                    ->description('Legacy flags kept for completeness. Not used by Ssalute.')
                                    ->columns(4)
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        Toggle::make('hasBranch1')->label('Branch 1')->default(false)->inline(false),
                                        Toggle::make('hasBranch2')->label('Branch 2')->default(false)->inline(false),
                                        Toggle::make('hasBranch3')->label('Branch 3')->default(false)->inline(false),
                                        Toggle::make('hasBranch4')->label('Branch 4')->default(false)->inline(false),
                                        Toggle::make('hasBranch5')->label('Branch 5')->default(false)->inline(false),
                                        Toggle::make('amsOnly')->label('AMS Only')->default(false)->inline(false),
                                        Toggle::make('roverAssocToGroup')->label('Rovers Attached To Group')->default(false)->inline(false),
                                    ]),
                            ]),
                        Tab::make('Contact & Social')
                            ->schema([
                                Section::make('Contact')
                                    ->columns(2)
                                    ->collapsible()
                                    ->schema([
                                        TextInput::make('email')
                                            ->label('Email Address')
                                            ->email(),
                                        TextInput::make('website')
                                            ->url(),
                                    ]),
                                Section::make('Social Media')
                                    ->columns(2)
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        TextInput::make('facebook'),
                                        TextInput::make('twitter'),
                                        TextInput::make('instagram'),
                                        TextInput::make('linkedin'),
                                        TextInput::make('youtube'),
                                        TextInput::make('pintrest')->label('Pinterest'),
                                        TextInput::make('tumblr'),
                                        TextInput::make('googleplus')->label('Google+'),
                                    ]),
                                Section::make('GPS')
                                    ->columns(3)
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        TextInput::make('gpsLat')->label('Latitude'),
                                        TextInput::make('gpsLon')->label('Longitude'),
                                        TextInput::make('googleMaps')->label('Google Maps Link'),
                                    ]),
                                Section::make('Weather')
                                    ->columns(2)
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        TextInput::make('weatherID')->label('Weather Location ID')->maxLength(25),
                                        TextInput::make('weatherLocationName')->label('Weather Location Name'),
                                    ]),
                            ]),
                        Tab::make('Banking')
                            ->schema([
                                Section::make('Bank Account')
                                    ->columns(2)
                                    ->collapsible()
                                    ->schema([
                                        TextInput::make('bankAccountName')->label('Account Name'),
                                        TextInput::make('bankName')->label('Bank Name'),
                                        TextInput::make('branchName')->label('Branch Name'),
                                        TextInput::make('branchCode')->label('Branch Code'),
                                        TextInput::make('bankAccountNumber')->label('Account Number'),
                                        Textarea::make('bankingDetails')->label('Banking Details (free text)')->columnSpanFull(),
                                        Textarea::make('invoiceNotes')->label('Invoice Notes')->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('System')
                            ->schema([
                                Section::make('Features')
                                    ->columns(3)
                                    ->collapsible()
                                    ->schema([
                                        Toggle::make('sdLiteOnly')->label('SD Lite Only')->default(false)->inline(false),
                                        Toggle::make('usesShop')->label('Uses Shop')->default(false)->inline(false),
                                        Toggle::make('usesPayFees')->label('Uses Pay Fees')->default(false)->inline(false),
                                        Toggle::make('usesGoScan')->label('Uses GoScan')->default(false)->inline(false),
                                        Toggle::make('sendWeeklyMails')->label('Send Weekly Mails')->default(false)->inline(false),
                                        Toggle::make('canMoveToEntsha')->label('Can Move to Entsha')->default(true)->inline(false),
                                        Toggle::make('using20')->label('Using SD 2.0')->default(true)->inline(false),
                                    ]),
                                AreaFormComponents::auditSection(extraEntries: [
                                    TextEntry::make('groupLastUpdated')->label('Group Last Updated')->dateTime()->placeholder('-'),
                                    TextEntry::make('groupLastUpdatedBy')->label('Group Last Updated By')->placeholder('-'),
                                ]),
                            ]),
                    ]),
            ]);
    }
}

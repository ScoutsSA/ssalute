<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Groups\Schemas;

use App\Models\District;
use App\Models\GroupsType;
use App\Models\Region;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
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
                                    ->schema([
                                        TextInput::make('name')
                                            ->required(),
                                        TextInput::make('groupRegNr')
                                            ->label('Group Registration Number'),
                                        TextInput::make('scarf')
                                            ->label('Scarf Colour'),
                                        Select::make('groupTypeID')
                                            ->label('Group Type')
                                            ->options(fn () => GroupsType::query()->orderBy('name')->pluck('name', 'id'))
                                            ->required(),
                                        Toggle::make('active')
                                            ->default(true)
                                            ->inline(false),
                                        Toggle::make('managedRegionally')
                                            ->label('Managed Regionally')
                                            ->default(false)
                                            ->inline(false),
                                        Textarea::make('description')
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Location')
                                    ->columns(2)
                                    ->schema([
                                        Select::make('assoc_to_region')
                                            ->label('Region')
                                            ->options(fn () => Region::query()->orderBy('name')->pluck('name', 'id'))
                                            ->searchable()
                                            ->required(),
                                        Select::make('assoc_to_district')
                                            ->label('District')
                                            ->options(fn () => District::query()->orderBy('name')->pluck('name', 'id'))
                                            ->searchable()
                                            ->required(),
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
                                    ->schema([
                                        Toggle::make('hasMeerkats')->label('Meerkats')->default(false)->inline(false),
                                        Toggle::make('hasCubs')->label('Cubs')->default(true)->inline(false),
                                        Toggle::make('hasScouts')->label('Scouts')->default(true)->inline(false),
                                        Toggle::make('hasRovers')->label('Rovers')->default(false)->inline(false),
                                    ]),
                                Section::make('Multi-Section')
                                    ->description('Allow multiple dens/packs/troops/crews per group')
                                    ->columns(4)
                                    ->schema([
                                        Toggle::make('multiDen')->label('Multi Den')->default(false)->inline(false),
                                        Toggle::make('multiPack')->label('Multi Pack')->default(false)->inline(false),
                                        Toggle::make('multiTroop')->label('Multi Troop')->default(false)->inline(false),
                                        Toggle::make('multiCrew')->label('Multi Crew')->default(false)->inline(false),
                                    ]),
                            ]),
                        Tab::make('Contact & Social')
                            ->schema([
                                Section::make('Contact')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('email')
                                            ->label('Email Address')
                                            ->email(),
                                        TextInput::make('website')
                                            ->url(),
                                    ]),
                                Section::make('Social Media')
                                    ->columns(2)
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
                                    ->collapsed()
                                    ->schema([
                                        TextInput::make('gpsLat')->label('Latitude'),
                                        TextInput::make('gpsLon')->label('Longitude'),
                                        TextInput::make('googleMaps')->label('Google Maps Link'),
                                    ]),
                            ]),
                        Tab::make('Banking')
                            ->schema([
                                Section::make('Bank Account')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('bankAccountName')->label('Account Name'),
                                        TextInput::make('bankName')->label('Bank Name'),
                                        TextInput::make('branchName')->label('Branch Name'),
                                        TextInput::make('branchCode')->label('Branch Code'),
                                        TextInput::make('bankAccountNumber')->label('Account Number'),
                                        Textarea::make('invoiceNotes')->label('Invoice Notes')->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('System')
                            ->schema([
                                Section::make('Features')
                                    ->columns(3)
                                    ->schema([
                                        Toggle::make('sdLiteOnly')->label('SD Lite Only')->default(false)->inline(false),
                                        Toggle::make('usesShop')->label('Uses Shop')->default(false)->inline(false),
                                        Toggle::make('usesPayFees')->label('Uses Pay Fees')->default(false)->inline(false),
                                        Toggle::make('usesGoScan')->label('Uses GoScan')->default(false)->inline(false),
                                        Toggle::make('sendWeeklyMails')->label('Send Weekly Mails')->default(false)->inline(false),
                                        Toggle::make('canMoveToEntsha')->label('Can Move to Entsha')->default(true)->inline(false),
                                        Toggle::make('using20')->label('Using SD 2.0')->default(true)->inline(false),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}

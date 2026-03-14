<?php

namespace App\Filament\Admin\Clusters\GroupOperations\Resources\Programs\Schemas;

use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemProgramType;
use App\Models\SystemProgramTypesCub;
use App\Models\SystemProgramTypesMeerkat;
use App\Models\SystemProgramTypesRover;
use App\Models\SystemProgramTypesScout;
use App\Models\SystemUser;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ProgramForm
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
                                Section::make('Program Details')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->required()
                                            ->columnSpanFull(),
                                        Textarea::make('description')
                                            ->columnSpanFull(),
                                        TextInput::make('programAreaName')
                                            ->label('Program Area Name'),
                                        DatePicker::make('date')
                                            ->label('Date'),
                                        Select::make('responsibleScouter')
                                            ->label('Responsible Scouter')
                                            ->getSearchResultsUsing(fn (string $search) => SystemUser::query()->where('surname', 'like', "{$search}%")->orWhere('firstName', 'like', "{$search}%")->limit(50)->get()->pluck('name', 'id'))->getOptionLabelUsing(fn ($value) => SystemUser::find($value)?->name)
                                            ->searchable(),
                                        Select::make('programType')
                                            ->label('Program Type')
                                            ->options(fn () => SystemProgramType::query()->orderBy('name')->pluck('name', 'id'))
                                            ->required(),
                                        Toggle::make('active')->label('Active')->default(true)->inline(false),
                                    ]),
                            ]),
                        Tab::make('Location')
                            ->schema([
                                Section::make('Location')
                                    ->columns(3)
                                    ->schema([
                                        Select::make('assocToRegion')
                                            ->label('Region')
                                            ->options(fn () => Region::query()->orderBy('name')->pluck('name', 'id'))
                                            ->searchable(),
                                        Select::make('assocToDistrict')
                                            ->label('District')
                                            ->options(fn () => District::query()->orderBy('name')->pluck('name', 'id'))
                                            ->searchable(),
                                        Select::make('assocToGroup')
                                            ->label('Group')
                                            ->options(fn () => Group::query()->orderBy('name')->pluck('name', 'id'))
                                            ->searchable()
                                            ->required(),
                                    ]),
                            ]),
                        Tab::make('Section Targeting')
                            ->schema([
                                Section::make('Section Assignments')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('denID')->label('Den ID')->numeric(),
                                        TextInput::make('packID')->label('Pack ID')->numeric(),
                                        TextInput::make('troopID')->label('Troop ID')->numeric(),
                                        TextInput::make('crewID')->label('Crew ID')->numeric(),
                                        TextInput::make('multiID')->label('Multi Section ID')->numeric(),
                                        TextInput::make('dutyPatrol')->label('Duty Patrol ID')->numeric(),
                                    ]),
                                Section::make('Section Program Types')
                                    ->columns(2)
                                    ->schema([
                                        Select::make('meerkatProgramTypeID')
                                            ->label('Meerkat Program Type')
                                            ->options(fn () => SystemProgramTypesMeerkat::query()->orderBy('name')->pluck('name', 'id')),
                                        Select::make('cubProgramTypeID')
                                            ->label('Cub Program Type')
                                            ->options(fn () => SystemProgramTypesCub::query()->orderBy('name')->pluck('name', 'id')),
                                        Select::make('scoutProgramTypeID')
                                            ->label('Scout Program Type')
                                            ->options(fn () => SystemProgramTypesScout::query()->orderBy('name')->pluck('name', 'id')),
                                        Select::make('roverProgramTypeID')
                                            ->label('Rover Program Type')
                                            ->options(fn () => SystemProgramTypesRover::query()->orderBy('name')->pluck('name', 'id')),
                                    ]),
                            ]),
                        Tab::make('Online & Sharing')
                            ->schema([
                                Section::make('Online Program')
                                    ->columns(2)
                                    ->schema([
                                        Toggle::make('online')->label('Online Program')->default(false)->inline(false),
                                        Toggle::make('onlineActive')->label('Online Active')->default(false)->inline(false),
                                        DatePicker::make('onlineEndDate')->label('Online End Date'),
                                    ]),
                                Section::make('Sharing')
                                    ->columns(2)
                                    ->schema([
                                        Toggle::make('shared')->label('Shared')->default(false)->inline(false),
                                        TextInput::make('sharedby')->label('Shared By (User ID)')->numeric(),
                                        DatePicker::make('sharedDate')->label('Shared Date'),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}

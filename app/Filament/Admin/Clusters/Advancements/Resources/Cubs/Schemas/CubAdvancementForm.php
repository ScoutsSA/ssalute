<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Cubs\Schemas;

use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemAdvancementCubsChallenge;
use App\Models\SystemAdvancementCubsLevel;
use App\Models\SystemUser;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CubAdvancementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Advancement Details')
                    ->columns(2)
                    ->schema([
                        Select::make('cubID')
                            ->label('Cub')
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search) => SystemUser::query()
                                ->where('surname', 'like', "{$search}%")
                                ->orWhere('firstName', 'like', "{$search}%")
                                ->limit(50)
                                ->get()
                                ->pluck('name', 'id'))
                            ->getOptionLabelUsing(fn ($value) => SystemUser::find($value)?->name)
                            ->required(),
                        Select::make('userID')
                            ->label('Instructor')
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search) => SystemUser::query()
                                ->where('surname', 'like', "{$search}%")
                                ->orWhere('firstName', 'like', "{$search}%")
                                ->limit(50)
                                ->get()
                                ->pluck('name', 'id'))
                            ->getOptionLabelUsing(fn ($value) => SystemUser::find($value)?->name),
                        Select::make('advancementID')
                            ->label('Advancement Level')
                            ->options(fn () => SystemAdvancementCubsLevel::query()->orderBy('position')->pluck('name', 'id'))
                            ->searchable(),
                        Select::make('themeID')
                            ->label('Challenge Theme')
                            ->options(fn () => SystemAdvancementCubsChallenge::query()->orderBy('name')->pluck('name', 'id'))
                            ->searchable(),
                        DatePicker::make('advancementDate')
                            ->label('Advancement Date'),
                        TextInput::make('instructorsName')
                            ->label('Instructor Name'),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->columnSpanFull(),
                        Toggle::make('latest')
                            ->label('Latest')
                            ->inline(false),
                        Toggle::make('active')
                            ->label('Active')
                            ->default(true)
                            ->inline(false),
                    ]),
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
                            ->searchable(),
                    ]),
            ]);
    }
}

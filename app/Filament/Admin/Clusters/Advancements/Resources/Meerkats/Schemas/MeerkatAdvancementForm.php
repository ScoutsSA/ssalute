<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Meerkats\Schemas;

use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemAdvancementMeerkatsChallenge;
use App\Models\SystemAdvancementMeerkatsLevel;
use App\Models\SystemUser;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MeerkatAdvancementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Advancement Details')
                    ->columns(2)
                    ->schema([
                        Select::make('meerkatID')
                            ->label('Meerkat')
                            ->getSearchResultsUsing(fn (string $search) => SystemUser::query()->where('surname', 'like', "{$search}%")->orWhere('firstName', 'like', "{$search}%")->limit(50)->get()->pluck('name', 'id'))->getOptionLabelUsing(fn ($value) => SystemUser::find($value)?->name)
                            ->searchable()
                            ->required(),
                        Select::make('userID')
                            ->label('Instructor')
                            ->getSearchResultsUsing(fn (string $search) => SystemUser::query()->where('surname', 'like', "{$search}%")->orWhere('firstName', 'like', "{$search}%")->limit(50)->get()->pluck('name', 'id'))->getOptionLabelUsing(fn ($value) => SystemUser::find($value)?->name)
                            ->searchable(),
                        Select::make('advancementID')
                            ->label('Advancement Level')
                            ->options(fn () => SystemAdvancementMeerkatsLevel::query()->orderBy('position')->pluck('name', 'id'))
                            ->searchable(),
                        Select::make('themeID')
                            ->label('Challenge Theme')
                            ->options(fn () => SystemAdvancementMeerkatsChallenge::query()->orderBy('name')->pluck('name', 'id'))
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

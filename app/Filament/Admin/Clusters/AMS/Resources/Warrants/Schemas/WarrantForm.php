<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Warrants\Schemas;

use App\Models\AmsWarrantCancellationType;
use App\Models\AmsWarrantType;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use App\Models\SystemUserType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WarrantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Warrant Details')
                    ->columns(2)
                    ->schema([
                        Select::make('userID')
                            ->label('Member')
                            ->getSearchResultsUsing(fn (string $search) => SystemUser::query()->where('surname', 'like', "{$search}%")->orWhere('firstName', 'like', "{$search}%")->limit(50)->get()->pluck('name', 'id'))->getOptionLabelUsing(fn ($value) => SystemUser::find($value)?->name)
                            ->searchable()
                            ->required(),
                        Select::make('roleID')
                            ->label('Role')
                            ->options(fn () => SystemUserType::query()->orderBy('name')->pluck('name', 'id'))
                            ->searchable(),
                        Select::make('warrantTypeID')
                            ->label('Warrant Type')
                            ->options(fn () => AmsWarrantType::query()->orderBy('name')->pluck('name', 'id'))
                            ->searchable(),
                        TextInput::make('warrantNr')
                            ->label('Warrant Number'),
                        TextInput::make('warrantName')
                            ->label('Warrant Name'),
                        DatePicker::make('issueDate')
                            ->label('Issue Date'),
                        DatePicker::make('expireDate')
                            ->label('Expiry Date'),
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
                Section::make('Cancellation')
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        Select::make('cancellationTypeID')
                            ->label('Cancellation Type')
                            ->options(fn () => AmsWarrantCancellationType::query()->orderBy('name')->pluck('name', 'id')),
                        TextInput::make('cancelationNotes')
                            ->label('Cancellation Notes'),
                    ]),
            ]);
    }
}

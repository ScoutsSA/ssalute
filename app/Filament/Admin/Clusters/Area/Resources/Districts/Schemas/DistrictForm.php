<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Districts\Schemas;

use App\Filament\Admin\Clusters\Area\Schemas\AreaFormComponents;
use App\Models\DistrictsSuper;
use App\Models\Region;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Unique;

class DistrictForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('District Details')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        Select::make('regionID')
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
                            ->afterStateUpdated(fn (Set $set) => $set('superDistrictID', null)),
                        Select::make('superDistrictID')
                            ->label('Super District')
                            ->options(fn (Get $get, mixed $state): array => AreaFormComponents::keepingCurrent(
                                DistrictsSuper::query()
                                    ->where('regionID', (int) $get('regionID'))
                                    ->orderBy('name')
                                    ->get()
                                    ->mapWithKeys(fn (DistrictsSuper $superDistrict): array => [$superDistrict->id => "{$superDistrict->name} (#{$superDistrict->id})"])
                                    ->all(),
                                $state,
                                fn (int $id): string => AreaFormComponents::strayAreaLabel(DistrictsSuper::query()->with('region')->find($id), 'super district', $id),
                            ))
                            ->searchable()
                            ->nullable()
                            ->formatStateUsing(fn (mixed $state): ?int => $state ? (int) $state : null)
                            ->dehydrateStateUsing(fn (mixed $state): int => (int) ($state ?? 0)),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->unique(
                                ignoreRecord: true,
                                modifyRuleUsing: fn (Unique $rule, Get $get): Unique => $rule->where('regionID', (int) $get('regionID')),
                            ),
                        AreaFormComponents::countrySelect('countryID'),
                        AreaFormComponents::accountSelect('accountID'),
                        Toggle::make('active')
                            ->label('Active')
                            ->default(true)
                            ->inline(false),
                        Toggle::make('censusDone')
                            ->label('Census Done')
                            ->default(true)
                            ->inline(false),
                    ]),
                Section::make('Addresses')
                    ->collapsible()
                    ->schema([
                        Textarea::make('description')
                            ->columnSpanFull(),
                        Textarea::make('phys_address')
                            ->label('Physical Address')
                            ->columnSpanFull(),
                    ]),
                AreaFormComponents::auditSection(),
            ]);
    }
}

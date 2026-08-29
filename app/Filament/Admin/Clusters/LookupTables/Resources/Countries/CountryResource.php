<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\Countries;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\Countries\Pages\ManageCountries;
use App\Models\SystemCountryName;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class CountryResource extends Resource
{
    protected static ?string $model = SystemCountryName::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::GlobeAlt;

    protected static ?string $pluralLabel = 'Countries';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 140;

    protected static string|UnitEnum|null $navigationGroup = 'Countries & Cities';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('country_code')->label('Country Code')->required()->maxLength(3),
            TextInput::make('country_name')->label('Country Name')->required()->maxLength(50),
            TextInput::make('continent_name')->label('Continent'),
            TextInput::make('region_name')->label('Region'),
            TextInput::make('associationName')->label('Association Name'),
            Toggle::make('usingSD')->label('Using The System')->inline(false),
            Section::make('Branches')->collapsible()->collapsed()->columnSpanFull()->columns(4)->schema([
                TextInput::make('branch1Name')->label('Branch 1 Name'),
                TextInput::make('branch1ID')->label('Branch 1 ID')->numeric(),
                TextInput::make('branch1StartingAge')->label('Branch 1 Starting Age')->numeric()->step(0.1)->required()->default(5),
                TextInput::make('branch1EndingAge')->label('Branch 1 Ending Age')->numeric()->step(0.1)->required()->default(7),
                TextInput::make('branch2Name')->label('Branch 2 Name'),
                TextInput::make('branch2ID')->label('Branch 2 ID')->numeric(),
                TextInput::make('branch2StartingAge')->label('Branch 2 Starting Age')->numeric()->step(0.1)->required()->default(7),
                TextInput::make('branch2EndingAge')->label('Branch 2 Ending Age')->numeric()->step(0.1)->required()->default(11),
                TextInput::make('branch3Name')->label('Branch 3 Name'),
                TextInput::make('branch3ID')->label('Branch 3 ID')->numeric(),
                TextInput::make('branch3StartingAge')->label('Branch 3 Starting Age')->numeric()->step(0.1)->required()->default(11),
                TextInput::make('branch3EndingAge')->label('Branch 3 Ending Age')->numeric()->step(0.1)->required()->default(18),
                TextInput::make('branch4Name')->label('Branch 4 Name'),
                TextInput::make('branch4ID')->label('Branch 4 ID')->numeric(),
                TextInput::make('branch4StartingAge')->label('Branch 4 Starting Age')->numeric()->step(0.1)->required()->default(18),
                TextInput::make('branch4EndingAge')->label('Branch 4 Ending Age')->numeric()->step(0.1)->required()->default(25),
                TextInput::make('branch5Name')->label('Branch 5 Name'),
                TextInput::make('branch5ID')->label('Branch 5 ID')->numeric(),
                TextInput::make('branch5StartingAge')->label('Branch 5 Starting Age')->numeric()->step(0.1)->required()->default(25),
                TextInput::make('branch5EndingAge')->label('Branch 5 Ending Age')->numeric()->step(0.1)->required()->default(35),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: country configuration, including the branch names and age ranges per country. Read across census, role switching, AMS screens and reports.')
            ->columns([
                TextColumn::make('country_id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('country_name')->label('Name')->searchable()->sortable()->toggleable(),
                TextColumn::make('country_code')->label('Code')->searchable()->sortable()->toggleable(),
                IconColumn::make('usingSD')->label('Using The System')->boolean()->toggleable(),
                TextColumn::make('associationName')->label('Association')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('continent_name')->label('Continent')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('region_name')->label('Region')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('branch1Name')->label('Branch 1')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('branch2Name')->label('Branch 2')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('branch3Name')->label('Branch 3')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('branch4Name')->label('Branch 4')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('branch5Name')->label('Branch 5')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('country_name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCountries::route('/'),
        ];
    }
}

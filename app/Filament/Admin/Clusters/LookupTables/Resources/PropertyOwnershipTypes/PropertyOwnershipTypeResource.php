<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\PropertyOwnershipTypes;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\PropertyOwnershipTypes\Pages\ManagePropertyOwnershipTypes;
use App\Models\GroupsPropertyOwnershipType;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PropertyOwnershipTypeResource extends Resource
{
    protected static ?string $model = GroupsPropertyOwnershipType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingLibrary;

    protected static ?string $pluralLabel = 'Property Ownership Types';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 25;

    protected static string|UnitEnum|null $navigationGroup = 'Group Structure';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required(),
            Toggle::make('owned')->label('Counts As Owned')->inline(false),
            Toggle::make('rented')->label('Counts As Rented')->inline(false),
            Toggle::make('active')->label('Active')->default(true)->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: ownership types for group property records, the annual census property section and the property reports. The owned and rented flags feed the census property totals.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->label('Name')->searchable()->sortable()->toggleable(),
                IconColumn::make('owned')->label('Owned')->boolean()->toggleable(),
                IconColumn::make('rented')->label('Rented')->boolean()->toggleable(),
                IconColumn::make('active')->label('Active')->boolean()->toggleable(),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePropertyOwnershipTypes::route('/'),
        ];
    }
}

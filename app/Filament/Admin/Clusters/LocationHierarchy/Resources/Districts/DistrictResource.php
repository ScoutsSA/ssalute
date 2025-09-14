<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts;

use App\Filament\Admin\Clusters\LocationHierarchy\LocationHierarchyCluster;
use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\Pages\ListDistricts;
use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\Pages\ViewDistrict;
use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\RelationManagers\DistrictGroupsRelationManager;
use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\Schemas\DistrictForm;
use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\Schemas\DistrictInfolist;
use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\Tables\DistrictsTable;
use App\Models\District;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DistrictResource extends Resource
{
    protected static ?string $model = District::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Map;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $cluster = LocationHierarchyCluster::class;
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return DistrictForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DistrictInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DistrictsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DistrictGroupsRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDistricts::route('/'),
            'view' => ViewDistrict::route('/{record}'),
        ];
    }
}

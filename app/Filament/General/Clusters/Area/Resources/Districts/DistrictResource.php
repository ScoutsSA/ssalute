<?php

namespace App\Filament\General\Clusters\Area\Resources\Districts;

use App\Filament\General\Clusters\Area\AreaCluster;
use App\Filament\General\Clusters\Area\Resources\Districts\Pages\ListDistricts;
use App\Filament\General\Clusters\Area\Resources\Districts\Pages\ViewDistrict;
use App\Filament\General\Clusters\Area\Resources\Districts\Schemas\DistrictInfolist;
use App\Filament\General\Clusters\Area\Resources\Districts\Tables\DistrictsTable;
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

    protected static ?string $cluster = AreaCluster::class;

    protected static ?int $navigationSort = 2;

    protected static bool $isScopedToTenant = false;

    public static function infolist(Schema $schema): Schema
    {
        return DistrictInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DistrictsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDistricts::route('/'),
            'view' => ViewDistrict::route('/{record}'),
        ];
    }
}

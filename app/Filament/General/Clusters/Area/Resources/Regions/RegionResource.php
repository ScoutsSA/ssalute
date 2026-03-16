<?php

namespace App\Filament\General\Clusters\Area\Resources\Regions;

use App\Filament\General\Clusters\Area\AreaCluster;
use App\Filament\General\Clusters\Area\Resources\Regions\Pages\ListRegions;
use App\Filament\General\Clusters\Area\Resources\Regions\Pages\ViewRegion;
use App\Filament\General\Clusters\Area\Resources\Regions\Schemas\RegionInfolist;
use App\Filament\General\Clusters\Area\Resources\Regions\Tables\RegionsTable;
use App\Models\Region;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RegionResource extends Resource
{
    protected static ?string $model = Region::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::GlobeEuropeAfrica;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $cluster = AreaCluster::class;

    protected static ?int $navigationSort = 1;

    protected static bool $isScopedToTenant = false;

    public static function infolist(Schema $schema): Schema
    {
        return RegionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RegionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRegions::route('/'),
            'view' => ViewRegion::route('/{record}'),
        ];
    }
}

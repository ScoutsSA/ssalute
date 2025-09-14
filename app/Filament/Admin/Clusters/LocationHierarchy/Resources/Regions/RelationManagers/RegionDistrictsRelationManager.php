<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\RelationManagers;

use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\DistrictResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class RegionDistrictsRelationManager extends RelationManager
{
    protected static string $relationship = 'districts';

    protected static ?string $relatedResource = DistrictResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([]);
    }
}

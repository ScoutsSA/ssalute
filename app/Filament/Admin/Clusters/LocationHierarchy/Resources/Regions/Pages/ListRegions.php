<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\Pages;

use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\RegionResource;
use Filament\Resources\Pages\ListRecords;

class ListRegions extends ListRecords
{
    protected static string $resource = RegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}

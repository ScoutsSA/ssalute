<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Regions\Pages;

use App\Filament\Admin\Clusters\Area\Resources\Regions\RegionResource;
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

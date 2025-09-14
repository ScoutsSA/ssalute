<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\Pages;

use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\RegionResource;
use Filament\Resources\Pages\ViewRecord;

class ViewRegion extends ViewRecord
{
    protected static string $resource = RegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}

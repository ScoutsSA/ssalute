<?php

namespace App\Filament\Member\Clusters\Area\Resources\Regions\Pages;

use App\Filament\Member\Clusters\Area\Resources\Regions\RegionResource;
use Filament\Resources\Pages\ViewRecord;

class ViewRegion extends ViewRecord
{
    protected static string $resource = RegionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\Pages;

use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\DistrictResource;
use Filament\Resources\Pages\ViewRecord;

class ViewDistrict extends ViewRecord
{
    protected static string $resource = DistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

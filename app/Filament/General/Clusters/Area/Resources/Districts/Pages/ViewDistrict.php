<?php

namespace App\Filament\General\Clusters\Area\Resources\Districts\Pages;

use App\Filament\General\Clusters\Area\Resources\Districts\DistrictResource;
use Filament\Resources\Pages\ViewRecord;

class ViewDistrict extends ViewRecord
{
    protected static string $resource = DistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

<?php

namespace App\Filament\Member\Clusters\Area\Resources\Districts\Pages;

use App\Filament\Member\Clusters\Area\Resources\Districts\DistrictResource;
use Filament\Resources\Pages\ViewRecord;

class ViewDistrict extends ViewRecord
{
    protected static string $resource = DistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

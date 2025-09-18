<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Districts\Pages;

use App\Filament\Admin\Clusters\Area\Resources\Districts\DistrictResource;
use Filament\Resources\Pages\ViewRecord;

class ViewDistrict extends ViewRecord
{
    protected static string $resource = DistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

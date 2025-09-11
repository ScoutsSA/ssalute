<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\Pages;

use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\RegionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRegion extends CreateRecord
{
    protected static string $resource = RegionResource::class;
}

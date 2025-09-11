<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\Pages;

use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\DistrictResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDistricts extends ListRecords
{
    protected static string $resource = DistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

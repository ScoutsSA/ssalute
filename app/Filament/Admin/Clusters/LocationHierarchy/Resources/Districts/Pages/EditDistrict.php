<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\Pages;

use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\DistrictResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDistrict extends EditRecord
{
    protected static string $resource = DistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\Pages;

use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\RegionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRegion extends EditRecord
{
    protected static string $resource = RegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

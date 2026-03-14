<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Regions\Pages;

use App\Filament\Admin\Clusters\Area\Resources\Regions\RegionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRegion extends EditRecord
{
    protected static string $resource = RegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

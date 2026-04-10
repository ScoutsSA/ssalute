<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Licences\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\Licences\LicenceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLicences extends ListRecords
{
    protected static string $resource = LicenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

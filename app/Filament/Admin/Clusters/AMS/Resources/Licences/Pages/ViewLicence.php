<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Licences\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\Licences\LicenceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLicence extends ViewRecord
{
    protected static string $resource = LicenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

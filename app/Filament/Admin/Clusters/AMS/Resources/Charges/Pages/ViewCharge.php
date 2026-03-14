<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Charges\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\Charges\ChargeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCharge extends ViewRecord
{
    protected static string $resource = ChargeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Warrants\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\Warrants\WarrantResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWarrant extends ViewRecord
{
    protected static string $resource = WarrantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

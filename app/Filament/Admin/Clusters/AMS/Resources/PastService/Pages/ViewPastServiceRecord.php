<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\PastService\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\PastService\PastServiceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPastServiceRecord extends ViewRecord
{
    protected static string $resource = PastServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

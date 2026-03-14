<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Awards\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\Awards\AwardResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAward extends ViewRecord
{
    protected static string $resource = AwardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

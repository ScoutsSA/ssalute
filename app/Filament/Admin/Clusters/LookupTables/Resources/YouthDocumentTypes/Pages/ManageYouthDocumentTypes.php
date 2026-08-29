<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\YouthDocumentTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\YouthDocumentTypes\YouthDocumentTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageYouthDocumentTypes extends ManageRecords
{
    protected static string $resource = YouthDocumentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

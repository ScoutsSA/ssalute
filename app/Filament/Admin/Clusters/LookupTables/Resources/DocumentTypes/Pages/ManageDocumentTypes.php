<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\DocumentTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\DocumentTypes\DocumentTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageDocumentTypes extends ManageRecords
{
    protected static string $resource = DocumentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

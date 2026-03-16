<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\DocumentGroupTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\DocumentGroupTypes\DocumentGroupTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageDocumentGroupTypes extends ManageRecords
{
    protected static string $resource = DocumentGroupTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

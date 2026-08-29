<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\PropertyOwnershipTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\PropertyOwnershipTypes\PropertyOwnershipTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePropertyOwnershipTypes extends ManageRecords
{
    protected static string $resource = PropertyOwnershipTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

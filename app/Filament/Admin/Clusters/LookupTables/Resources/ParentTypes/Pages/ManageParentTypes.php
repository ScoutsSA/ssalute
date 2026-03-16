<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ParentTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\ParentTypes\ParentTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageParentTypes extends ManageRecords
{
    protected static string $resource = ParentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\GroupTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\GroupTypes\GroupTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageGroupTypes extends ManageRecords
{
    protected static string $resource = GroupTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

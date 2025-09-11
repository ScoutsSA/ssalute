<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\Pages;

use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\GroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGroups extends ListRecords
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

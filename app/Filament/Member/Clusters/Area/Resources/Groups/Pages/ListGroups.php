<?php

namespace App\Filament\Member\Clusters\Area\Resources\Groups\Pages;

use App\Filament\Member\Clusters\Area\Resources\Groups\GroupResource;
use Filament\Resources\Pages\ListRecords;

class ListGroups extends ListRecords
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

<?php

namespace App\Filament\General\Clusters\Area\Resources\Groups\Pages;

use App\Filament\General\Clusters\Area\Resources\Groups\GroupResource;
use Filament\Resources\Pages\ViewRecord;

class ViewGroup extends ViewRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

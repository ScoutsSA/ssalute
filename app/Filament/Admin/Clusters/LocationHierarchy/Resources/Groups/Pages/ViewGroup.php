<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\Pages;

use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\GroupResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGroup extends ViewRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

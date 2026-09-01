<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Rovers\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Rovers\RoverBadgeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRoverBadge extends ViewRecord
{
    protected static string $resource = RoverBadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

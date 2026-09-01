<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Meerkats\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Meerkats\MeerkatBadgeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMeerkatBadge extends ViewRecord
{
    protected static string $resource = MeerkatBadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

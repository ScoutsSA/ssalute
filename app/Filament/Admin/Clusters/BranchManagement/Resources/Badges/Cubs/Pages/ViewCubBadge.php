<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Cubs\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Cubs\CubBadgeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCubBadge extends ViewRecord
{
    protected static string $resource = CubBadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

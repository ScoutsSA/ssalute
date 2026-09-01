<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Scouts\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Scouts\ScoutBadgeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewScoutBadge extends ViewRecord
{
    protected static string $resource = ScoutBadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

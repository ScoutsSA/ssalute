<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Scouts\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Scouts\ScoutBadgeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListScoutBadges extends ListRecords
{
    protected static string $resource = ScoutBadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

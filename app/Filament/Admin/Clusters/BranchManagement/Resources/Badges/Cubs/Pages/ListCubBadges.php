<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Cubs\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Cubs\CubBadgeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCubBadges extends ListRecords
{
    protected static string $resource = CubBadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

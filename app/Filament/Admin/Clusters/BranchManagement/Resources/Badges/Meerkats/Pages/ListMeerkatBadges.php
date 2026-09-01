<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Meerkats\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Meerkats\MeerkatBadgeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMeerkatBadges extends ListRecords
{
    protected static string $resource = MeerkatBadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

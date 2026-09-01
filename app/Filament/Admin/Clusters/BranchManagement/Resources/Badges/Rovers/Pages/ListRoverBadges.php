<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Rovers\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Rovers\RoverBadgeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRoverBadges extends ListRecords
{
    protected static string $resource = RoverBadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

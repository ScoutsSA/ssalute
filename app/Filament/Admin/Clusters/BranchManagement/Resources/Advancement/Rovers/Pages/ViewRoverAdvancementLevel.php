<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Rovers\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Rovers\RoverAdvancementLevelResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRoverAdvancementLevel extends ViewRecord
{
    protected static string $resource = RoverAdvancementLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

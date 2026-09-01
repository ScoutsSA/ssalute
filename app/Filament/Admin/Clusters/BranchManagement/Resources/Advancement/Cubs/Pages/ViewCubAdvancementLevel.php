<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Cubs\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Cubs\CubAdvancementLevelResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCubAdvancementLevel extends ViewRecord
{
    protected static string $resource = CubAdvancementLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

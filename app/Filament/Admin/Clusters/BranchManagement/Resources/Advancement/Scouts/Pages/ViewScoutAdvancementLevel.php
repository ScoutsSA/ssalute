<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Scouts\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Scouts\ScoutAdvancementLevelResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewScoutAdvancementLevel extends ViewRecord
{
    protected static string $resource = ScoutAdvancementLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

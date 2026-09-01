<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Meerkats\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Meerkats\MeerkatAdvancementLevelResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMeerkatAdvancementLevel extends ViewRecord
{
    protected static string $resource = MeerkatAdvancementLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

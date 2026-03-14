<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Scouts\Pages;

use App\Filament\Admin\Clusters\Advancements\Resources\Scouts\ScoutAdvancementResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewScoutAdvancement extends ViewRecord
{
    protected static string $resource = ScoutAdvancementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Cubs\Pages;

use App\Filament\Admin\Clusters\Advancements\Resources\Cubs\CubAdvancementResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCubAdvancement extends ViewRecord
{
    protected static string $resource = CubAdvancementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Meerkats\Pages;

use App\Filament\Admin\Clusters\Advancements\Resources\Meerkats\MeerkatAdvancementResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMeerkatAdvancement extends ViewRecord
{
    protected static string $resource = MeerkatAdvancementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

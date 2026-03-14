<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Rovers\Pages;

use App\Filament\Admin\Clusters\Advancements\Resources\Rovers\RoverAdvancementResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRoverAdvancement extends ViewRecord
{
    protected static string $resource = RoverAdvancementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

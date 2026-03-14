<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Rovers\Pages;

use App\Filament\Admin\Clusters\Advancements\Resources\Rovers\RoverAdvancementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRoverAdvancements extends ListRecords
{
    protected static string $resource = RoverAdvancementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

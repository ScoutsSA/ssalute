<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Cubs\Pages;

use App\Filament\Admin\Clusters\Advancements\Resources\Cubs\CubAdvancementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCubAdvancements extends ListRecords
{
    protected static string $resource = CubAdvancementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

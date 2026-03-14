<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Scouts\Pages;

use App\Filament\Admin\Clusters\Advancements\Resources\Scouts\ScoutAdvancementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListScoutAdvancements extends ListRecords
{
    protected static string $resource = ScoutAdvancementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

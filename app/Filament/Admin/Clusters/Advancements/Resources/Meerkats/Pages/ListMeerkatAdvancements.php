<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Meerkats\Pages;

use App\Filament\Admin\Clusters\Advancements\Resources\Meerkats\MeerkatAdvancementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMeerkatAdvancements extends ListRecords
{
    protected static string $resource = MeerkatAdvancementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

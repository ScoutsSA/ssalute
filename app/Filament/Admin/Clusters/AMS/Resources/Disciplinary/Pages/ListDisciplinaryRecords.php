<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\DisciplinaryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDisciplinaryRecords extends ListRecords
{
    protected static string $resource = DisciplinaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

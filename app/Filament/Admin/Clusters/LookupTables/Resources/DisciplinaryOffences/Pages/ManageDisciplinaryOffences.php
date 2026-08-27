<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\DisciplinaryOffences\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\DisciplinaryOffences\DisciplinaryOffenceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageDisciplinaryOffences extends ManageRecords
{
    protected static string $resource = DisciplinaryOffenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

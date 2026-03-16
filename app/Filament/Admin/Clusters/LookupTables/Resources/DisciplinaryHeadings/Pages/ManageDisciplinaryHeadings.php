<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\DisciplinaryHeadings\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\DisciplinaryHeadings\DisciplinaryHeadingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageDisciplinaryHeadings extends ManageRecords
{
    protected static string $resource = DisciplinaryHeadingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

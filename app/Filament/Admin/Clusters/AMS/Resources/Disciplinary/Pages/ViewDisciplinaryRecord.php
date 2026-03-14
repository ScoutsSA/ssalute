<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\DisciplinaryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDisciplinaryRecord extends ViewRecord
{
    protected static string $resource = DisciplinaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

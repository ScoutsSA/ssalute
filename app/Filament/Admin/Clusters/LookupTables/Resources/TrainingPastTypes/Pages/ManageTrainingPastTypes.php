<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\TrainingPastTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\TrainingPastTypes\TrainingPastTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTrainingPastTypes extends ManageRecords
{
    protected static string $resource = TrainingPastTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

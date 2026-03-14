<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Training\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\Training\TrainingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTrainingRecord extends ViewRecord
{
    protected static string $resource = TrainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

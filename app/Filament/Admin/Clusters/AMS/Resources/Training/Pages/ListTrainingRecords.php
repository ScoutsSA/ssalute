<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Training\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\Training\TrainingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingRecords extends ListRecords
{
    protected static string $resource = TrainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

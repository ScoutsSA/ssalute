<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\TrainingCourseTypes\Pages;

use App\Filament\Admin\Clusters\Settings\Resources\TrainingCourseTypes\TrainingCourseTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTrainingCourseTypes extends ManageRecords
{
    protected static string $resource = TrainingCourseTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

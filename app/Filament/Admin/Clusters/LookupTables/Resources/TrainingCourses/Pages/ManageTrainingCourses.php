<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\TrainingCourses\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\TrainingCourses\TrainingCourseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTrainingCourses extends ManageRecords
{
    protected static string $resource = TrainingCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $data['created'] = now();
                    $data['createdby'] = auth()->id() ?? 1;

                    return $data;
                }),
        ];
    }
}

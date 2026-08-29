<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\TrainingLocations\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\TrainingLocations\TrainingLocationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTrainingLocations extends ManageRecords
{
    protected static string $resource = TrainingLocationResource::class;

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

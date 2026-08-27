<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\RoadmapItems\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\RoadmapItems\RoadmapItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRoadmapItems extends ManageRecords
{
    protected static string $resource = RoadmapItemResource::class;

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

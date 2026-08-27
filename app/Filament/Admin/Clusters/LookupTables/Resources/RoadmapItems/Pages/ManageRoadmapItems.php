<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\RoadmapItems\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\RoadmapItems\RoadmapItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Width;

class ManageRoadmapItems extends ManageRecords
{
    protected static string $resource = RoadmapItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth(Width::SevenExtraLarge)
                ->mutateDataUsing(function (array $data): array {
                    $data['created'] = now();
                    $data['createdby'] = auth()->id() ?? 1;

                    return $data;
                }),
        ];
    }
}

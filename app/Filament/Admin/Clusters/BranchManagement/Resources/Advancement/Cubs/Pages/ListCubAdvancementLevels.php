<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Cubs\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Cubs\CubAdvancementLevelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCubAdvancementLevels extends ListRecords
{
    protected static string $resource = CubAdvancementLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->mutateDataUsing(function (array $data): array {
                $data['position'] = ((int) static::getResource()::getModel()::query()->max('position')) + 1;

                return $data;
            }),
        ];
    }
}

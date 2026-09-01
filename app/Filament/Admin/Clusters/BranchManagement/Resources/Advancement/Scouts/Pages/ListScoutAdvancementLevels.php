<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Scouts\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Scouts\ScoutAdvancementLevelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListScoutAdvancementLevels extends ListRecords
{
    protected static string $resource = ScoutAdvancementLevelResource::class;

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

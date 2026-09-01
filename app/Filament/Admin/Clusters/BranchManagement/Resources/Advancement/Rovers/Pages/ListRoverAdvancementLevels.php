<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Rovers\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Rovers\RoverAdvancementLevelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRoverAdvancementLevels extends ListRecords
{
    protected static string $resource = RoverAdvancementLevelResource::class;

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

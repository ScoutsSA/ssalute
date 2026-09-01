<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Meerkats\Pages;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Meerkats\MeerkatAdvancementLevelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMeerkatAdvancementLevels extends ListRecords
{
    protected static string $resource = MeerkatAdvancementLevelResource::class;

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

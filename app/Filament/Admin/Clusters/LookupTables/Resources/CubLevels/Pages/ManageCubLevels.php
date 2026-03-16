<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\CubLevels\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\CubLevels\CubLevelResource;
use App\Models\SystemAdvancementCubsLevel;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCubLevels extends ManageRecords
{
    protected static string $resource = CubLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $maxPosition = SystemAdvancementCubsLevel::max('position') ?? 0;
                    $data['position'] = $maxPosition + 1;

                    return $data;
                }),
        ];
    }
}

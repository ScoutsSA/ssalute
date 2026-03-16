<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\RoverLevels\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\RoverLevels\RoverLevelResource;
use App\Models\SystemAdvancementRoversLevel;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRoverLevels extends ManageRecords
{
    protected static string $resource = RoverLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $maxPosition = SystemAdvancementRoversLevel::max('position') ?? 0;
                    $data['position'] = $maxPosition + 1;

                    return $data;
                }),
        ];
    }
}

<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\ScoutLevels\Pages;

use App\Filament\Admin\Clusters\Settings\Resources\ScoutLevels\ScoutLevelResource;
use App\Models\SystemAdvancementScoutsLevel;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageScoutLevels extends ManageRecords
{
    protected static string $resource = ScoutLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $maxPosition = SystemAdvancementScoutsLevel::max('position') ?? 0;
                    $data['position'] = $maxPosition + 1;

                    return $data;
                }),
        ];
    }
}

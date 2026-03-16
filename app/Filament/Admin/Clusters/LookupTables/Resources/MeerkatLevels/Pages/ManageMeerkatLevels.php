<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\MeerkatLevels\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\MeerkatLevels\MeerkatLevelResource;
use App\Models\SystemAdvancementMeerkatsLevel;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMeerkatLevels extends ManageRecords
{
    protected static string $resource = MeerkatLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $maxPosition = SystemAdvancementMeerkatsLevel::max('position') ?? 0;
                    $data['position'] = $maxPosition + 1;

                    return $data;
                }),
        ];
    }
}

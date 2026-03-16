<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\AwardTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\AwardTypes\AwardTypeResource;
use App\Models\AmsAwardType;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAwardTypes extends ManageRecords
{
    protected static string $resource = AwardTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $data['position'] = (AmsAwardType::max('position') ?? 0) + 1;
                    $data['created'] = now();
                    $data['createdby'] = auth()->id() ?? 1;

                    return $data;
                }),
        ];
    }
}

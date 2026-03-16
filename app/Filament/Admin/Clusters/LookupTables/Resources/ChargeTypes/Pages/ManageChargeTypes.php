<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ChargeTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\ChargeTypes\ChargeTypeResource;
use App\Models\AmsChargeType;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageChargeTypes extends ManageRecords
{
    protected static string $resource = ChargeTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $data['position'] = (AmsChargeType::max('position') ?? 0) + 1;
                    $data['created'] = now();
                    $data['createdby'] = auth()->id() ?? 1;

                    return $data;
                }),
        ];
    }
}

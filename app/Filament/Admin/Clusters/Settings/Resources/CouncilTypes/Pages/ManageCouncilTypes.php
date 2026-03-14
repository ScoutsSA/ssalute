<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\CouncilTypes\Pages;

use App\Filament\Admin\Clusters\Settings\Resources\CouncilTypes\CouncilTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCouncilTypes extends ManageRecords
{
    protected static string $resource = CouncilTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $data['created'] = now();
                    $data['createdby'] = auth()->id() ?? 1;

                    return $data;
                }),
        ];
    }
}

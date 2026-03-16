<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\WarrantTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\WarrantTypes\WarrantTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageWarrantTypes extends ManageRecords
{
    protected static string $resource = WarrantTypeResource::class;

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

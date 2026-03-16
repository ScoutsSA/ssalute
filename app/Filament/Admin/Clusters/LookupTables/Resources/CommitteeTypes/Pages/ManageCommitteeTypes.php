<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\CommitteeTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\CommitteeTypes\CommitteeTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCommitteeTypes extends ManageRecords
{
    protected static string $resource = CommitteeTypeResource::class;

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

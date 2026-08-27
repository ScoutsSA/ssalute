<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ScoutProgramTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\ScoutProgramTypes\ScoutProgramTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageScoutProgramTypes extends ManageRecords
{
    protected static string $resource = ScoutProgramTypeResource::class;

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

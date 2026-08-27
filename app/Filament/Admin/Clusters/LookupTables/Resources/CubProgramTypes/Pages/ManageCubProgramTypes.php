<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\CubProgramTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\CubProgramTypes\CubProgramTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCubProgramTypes extends ManageRecords
{
    protected static string $resource = CubProgramTypeResource::class;

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

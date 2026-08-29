<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\MeerkatProgramTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\MeerkatProgramTypes\MeerkatProgramTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMeerkatProgramTypes extends ManageRecords
{
    protected static string $resource = MeerkatProgramTypeResource::class;

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

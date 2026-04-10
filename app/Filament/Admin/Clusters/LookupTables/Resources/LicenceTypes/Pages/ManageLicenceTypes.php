<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\LicenceTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\LicenceTypes\LicenceTypeResource;
use App\Models\AmsLicenceType;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageLicenceTypes extends ManageRecords
{
    protected static string $resource = LicenceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $data['position'] = (AmsLicenceType::max('position') ?? 0) + 1;
                    $data['created'] = now();
                    $data['createdby'] = auth()->id() ?? 1;

                    return $data;
                }),
        ];
    }
}

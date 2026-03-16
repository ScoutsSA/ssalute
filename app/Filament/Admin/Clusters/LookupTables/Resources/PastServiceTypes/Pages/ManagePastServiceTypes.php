<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\PastServiceTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\PastServiceTypes\PastServiceTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePastServiceTypes extends ManageRecords
{
    protected static string $resource = PastServiceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

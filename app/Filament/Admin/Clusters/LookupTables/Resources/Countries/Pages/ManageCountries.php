<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\Countries\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\Countries\CountryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCountries extends ManageRecords
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

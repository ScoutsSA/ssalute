<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\MaritalStatuses\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\MaritalStatuses\MaritalStatusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMaritalStatuses extends ManageRecords
{
    protected static string $resource = MaritalStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

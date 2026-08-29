<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\InfoSharingTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\InfoSharingTypes\InfoSharingTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageInfoSharingTypes extends ManageRecords
{
    protected static string $resource = InfoSharingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

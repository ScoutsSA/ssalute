<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ProjectAudiences\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\ProjectAudiences\ProjectAudienceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageProjectAudiences extends ManageRecords
{
    protected static string $resource = ProjectAudienceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

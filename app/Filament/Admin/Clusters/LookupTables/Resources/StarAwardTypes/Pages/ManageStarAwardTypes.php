<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\StarAwardTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\StarAwardTypes\StarAwardTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageStarAwardTypes extends ManageRecords
{
    protected static string $resource = StarAwardTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

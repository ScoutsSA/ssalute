<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\AccountTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\AccountTypes\AccountTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAccountTypes extends ManageRecords
{
    protected static string $resource = AccountTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

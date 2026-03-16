<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\SuspendReasons\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\SuspendReasons\SuspendReasonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageSuspendReasons extends ManageRecords
{
    protected static string $resource = SuspendReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

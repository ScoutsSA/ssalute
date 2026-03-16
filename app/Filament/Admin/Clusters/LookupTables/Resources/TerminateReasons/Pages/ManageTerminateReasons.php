<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\TerminateReasons\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\TerminateReasons\TerminateReasonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTerminateReasons extends ManageRecords
{
    protected static string $resource = TerminateReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

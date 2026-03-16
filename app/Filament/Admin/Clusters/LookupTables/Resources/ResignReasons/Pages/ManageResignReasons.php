<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ResignReasons\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\ResignReasons\ResignReasonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageResignReasons extends ManageRecords
{
    protected static string $resource = ResignReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

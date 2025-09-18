<?php

namespace App\Filament\Admin\Resources\SystemUserTypes\Pages;

use App\Filament\Admin\Resources\SystemUserTypes\SystemUserTypeResource;
use Filament\Resources\Pages\ListRecords;

class ListSystemUserTypes extends ListRecords
{
    protected static string $resource = SystemUserTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}

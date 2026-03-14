<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Warrants\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\Warrants\WarrantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWarrants extends ListRecords
{
    protected static string $resource = WarrantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

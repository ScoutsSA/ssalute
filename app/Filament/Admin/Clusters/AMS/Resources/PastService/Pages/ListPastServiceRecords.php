<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\PastService\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\PastService\PastServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPastServiceRecords extends ListRecords
{
    protected static string $resource = PastServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

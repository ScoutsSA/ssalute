<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Awards\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\Awards\AwardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAwards extends ListRecords
{
    protected static string $resource = AwardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

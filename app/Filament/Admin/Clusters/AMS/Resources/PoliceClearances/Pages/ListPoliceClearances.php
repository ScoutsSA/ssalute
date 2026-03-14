<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\PoliceClearanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPoliceClearances extends ListRecords
{
    protected static string $resource = PoliceClearanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

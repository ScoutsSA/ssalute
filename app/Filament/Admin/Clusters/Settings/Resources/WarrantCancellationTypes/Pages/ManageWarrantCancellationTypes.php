<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\WarrantCancellationTypes\Pages;

use App\Filament\Admin\Clusters\Settings\Resources\WarrantCancellationTypes\WarrantCancellationTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageWarrantCancellationTypes extends ManageRecords
{
    protected static string $resource = WarrantCancellationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\RetireReasons\Pages;

use App\Filament\Admin\Clusters\Settings\Resources\RetireReasons\RetireReasonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRetireReasons extends ManageRecords
{
    protected static string $resource = RetireReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

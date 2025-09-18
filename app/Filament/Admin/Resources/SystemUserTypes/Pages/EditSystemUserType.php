<?php

namespace App\Filament\Admin\Resources\SystemUserTypes\Pages;

use App\Filament\Admin\Resources\SystemUserTypes\SystemUserTypeResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSystemUserType extends EditRecord
{
    protected static string $resource = SystemUserTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}

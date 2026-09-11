<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Groups\Pages;

use App\Filament\Admin\Clusters\Area\Actions\DeleteAreaAction;
use App\Filament\Admin\Clusters\Area\Resources\Groups\GroupResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAreaAction::make(),
        ];
    }
}

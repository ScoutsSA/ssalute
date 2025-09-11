<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\Pages;

use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\GroupResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\SupportChatTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\SupportChatTypes\SupportChatTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageSupportChatTypes extends ManageRecords
{
    protected static string $resource = SupportChatTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

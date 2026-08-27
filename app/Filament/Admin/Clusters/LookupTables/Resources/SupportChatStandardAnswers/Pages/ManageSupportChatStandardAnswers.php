<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\SupportChatStandardAnswers\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\SupportChatStandardAnswers\SupportChatStandardAnswerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageSupportChatStandardAnswers extends ManageRecords
{
    protected static string $resource = SupportChatStandardAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

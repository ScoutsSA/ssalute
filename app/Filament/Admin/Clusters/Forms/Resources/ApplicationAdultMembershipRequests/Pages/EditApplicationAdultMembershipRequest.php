<?php

namespace App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Pages;

use App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\ApplicationAdultMembershipRequestResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditApplicationAdultMembershipRequest extends EditRecord
{
    protected static string $resource = ApplicationAdultMembershipRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}

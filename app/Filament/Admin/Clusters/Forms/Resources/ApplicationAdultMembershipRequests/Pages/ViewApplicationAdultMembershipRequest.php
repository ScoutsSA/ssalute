<?php

namespace App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Pages;

use App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\ApplicationAdultMembershipRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewApplicationAdultMembershipRequest extends ViewRecord
{
    protected static string $resource = ApplicationAdultMembershipRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

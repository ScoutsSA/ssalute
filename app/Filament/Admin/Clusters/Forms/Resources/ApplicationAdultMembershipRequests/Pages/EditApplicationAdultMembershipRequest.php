<?php

namespace App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Pages;

use App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\ApplicationAdultMembershipRequestResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditApplicationAdultMembershipRequest extends EditRecord
{
    protected static string $resource = ApplicationAdultMembershipRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('ViewApprovalPage')
                ->label('Approval Page')
                ->button()
                ->url(fn ($record) => route('forms.aam.action', ['aamRequest' => $record->action_slug]), shouldOpenInNewTab: true),
            DeleteAction::make()
                ->modalDescription('WARNING - This will not fire off events and cannot be undone!'),
        ];
    }
}

<?php

namespace App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Pages;

use App\Enums\Forms\Aam\AamStatuses;
use App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\ApplicationAdultMembershipRequestResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListApplicationAdultMembershipRequests extends ListRecords
{
    protected static string $resource = ApplicationAdultMembershipRequestResource::class;

    public function getTabs(): array
    {
        return [
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', AamStatuses::PENDING->value)),
            'approved' => Tab::make('Approved')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', AamStatuses::APPROVED->value)),
            'declined' => Tab::make('Declined')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', AamStatuses::DECLINED->value)),
            'all' => Tab::make('All'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}

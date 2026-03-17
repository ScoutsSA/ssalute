<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getTabs(): array
    {
        return [
            'active' => Tab::make('Active Members')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', 1))
                ->icon('heroicon-o-check-circle'),
            'inactive' => Tab::make('Inactive Members')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', 0))
                ->icon('heroicon-o-x-circle'),
            'all' => Tab::make('All Members')
                ->icon('heroicon-o-users'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}

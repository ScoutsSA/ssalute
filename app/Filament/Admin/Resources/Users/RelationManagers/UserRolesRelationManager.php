<?php

namespace App\Filament\Admin\Resources\Users\RelationManagers;

use App\Filament\Admin\Resources\SystemUserTypes\SystemUserTypeResource;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserRolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    protected static ?string $relatedResource = SystemUserTypeResource::class;

    public function getTabs(): array
    {
        return [
            'active' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('system_users_other_roles.active', true)),
            'inactive' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('system_users_other_roles.active', false)),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordAction('view')      // clicking the row opens the View modal
            ->recordUrl(null)
            ->columns([
                TextColumn::make('roleTypePivotName')
                    ->label('Role Scope'),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('id')
                    ->label('Role ID')
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->headerActions([]);
    }
}

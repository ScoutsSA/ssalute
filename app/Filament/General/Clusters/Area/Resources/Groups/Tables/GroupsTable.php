<?php

namespace App\Filament\General\Clusters\Area\Resources\Groups\Tables;

use App\Models\Group;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated(['10', '20', '50'])
            ->columns([
                TextColumn::make('name')
                    ->description(fn (Group $record) => $record->region?->name . ' - ' . $record->district?->name)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('groupTypeLabel')
                    ->label('Group Type')
                    ->sortable(['groupTypeID'])
                    ->toggleable(),
                IconColumn::make('hasMeerkats')
                    ->label('Meerkats')
                    ->boolean()
                    ->toggleable()
                    ->sortable(),
                IconColumn::make('hasCubs')
                    ->label('Cubs')
                    ->boolean()
                    ->toggleable()
                    ->sortable(),
                IconColumn::make('hasScouts')
                    ->label('Scouts')
                    ->boolean()
                    ->toggleable()
                    ->sortable(),
                IconColumn::make('hasRovers')
                    ->label('Rovers')
                    ->boolean()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('website')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}

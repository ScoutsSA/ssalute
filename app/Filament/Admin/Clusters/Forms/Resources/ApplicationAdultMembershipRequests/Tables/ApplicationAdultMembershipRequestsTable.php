<?php

namespace App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApplicationAdultMembershipRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('locationName')
                    ->label('Region/District/Group')
                    ->toggleable(),
                TextColumn::make('status')
                    ->visible(fn (ListRecords $livewire) => $livewire->activeTab === 'all')
                    ->badge()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->sortable(['surname', 'first_name'])
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('actioned_at')
                    ->dateTime()
                    ->sortable()
                    ->visible(fn (ListRecords $livewire) => $livewire->activeTab !== 'pending')
                    ->toggleable(),
                TextColumn::make('actionedBy.name')
                    ->numeric()
                    ->sortable()
                    ->visible(fn (ListRecords $livewire) => $livewire->activeTab !== 'pending')
                    ->toggleable(),

                TextColumn::make('actioned_notes_internal')
                    ->label('Actioned notes (internal)')
                    ->visible(fn (ListRecords $livewire) => in_array($livewire->activeTab, ['all', 'declined']))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('actioned_notes_external')
                    ->label('Actioned notes (external)')
                    ->visible(fn (ListRecords $livewire) => in_array($livewire->activeTab, ['all', 'declined']))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}

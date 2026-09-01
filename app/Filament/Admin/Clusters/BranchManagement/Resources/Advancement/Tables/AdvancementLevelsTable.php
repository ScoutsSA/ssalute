<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Tables;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Tables\BadgesTable;
use App\Services\LegacyHtmlService;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AdvancementLevelsTable
{
    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $model
     * @param  array<int, \Filament\Tables\Columns\Column>  $extraColumns
     */
    public static function configure(Table $table, string $model, array $extraColumns = []): Table
    {
        return $table
            ->recordAction(ViewAction::class)
            ->defaultPaginationPageOption(25)
            ->reorderable('position')
            ->description('Database table: ' . app($model)->getTable() . '. Legacy usage: the advancement levels for this branch, referenced by every awarded advancement record and by the program and event sign-off screens.')
            ->defaultSort('position')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('position')->sortable()->toggleable(),
                TextColumn::make('name')
                    ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))
                    ->searchable()
                    ->sortable(),
                ...$extraColumns,
                IconColumn::make('highLevel')->label('High Level')->boolean()->sortable()->toggleable(),
                IconColumn::make('investment')->boolean()->sortable()->toggleable(),
                IconColumn::make('active')->boolean()->sortable()->toggleable(),
                TextColumn::make('description')
                    ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::preview($state))
                    ->limit(60)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('programType')->label('Program Type')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('active')->default(true),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                BadgesTable::deactivateAction()
                    ->modalDescription('The level is hidden from sign-off screens. Existing awarded records are not touched and the level can be reactivated at any time.'),
                BadgesTable::activateAction(),
            ]);
    }
}

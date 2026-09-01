<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Tables;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Schemas\BadgeForm;
use App\Services\LegacyHtmlService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BadgesTable
{
    /** @param class-string<\Illuminate\Database\Eloquent\Model> $model */
    public static function configure(Table $table, string $model): Table
    {
        return $table
            ->recordAction(ViewAction::class)
            ->defaultPaginationPageOption(25)
            ->description('Database table: ' . app($model)->getTable() . '. Legacy usage: the badge catalogue for this branch, browsed by leaders when awarding badges and referenced by every awarded badge record.')
            ->defaultGroup(Group::make('type')->collapsible())
            ->defaultSort('name')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')
                    ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('tasks_count')
                    ->label('Tasks')
                    ->counts('tasks')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('active')->boolean()->sortable()->toggleable(),
                TextColumn::make('note')
                    ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::preview($state))
                    ->limit(60)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('programType')->label('Program Type')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created')->dateTime('Y/m/d H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('modified')->dateTime('Y/m/d H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')->options(array_combine(BadgeForm::TYPES, BadgeForm::TYPES)),
                TernaryFilter::make('active')->default(true),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                self::deactivateAction(),
                self::activateAction(),
            ]);
    }

    public static function deactivateAction(): Action
    {
        return Action::make('deactivate')
            ->icon(Heroicon::NoSymbol)
            ->color('danger')
            ->requiresConfirmation()
            ->modalDescription('The badge is hidden from awarding screens. Existing awarded records are not touched and the badge can be reactivated at any time.')
            ->visible(fn (Model $record): bool => (int) $record->active === 1)
            ->action(fn (Model $record) => $record->update(['active' => 0]));
    }

    public static function activateAction(): Action
    {
        return Action::make('activate')
            ->icon(Heroicon::CheckCircle)
            ->color('success')
            ->requiresConfirmation()
            ->visible(fn (Model $record): bool => (int) $record->active !== 1)
            ->action(fn (Model $record) => $record->update(['active' => 1]));
    }
}

<?php

namespace App\Filament\General\Clusters\Area\Resources\Groups\Tables;

use App\Enums\GroupTypes;
use App\Models\Group;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class GroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated(['10', '20', '50', '100'])
            ->defaultPaginationPageOption('50')
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
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('website')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('region')
                    ->relationship('region', 'name', fn ($query) => $query->orderBy('position', 'asc'))
                    ->searchable(),
                SelectFilter::make('district')
                    ->relationship('district', 'name', fn ($query) => $query->orderBy('name', 'asc'))
                    ->searchable(),
                SelectFilter::make('groupTypeID')
                    ->label('Group Type')
                    ->options(GroupTypes::class),
                TernaryFilter::make('hasMeerkats')
                    ->label('Meerkats')
                    ->native(false)
                    ->placeholder('Either')
                    ->trueLabel('Yes')
                    ->falseLabel('No'),
                TernaryFilter::make('hasCubs')
                    ->label('Cubs')
                    ->native(false)
                    ->placeholder('Either')
                    ->trueLabel('Yes')
                    ->falseLabel('No'),
                TernaryFilter::make('hasScouts')
                    ->label('Scouts')
                    ->native(false)
                    ->placeholder('Either')
                    ->trueLabel('Yes')
                    ->falseLabel('No'),
                TernaryFilter::make('hasRovers')
                    ->label('Rovers')
                    ->native(false)
                    ->placeholder('Either')
                    ->trueLabel('Yes')
                    ->falseLabel('No'),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}

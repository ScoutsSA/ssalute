<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Meerkats\Tables;

use App\Filament\Admin\Clusters\Advancements\Resources\Meerkats\MeerkatAdvancementResource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MeerkatAdvancementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('meerkat.name')
                    ->label('Meerkat')
                    ->searchable(['first_name', 'surname'])
                    ->sortable(),
                TextColumn::make('advancement.name')
                    ->label('Level'),
                TextColumn::make('theme.name')
                    ->label('Challenge Theme'),
                TextColumn::make('advancementDate')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('instructorsName')
                    ->label('Instructor')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('latest')
                    ->label('Latest')
                    ->boolean(),
                IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('group.groupName')
                    ->label('Group')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('advancementDate', 'desc')
            ->recordUrl(fn ($record) => MeerkatAdvancementResource::getUrl('view', ['record' => $record]));
    }
}

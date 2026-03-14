<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\Tables;

use App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\PoliceClearanceResource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PoliceClearancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.name')
                    ->label('Member')
                    ->searchable(['first_name', 'surname']),
                TextColumn::make('result')
                    ->label('Result')
                    ->searchable(),
                TextColumn::make('dateDone')
                    ->label('Date Done')
                    ->date()
                    ->sortable(),
                IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->defaultSort('dateDone', 'desc')
            ->recordUrl(fn ($record) => PoliceClearanceResource::getUrl('view', ['record' => $record]));
    }
}

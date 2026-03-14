<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\PastService\Tables;

use App\Filament\Admin\Clusters\AMS\Resources\PastService\PastServiceResource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PastServiceTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.name')
                    ->label('Member')
                    ->searchable(['first_name', 'surname']),
                TextColumn::make('serviceType.name')
                    ->label('Service Type'),
                TextColumn::make('startDate')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('endDate')
                    ->label('End Date')
                    ->date()
                    ->sortable(),
                IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->defaultSort('startDate', 'desc')
            ->recordUrl(fn ($record) => PastServiceResource::getUrl('view', ['record' => $record]));
    }
}

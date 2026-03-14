<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Awards\Tables;

use App\Filament\Admin\Clusters\AMS\Resources\Awards\AwardResource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AwardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.name')
                    ->label('Member')
                    ->searchable(['first_name', 'surname']),
                TextColumn::make('awardType.name')
                    ->label('Award Type'),
                TextColumn::make('heading.reason')
                    ->label('Heading'),
                TextColumn::make('awardDate')
                    ->label('Award Date')
                    ->date()
                    ->sortable(),
                IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->defaultSort('awardDate', 'desc')
            ->recordUrl(fn ($record) => AwardResource::getUrl('view', ['record' => $record]));
    }
}

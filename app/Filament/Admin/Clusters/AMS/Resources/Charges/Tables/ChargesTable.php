<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Charges\Tables;

use App\Filament\Admin\Clusters\AMS\Resources\Charges\ChargeResource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ChargesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.name')
                    ->label('Member')
                    ->searchable(['first_name', 'surname']),
                TextColumn::make('chargeType.name')
                    ->label('Charge Type'),
                TextColumn::make('chargeNr')
                    ->label('Charge Nr')
                    ->searchable(),
                TextColumn::make('issueDate')
                    ->label('Issued')
                    ->date()
                    ->sortable(),
                TextColumn::make('expireDate')
                    ->label('Expires')
                    ->date()
                    ->sortable(),
                IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->defaultSort('issueDate', 'desc')
            ->recordUrl(fn ($record) => ChargeResource::getUrl('view', ['record' => $record]));
    }
}

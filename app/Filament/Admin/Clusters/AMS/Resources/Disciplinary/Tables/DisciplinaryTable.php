<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\Tables;

use App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\DisciplinaryResource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DisciplinaryTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.name')
                    ->label('Member')
                    ->searchable(['first_name', 'surname']),
                TextColumn::make('heading.reason')
                    ->label('Heading'),
                TextColumn::make('sanction')
                    ->label('Sanction')
                    ->searchable(),
                TextColumn::make('expireDate')
                    ->label('Expires')
                    ->date()
                    ->sortable(),
                IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->defaultSort('created', 'desc')
            ->recordUrl(fn ($record) => DisciplinaryResource::getUrl('view', ['record' => $record]));
    }
}

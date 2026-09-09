<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Warrants\Tables;

use App\Filament\Admin\Clusters\AMS\Resources\Warrants\WarrantResource;
use App\Models\AmsWarrantInfo;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WarrantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('warrantNr')
                    ->label('Warrant Nr')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('warrantName')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Member')
                    ->searchable(['first_name', 'surname']),
                TextColumn::make('warrantType.name')
                    ->label('Type'),
                TextColumn::make('role.name')
                    ->label('Role')
                    ->state(fn (AmsWarrantInfo $record): ?string => $record->role ? "{$record->role->name} (#{$record->roleID})" : null)
                    ->placeholder('-'),
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
                TextColumn::make('group.groupName')
                    ->label('Group')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('region.name')
                    ->label('Region')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('issueDate', 'desc')
            ->recordUrl(fn ($record) => WarrantResource::getUrl('view', ['record' => $record]));
    }
}

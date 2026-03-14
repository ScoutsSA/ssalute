<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Training\Tables;

use App\Filament\Admin\Clusters\AMS\Resources\Training\TrainingResource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.name')
                    ->label('Member')
                    ->searchable(['first_name', 'surname']),
                TextColumn::make('trainingType.typeName')
                    ->label('Training Type'),
                TextColumn::make('courseName')
                    ->label('Course Name')
                    ->searchable(),
                TextColumn::make('courseNumber')
                    ->label('Course Number')
                    ->searchable(),
                TextColumn::make('completionDate')
                    ->label('Completion Date')
                    ->date()
                    ->sortable(),
                IconColumn::make('validated')
                    ->label('Validated')
                    ->boolean(),
                IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->defaultSort('completionDate', 'desc')
            ->recordUrl(fn ($record) => TrainingResource::getUrl('view', ['record' => $record]));
    }
}

<?php

namespace App\Filament\Admin\Resources\Users\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserPastServiceRelationManager extends RelationManager
{
    protected static string $relationship = 'pastService';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('pastServiceType')
                    ->label('Service Type')
                    ->relationship('serviceType', 'typeName'),
                DatePicker::make('startDate')
                    ->label('Start Date'),
                DatePicker::make('endDate')
                    ->label('End Date'),
                TextInput::make('otherRegionName')
                    ->label('Other Region')
                    ->maxLength(255),
                TextInput::make('otherDistrictName')
                    ->label('Other District')
                    ->maxLength(255),
                TextInput::make('otherGroupName')
                    ->label('Other Group')
                    ->maxLength(255),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('serviceType.typeName')
                    ->label('Service Type'),
                TextEntry::make('startDate')
                    ->label('Start Date')
                    ->date(),
                TextEntry::make('endDate')
                    ->label('End Date')
                    ->date(),
                TextEntry::make('otherRegionName')
                    ->label('Other Region'),
                TextEntry::make('otherDistrictName')
                    ->label('Other District'),
                TextEntry::make('otherGroupName')
                    ->label('Other Group'),
            ]);
    }

    public function getTabs(): array
    {
        return [
            'active' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', 1)),
            'inactive' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', 0)),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('serviceType.typeName')
                    ->label('Service Type')
                    ->searchable(),
                TextColumn::make('startDate')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('endDate')
                    ->label('End Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('otherRegionName')
                    ->label('Other Region')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('otherDistrictName')
                    ->label('Other District')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('otherGroupName')
                    ->label('Other Group')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

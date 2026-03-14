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

class UserWarrantsRelationManager extends RelationManager
{
    protected static string $relationship = 'warrants';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('warrantNr')
                    ->label('Warrant Number')
                    ->maxLength(255),
                TextInput::make('warrantName')
                    ->label('Warrant Name')
                    ->required()
                    ->maxLength(255),
                Select::make('warrantTypeID')
                    ->label('Warrant Type')
                    ->relationship('warrantType', 'typeName'),
                DatePicker::make('issueDate')
                    ->label('Issue Date'),
                DatePicker::make('expireDate')
                    ->label('Expiry Date'),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('warrantNr')
                    ->label('Warrant Number'),
                TextEntry::make('warrantName')
                    ->label('Warrant Name'),
                TextEntry::make('warrantType.typeName')
                    ->label('Warrant Type'),
                TextEntry::make('issueDate')
                    ->label('Issue Date')
                    ->date(),
                TextEntry::make('expireDate')
                    ->label('Expiry Date')
                    ->date(),
                TextEntry::make('cancellationType.type')
                    ->label('Cancellation Type'),
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
            ->recordTitleAttribute('warrantName')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('warrantNr')
                    ->label('Warrant #')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('warrantName')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('warrantType.typeName')
                    ->label('Type')
                    ->toggleable(),
                TextColumn::make('issueDate')
                    ->label('Issued')
                    ->date()
                    ->sortable(),
                TextColumn::make('expireDate')
                    ->label('Expires')
                    ->date()
                    ->sortable(),
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

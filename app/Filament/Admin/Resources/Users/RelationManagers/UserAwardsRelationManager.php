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
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserAwardsRelationManager extends RelationManager
{
    protected static string $relationship = 'awards';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('awardTypeID')
                    ->label('Award Type')
                    ->relationship('awardType', 'typeName')
                    ->required(),
                Select::make('awardHeadingID')
                    ->label('Award Heading')
                    ->relationship('heading', 'heading'),
                DatePicker::make('awardDate')
                    ->label('Award Date'),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('awardType.typeName')
                    ->label('Award Type'),
                TextEntry::make('heading.heading')
                    ->label('Heading'),
                TextEntry::make('awardDate')
                    ->label('Award Date')
                    ->date(),
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
                TextColumn::make('awardType.typeName')
                    ->label('Award')
                    ->searchable(),
                TextColumn::make('heading.heading')
                    ->label('Heading')
                    ->toggleable(),
                TextColumn::make('awardDate')
                    ->label('Date')
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

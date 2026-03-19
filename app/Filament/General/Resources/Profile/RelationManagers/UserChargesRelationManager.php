<?php

namespace App\Filament\General\Resources\Profile\RelationManagers;

use App\Services\FileUrlService;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserChargesRelationManager extends RelationManager
{
    protected static string $relationship = 'chargeInfos';

    protected static ?string $title = 'Charges';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Charge Details')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('chargeType.name')
                            ->label('Charge Type')
                            ->placeholder('-'),
                        TextEntry::make('chargeNr')
                            ->label('Charge Number')
                            ->badge()
                            ->color('primary')
                            ->placeholder('-'),
                        TextEntry::make('issueDate')
                            ->label('Issue Date')
                            ->date()
                            ->placeholder('-'),
                        TextEntry::make('expireDate')
                            ->label('Expiry Date')
                            ->date()
                            ->placeholder('-'),
                        TextEntry::make('active')
                            ->label('Status')
                            ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'danger'),
                        TextEntry::make('PDFLocation')
                            ->label('Document')
                            ->formatStateUsing(fn ($state) => $state ? 'View Document' : null)
                            ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                            ->openUrlInNewTab()
                            ->badge()
                            ->color('primary')
                            ->placeholder('-'),
                    ]),
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
            ->recordTitleAttribute('chargeNr')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('chargeType.name')
                    ->label('Charge Type')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('chargeNr')
                    ->label('Charge #')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('issueDate')
                    ->label('Issued')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('expireDate')
                    ->label('Expires')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('PDFLocation')
                    ->label('Document')
                    ->formatStateUsing(fn ($state) => $state ? 'View' : null)
                    ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                    ->openUrlInNewTab()
                    ->badge()
                    ->color('primary')
                    ->placeholder('-')
                    ->toggleable(),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}

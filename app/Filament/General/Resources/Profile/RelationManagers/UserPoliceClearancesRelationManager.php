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

class UserPoliceClearancesRelationManager extends RelationManager
{
    protected static string $relationship = 'policeClearances';

    protected static ?string $title = 'Police Clearances';

    protected static ?string $modelLabel = 'police clearance';

    protected static ?string $pluralModelLabel = 'police clearances';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Clearance Details')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('result')
                            ->label('Result')
                            ->placeholder('-'),
                        TextEntry::make('dateDone')
                            ->label('Date Done')
                            ->date()
                            ->placeholder('-'),
                        TextEntry::make('active')
                            ->label('Status')
                            ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'danger'),
                        TextEntry::make('documentLocation')
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
            ->recordTitleAttribute('result')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('result')
                    ->label('Result')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('dateDone')
                    ->label('Date Done')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('documentLocation')
                    ->label('Document')
                    ->formatStateUsing(fn ($state) => $state ? 'View' : null)
                    ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                    ->openUrlInNewTab()
                    ->badge()
                    ->color('primary')
                    ->placeholder('-')
                    ->toggleable(),
                IconColumn::make('active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}

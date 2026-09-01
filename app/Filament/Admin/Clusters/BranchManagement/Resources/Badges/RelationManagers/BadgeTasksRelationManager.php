<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\RelationManagers;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Tables\BadgesTable;
use App\Services\LegacyHtmlService;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BadgeTasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    protected static ?string $title = 'Tasks';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('heading')
                ->maxLength(255)
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::normalize($state))
                ->helperText('Optional grouping heading shown above the task.'),
            Textarea::make('task')
                ->required()
                ->rows(4)
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::normalize($state)),
            Toggle::make('active')
                ->default(true)
                ->inline(false)
                ->helperText('Deactivated tasks are hidden from sign-off screens but existing awarded records keep referencing them.'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('task')
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->reorderable('position')
            ->defaultSort('position')
            ->headerActions([
                CreateAction::make()
                    ->modalWidth(Width::SevenExtraLarge)
                    ->mutateDataUsing(function (array $data): array {
                        $data['position'] = ((int) $this->getOwnerRecord()->tasks()->max('position')) + 1;

                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make()->modalWidth(Width::SevenExtraLarge),
                BadgesTable::deactivateAction()
                    ->modalDescription('The task is hidden from sign-off screens. Existing awarded records are not touched and the task can be reactivated at any time.'),
                BadgesTable::activateAction(),
            ])
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('position')->sortable()->toggleable(),
                TextColumn::make('heading')
                    ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))
                    ->placeholder('-')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('task')
                    ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::preview($state))
                    ->limit(100)
                    ->wrap()
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('active')->boolean()->sortable()->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('active'),
            ]);
    }
}

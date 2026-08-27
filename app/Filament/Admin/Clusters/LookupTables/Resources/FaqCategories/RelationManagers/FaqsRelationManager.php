<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\FaqCategories\RelationManagers;

use App\Services\LegacyHtmlService;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FaqsRelationManager extends RelationManager
{
    protected static string $relationship = 'faqs';

    protected static ?string $title = 'FAQ Entries';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('q')->label('Question')->required()->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state)),
            RichEditor::make('a')
                ->label('Answer')
                ->required()
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))
                ->columnSpanFull()
                ->toolbarButtons([['bold', 'italic', 'underline'], ['bulletList', 'orderedList'], ['undo', 'redo']])
                ->helperText('Stored as HTML. The legacy pages strip all but basic tags (bold, underline, italic as i, lists, paragraphs, line breaks) when displaying.'),
            TextInput::make('targetID')->label('Target ID')->numeric()->required()->default(0)->helperText('Legacy target number. Only the legacy FAQ search filters by it (value 1); the category pages ignore it.'),
            TextInput::make('position')->label('Position')->numeric()->required()->default(0),
            Toggle::make('active')->label('Active')->default(true)->inline(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('q')
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->reorderable('position')
            ->headerActions([
                CreateAction::make()->modalWidth(Width::SevenExtraLarge),
            ])
            ->recordActions([
                EditAction::make()->modalWidth(Width::SevenExtraLarge),
                DeleteAction::make(),
            ])
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('q')->label('Question')->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))->searchable()->sortable()->toggleable(),
                TextColumn::make('position')->label('Position')->sortable()->toggleable(),
                TextColumn::make('a')->label('Answer')->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::preview($state))->limit(80)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('targetID')->label('Target ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('active')->label('Active')->boolean()->toggleable(),
            ])
            ->defaultSort('position');
    }
}

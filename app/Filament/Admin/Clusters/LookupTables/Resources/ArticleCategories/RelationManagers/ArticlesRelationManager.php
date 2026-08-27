<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ArticleCategories\RelationManagers;

use App\Services\LegacyHtmlService;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ArticlesRelationManager extends RelationManager
{
    protected static string $relationship = 'articles';

    protected static ?string $title = 'Articles';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Title')->required()->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state)),
            TextInput::make('slug')->label('Slug')->required()->helperText('Used in legacy article URLs.'),
            Textarea::make('intro')->label('Intro')->required()->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))->rows(3)->columnSpanFull()->helperText('Teaser shown on the legacy article listings.'),
            RichEditor::make('article')
                ->label('Article')
                ->required()
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))
                ->columnSpanFull()
                ->toolbarButtons([['bold', 'italic', 'underline'], ['bulletList', 'orderedList'], ['undo', 'redo']])
                ->helperText('Stored as HTML. The legacy pages strip all but basic tags (bold, underline, italic as i, lists, paragraphs, line breaks) when displaying.'),
            Toggle::make('active')->label('Active')->default(true)->inline(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->headerActions([
                CreateAction::make()
                    ->modalWidth(Width::SevenExtraLarge)
                    ->mutateDataUsing(function (array $data): array {
                        $data['created'] = now();
                        $data['createdby'] = (string) (auth()->id() ?? 1);

                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make()->modalWidth(Width::SevenExtraLarge),
                DeleteAction::make(),
            ])
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')->label('Title')->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))->searchable()->sortable()->toggleable(),
                TextColumn::make('slug')->label('Slug')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('intro')->label('Intro')->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::preview($state))->limit(60)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('views')->label('Views')->sortable()->toggleable(),
                IconColumn::make('active')->label('Active')->boolean()->toggleable(),
                TextColumn::make('created')->label('Created')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('createdby')->label('Created By')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created', 'desc');
    }
}

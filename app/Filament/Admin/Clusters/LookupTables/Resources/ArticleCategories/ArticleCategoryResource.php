<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ArticleCategories;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\ArticleCategories\Pages\ManageArticleCategories;
use App\Filament\Admin\Clusters\LookupTables\Resources\ArticleCategories\Pages\ViewArticleCategory;
use App\Filament\Admin\Clusters\LookupTables\Resources\ArticleCategories\RelationManagers\ArticlesRelationManager;
use App\Models\SdArticleCat;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ArticleCategoryResource extends Resource
{
    protected static ?string $model = SdArticleCat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Bars3BottomLeft;

    protected static ?string $pluralLabel = 'Article Categories';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 132;

    protected static string|UnitEnum|null $navigationGroup = 'Content & Support';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required(),
            TextInput::make('slug')->label('Slug')->required()->helperText('Used in legacy article category URLs.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn (SdArticleCat $record): string => static::getUrl('view', ['record' => $record]))
            ->defaultPaginationPageOption(25)
            ->recordActions([ViewAction::make(), EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: categories for the articles module. The slug appears in article category URLs and the left navigation.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->label('Name')->searchable()->sortable()->toggleable(),
                TextColumn::make('slug')->label('Slug')->searchable()->sortable()->toggleable(),
            ])
            ->defaultSort('name');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Category')
                ->collapsible()
                ->columns(3)
                ->columnSpanFull()
                ->schema([
                    TextEntry::make('id')->label('ID'),
                    TextEntry::make('name')->label('Name'),
                    TextEntry::make('slug')->label('Slug'),
                ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            ArticlesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageArticleCategories::route('/'),
            'view' => ViewArticleCategory::route('/{record}'),
        ];
    }
}

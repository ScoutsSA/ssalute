<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ArticleCategories;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\ArticleCategories\Pages\ManageArticleCategories;
use App\Models\SdArticleCat;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
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

    protected static ?int $navigationSort = 131;

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
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: categories for the articles module. The slug appears in article category URLs and the left navigation.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->label('Name')->searchable()->sortable()->toggleable(),
                TextColumn::make('slug')->label('Slug')->searchable()->sortable()->toggleable(),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageArticleCategories::route('/'),
        ];
    }
}

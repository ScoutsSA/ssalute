<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\Articles;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\Articles\Pages\ManageArticles;
use App\Models\SdArticle;
use App\Models\SdArticleCat;
use App\Services\LegacyHtmlService;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ArticleResource extends Resource
{
    protected static ?string $model = SdArticle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Bars3BottomLeft;

    protected static ?string $pluralLabel = 'Articles';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 133;

    protected static string|UnitEnum|null $navigationGroup = 'Content & Support';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('catID')
                ->label('Category')
                ->options(fn (): array => SdArticleCat::query()->orderBy('name')->get()->mapWithKeys(fn (SdArticleCat $category): array => [$category->id => "{$category->name} (#{$category->id})"])->all())
                ->required()
                ->searchable(),
            TextInput::make('title')->label('Title')->required(),
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

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make()->modalWidth(Width::SevenExtraLarge), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: the articles shown on the legacy articles pages and category listings. The intro is the listing teaser; the article body is stored as HTML and the legacy pages strip all but basic tags when displaying.')
            ->modifyQueryUsing(fn (Builder $query) => $query->with('category'))
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')->label('Title')->searchable()->sortable()->toggleable(),
                TextColumn::make('catID')->label('Category')->state(fn (SdArticle $record): string => $record->category ? "{$record->category->name} (#{$record->catID})" : (string) $record->catID)->sortable()->toggleable(),
                TextColumn::make('slug')->label('Slug')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('intro')->label('Intro')->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::preview($state))->limit(60)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('views')->label('Views')->sortable()->toggleable(),
                TextColumn::make('groupID')->label('Group ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('active')->label('Active')->boolean()->toggleable(),
                TextColumn::make('created')->label('Created')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('createdby')->label('Created By')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageArticles::route('/'),
        ];
    }
}

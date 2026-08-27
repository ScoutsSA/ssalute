<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\FaqEntries;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\FaqEntries\Pages\ManageFaqEntries;
use App\Models\SystemFaq;
use App\Models\SystemFaqCat;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class FaqEntryResource extends Resource
{
    protected static ?string $model = SystemFaq::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::QuestionMarkCircle;

    protected static ?string $pluralLabel = 'FAQ Entries';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 131;

    protected static string|UnitEnum|null $navigationGroup = 'Content & Support';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('catID')
                ->label('Category')
                ->options(fn (): array => SystemFaqCat::query()->orderBy('name')->get()->mapWithKeys(fn (SystemFaqCat $category): array => [$category->id => "{$category->name} ({$category->audience}) (#{$category->id})"])->all())
                ->required()
                ->searchable(),
            TextInput::make('q')->label('Question')->required(),
            RichEditor::make('a')
                ->label('Answer')
                ->required()
                ->columnSpanFull()
                ->toolbarButtons([['bold', 'italic', 'underline'], ['bulletList', 'orderedList'], ['undo', 'redo']])
                ->helperText('Stored as HTML. The legacy pages strip all but basic tags (bold, underline, italic as i, lists, paragraphs, line breaks) when displaying. Older entries may show doubly encoded HTML from the legacy editor; they still render on the legacy pages but need manual cleanup here before rich editing.'),
            TextInput::make('targetID')->label('Target ID')->numeric()->required()->default(0)->helperText('Legacy target number. Only the legacy FAQ search filters by it (value 1); the category pages ignore it.'),
            TextInput::make('position')->label('Position')->numeric()->required()->default(0),
            Toggle::make('active')->label('Active')->default(true)->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: the FAQ entries shown on the FAQ pages and search, per FAQ category. Answers are stored as HTML and the legacy pages strip all but basic tags when displaying.')
            ->modifyQueryUsing(fn (Builder $query) => $query->with('category'))
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('q')->label('Question')->searchable()->sortable()->toggleable(),
                TextColumn::make('catID')->label('Category')->state(fn (SystemFaq $record): string => $record->category ? "{$record->category->name} ({$record->category->audience}) (#{$record->catID})" : (string) $record->catID)->sortable()->toggleable(),
                TextColumn::make('position')->label('Position')->sortable()->toggleable(),
                TextColumn::make('a')->label('Answer')->limit(80)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('targetID')->label('Target ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('active')->label('Active')->boolean()->toggleable(),
            ])
            ->defaultSort('position');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageFaqEntries::route('/'),
        ];
    }
}

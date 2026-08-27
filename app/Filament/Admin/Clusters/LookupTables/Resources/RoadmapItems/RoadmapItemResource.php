<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\RoadmapItems;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\RoadmapItems\Pages\ManageRoadmapItems;
use App\Models\SystemRoadmapLittle;
use App\Services\LegacyHtmlService;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class RoadmapItemResource extends Resource
{
    protected static ?string $model = SystemRoadmapLittle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    protected static ?string $pluralLabel = 'Roadmap Items';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 134;

    protected static string|UnitEnum|null $navigationGroup = 'Content & Support';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('area')->label('Area')->required()->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state)),
            RichEditor::make('text')->label('Text')->required()->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))->columnSpanFull()->toolbarButtons([['bold', 'italic', 'underline'], ['bulletList', 'orderedList'], ['undo', 'redo']])->helperText('Stored as HTML. The legacy pages strip all but basic tags (bold, underline, italic as i, lists, paragraphs, line breaks) when displaying.'),
            DatePicker::make('releaseDate')->label('Release Date')->required(),
            Toggle::make('active')->label('Active')->default(true)->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make()->modalWidth(Width::SevenExtraLarge), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: entries for the little roadmap page and the new functionality panel shown on dashboards.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('area')->label('Area')->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))->searchable()->sortable()->toggleable(),
                TextColumn::make('text')->label('Text')->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::preview($state))->limit(80)->searchable()->toggleable(),
                TextColumn::make('releaseDate')->label('Release Date')->date()->sortable()->toggleable(),
                IconColumn::make('active')->label('Active')->boolean()->toggleable(),
                TextColumn::make('created')->label('Created')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('createdby')->label('Created By')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('releaseDate', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRoadmapItems::route('/'),
        ];
    }
}

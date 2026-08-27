<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\YouthDocumentTypes;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\YouthDocumentTypes\Pages\ManageYouthDocumentTypes;
use App\Models\SystemDocumentType;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class YouthDocumentTypeResource extends Resource
{
    protected static ?string $model = SystemDocumentType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?string $pluralLabel = 'Youth Document Types';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 72;

    protected static string|UnitEnum|null $navigationGroup = 'Documents';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required(),
            Textarea::make('description')->label('Description')->default('')->columnSpanFull(),
            Toggle::make('youth')->label('Youth')->default(true)->inline(false)->helperText('Not an enabled flag. On means the type is offered on the legacy youth document upload picker; off means it is only assigned programmatically by other legacy modules (advancements, badges, warrants, transfers) and still displays on document lists.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: the document types for the youth and group document store. Rows flagged as youth are offered on the upload picker for youth members; the rest are written with hardcoded ids by other legacy modules and only display on document lists. There is no active column, so deleting is the only way to retire a type and existing documents of that type would then show a blank type name.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->label('Name')->searchable()->sortable()->toggleable(),
                IconColumn::make('youth')->label('Youth')->boolean()->toggleable(),
                TextColumn::make('description')->label('Description')->limit(60)->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageYouthDocumentTypes::route('/'),
        ];
    }
}

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
            Toggle::make('youth')->label('Youth')->default(true)->inline(false)->helperText('Types flagged as youth appear in the legacy youth document upload list.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: the type list offered when a document is uploaded for a youth member from the group youth screens, and the type names shown on member document lists. Only rows flagged as youth are offered on the youth upload form.')
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

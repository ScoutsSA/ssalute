<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\Languages;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\Languages\Pages\ManageLanguages;
use App\Models\AmsLanguage;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class LanguageResource extends Resource
{
    protected static ?string $model = AmsLanguage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChatBubbleLeftRight;

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 12;

    protected static string|UnitEnum|null $navigationGroup = 'Member Profile';

    protected static ?string $recordTitleAttribute = 'language';

    protected static ?string $pluralLabel = 'Languages';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Details')->schema([
                TextInput::make('language')->required(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: the language options on the AMS adult add and edit forms.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('language')->searchable()->sortable(),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageLanguages::route('/')];
    }
}

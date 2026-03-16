<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\Titles;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\Titles\Pages\ManageTitles;
use App\Models\SystemTitle;
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

class TitleResource extends Resource
{
    protected static ?string $model = SystemTitle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Identification;

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 13;

    protected static string|UnitEnum|null $navigationGroup = 'Member Profile';

    protected static ?string $pluralLabel = 'Titles';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable())
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')->searchable()->sortable(),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageTitles::route('/')];
    }
}

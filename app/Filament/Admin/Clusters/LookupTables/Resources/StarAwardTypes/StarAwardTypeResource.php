<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\StarAwardTypes;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\StarAwardTypes\Pages\ManageStarAwardTypes;
use App\Models\SystemStarAwardType;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class StarAwardTypeResource extends Resource
{
    protected static ?string $model = SystemStarAwardType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Star;

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 50;

    protected static string|UnitEnum|null $navigationGroup = 'Awards';

    protected static ?string $pluralLabel = 'Star Award Types';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            TextInput::make('area')->default(0),
            Toggle::make('active')->default(true)->inline(false),
            TextInput::make('position')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: the award type options when capturing a star award for a group.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('area')->searchable(),
                TextColumn::make('position')->sortable(),
                IconColumn::make('active')->boolean(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageStarAwardTypes::route('/')];
    }
}

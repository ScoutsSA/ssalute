<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\AssetConditions;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\AssetConditions\Pages\ManageAssetConditions;
use App\Models\SystemAssetCondition;
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

class AssetConditionResource extends Resource
{
    protected static ?string $model = SystemAssetCondition::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Wrench;

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 41;

    protected static string|UnitEnum|null $navigationGroup = 'Financial';

    protected static ?string $pluralLabel = 'Asset Conditions';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            Textarea::make('description')->default(''),
            Toggle::make('active')->inline(false),
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
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('description')->limit(60),
                IconColumn::make('active')->boolean(),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageAssetConditions::route('/')];
    }
}

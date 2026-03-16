<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ParentTypes;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\ParentTypes\Pages\ManageParentTypes;
use App\Models\SystemParentType;
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

class ParentTypeResource extends Resource
{
    protected static ?string $model = SystemParentType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 23;

    protected static string|UnitEnum|null $navigationGroup = 'Group Structure';

    protected static ?string $pluralLabel = 'Parent Types';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
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
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageParentTypes::route('/')];
    }
}

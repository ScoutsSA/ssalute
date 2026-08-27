<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\GroupTypes;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\GroupTypes\Pages\ManageGroupTypes;
use App\Models\GroupsType;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class GroupTypeResource extends Resource
{
    protected static ?string $model = GroupsType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static ?string $pluralLabel = 'Group Types';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 24;

    protected static string|UnitEnum|null $navigationGroup = 'Group Structure';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required(),
            Textarea::make('description')->label('Description')->default('')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: classifies scout groups (community, church, school and similar). Read by the AMS management screens, district group listings, census and management reports.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->label('Name')->searchable()->sortable()->toggleable(),
                TextColumn::make('description')->label('Description')->limit(60)->toggleable(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageGroupTypes::route('/'),
        ];
    }
}

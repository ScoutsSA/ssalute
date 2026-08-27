<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\GroupManagementLevels;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\GroupManagementLevels\Pages\ManageGroupManagementLevels;
use App\Models\SystemGroupManagementLevel;
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

class GroupManagementLevelResource extends Resource
{
    protected static ?string $model = SystemGroupManagementLevel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartBar;

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 22;

    protected static string|UnitEnum|null $navigationGroup = 'Group Structure';

    protected static ?string $pluralLabel = 'Group Management Levels';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('type')->default(''),
            TextInput::make('name')->required(),
            Textarea::make('description')->default(''),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: youth leadership levels, used on the youth add, edit and manage screens, section dashboards, attendance, the group directory and advancement authorisation.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('type')->searchable()->sortable(),
                TextColumn::make('description')->limit(60),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created')->label('Created At')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('createdby')->label('Created By')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageGroupManagementLevels::route('/')];
    }
}

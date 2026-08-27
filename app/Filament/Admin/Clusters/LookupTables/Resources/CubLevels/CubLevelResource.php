<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\CubLevels;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\CubLevels\Pages\ManageCubLevels;
use App\Models\SystemAdvancementCubsLevel;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class CubLevelResource extends Resource
{
    protected static ?string $model = SystemAdvancementCubsLevel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Bars3BottomLeft;

    protected static ?string $pluralLabel = 'Cub Levels';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 120;

    protected static string|UnitEnum|null $navigationGroup = 'Advancement Levels';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Level Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        TextInput::make('colour')
                            ->label('Colour'),
                        Toggle::make('active')
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: the Cub advancement levels, used across advancement sign off from programs and events, admin advancement screens, youth advancement reports and dashboards.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('position')
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('colour')
                    ->sortable(),
                IconColumn::make('active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('programType')->label('Program Type')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('description')->limit(60)->sortable()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('highLevel')->label('High Level')->boolean()->sortable()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('investment')->boolean()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('active', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCubLevels::route('/'),
        ];
    }
}

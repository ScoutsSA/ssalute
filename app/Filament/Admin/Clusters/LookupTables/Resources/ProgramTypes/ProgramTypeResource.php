<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ProgramTypes;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\ProgramTypes\Pages\ManageProgramTypes;
use App\Models\SystemProgramType;
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

class ProgramTypeResource extends Resource
{
    protected static ?string $model = SystemProgramType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AcademicCap;

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 31;

    protected static string|UnitEnum|null $navigationGroup = 'Events & Programs';

    protected static ?string $pluralLabel = 'Program Types';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            TextInput::make('area')->numeric(),
            Toggle::make('active')->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: generic program types for group programs, used on the program manage and view screens, program sign off for advancement and badges, attendance reports and financial account views. The four branch specific program type tables have their own pages.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('area')->sortable(),
                IconColumn::make('active')->boolean(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageProgramTypes::route('/')];
    }
}

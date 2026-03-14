<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\ProgramTypes;

use App\Filament\Admin\Clusters\Settings\Resources\ProgramTypes\Pages\ManageProgramTypes;
use App\Filament\Admin\Clusters\Settings\SettingsCluster;
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

    protected static ?string $cluster = SettingsCluster::class;

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
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable())
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

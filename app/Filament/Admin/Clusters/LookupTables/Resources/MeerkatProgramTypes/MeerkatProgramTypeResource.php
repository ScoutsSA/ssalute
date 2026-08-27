<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\MeerkatProgramTypes;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\MeerkatProgramTypes\Pages\ManageMeerkatProgramTypes;
use App\Models\SystemProgramTypesMeerkat;
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

class MeerkatProgramTypeResource extends Resource
{
    protected static ?string $model = SystemProgramTypesMeerkat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    protected static ?string $pluralLabel = 'Meerkat Program Types';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 33;

    protected static string|UnitEnum|null $navigationGroup = 'Events & Programs';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required(),
            Toggle::make('active')->label('Active')->default(true)->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: program and meeting types for the Meerkat branch, used when adding or editing programs and events, on advancement and badge sign off from programs, and on census and group reports.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->label('Name')->searchable()->sortable()->toggleable(),
                IconColumn::make('active')->label('Active')->boolean()->toggleable(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created')->label('Created')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('createdby')->label('Created By')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMeerkatProgramTypes::route('/'),
        ];
    }
}

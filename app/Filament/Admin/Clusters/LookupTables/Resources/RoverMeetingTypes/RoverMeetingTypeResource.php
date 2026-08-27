<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\RoverMeetingTypes;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\RoverMeetingTypes\Pages\ManageRoverMeetingTypes;
use App\Models\SystemRoverMeetingType;
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

class RoverMeetingTypeResource extends Resource
{
    protected static ?string $model = SystemRoverMeetingType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 32;

    protected static string|UnitEnum|null $navigationGroup = 'Events & Programs';

    protected static ?string $pluralLabel = 'Rover Meeting Types';

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
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: the meeting type options for Rover programs on the program add, edit and manage screens.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageRoverMeetingTypes::route('/')];
    }
}

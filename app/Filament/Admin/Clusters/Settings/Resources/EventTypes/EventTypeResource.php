<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\EventTypes;

use App\Filament\Admin\Clusters\Settings\Resources\EventTypes\Pages\ManageEventTypes;
use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Models\SystemGroupEventType;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
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

class EventTypeResource extends Resource
{
    protected static ?string $model = SystemGroupEventType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 30;

    protected static string|UnitEnum|null $navigationGroup = 'Events & Programs';

    protected static ?string $pluralLabel = 'Group Event Types';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Details')->schema([
                TextInput::make('name')->required(),
                Toggle::make('groupType')->label('Group')->inline(false),
                Toggle::make('districtType')->label('District')->inline(false),
                Toggle::make('regionalType')->label('Regional')->inline(false),
                Toggle::make('nationalType')->label('National')->inline(false),
                Toggle::make('active')->default(true)->inline(false),
            ]),
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
                TextColumn::make('position')->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                IconColumn::make('groupType')->label('Group')->boolean(),
                IconColumn::make('districtType')->label('District')->boolean(),
                IconColumn::make('regionalType')->label('Regional')->boolean(),
                IconColumn::make('nationalType')->label('National')->boolean(),
                IconColumn::make('active')->boolean(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageEventTypes::route('/')];
    }
}

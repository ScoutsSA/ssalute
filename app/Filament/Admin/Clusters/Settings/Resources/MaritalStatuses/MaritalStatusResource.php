<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\MaritalStatuses;

use App\Filament\Admin\Clusters\Settings\Resources\MaritalStatuses\Pages\ManageMaritalStatuses;
use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Models\AmsMaritalStatus;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class MaritalStatusResource extends Resource
{
    protected static ?string $model = AmsMaritalStatus::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Heart;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 10;

    protected static string|UnitEnum|null $navigationGroup = 'Member Profile';

    protected static ?string $pluralLabel = 'Marital Statuses';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Details')->schema([
                TextInput::make('name')->required(),
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
                TextColumn::make('name')->searchable()->sortable(),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageMaritalStatuses::route('/')];
    }
}

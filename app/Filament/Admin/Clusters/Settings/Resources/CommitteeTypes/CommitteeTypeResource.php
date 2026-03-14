<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\CommitteeTypes;

use App\Filament\Admin\Clusters\Settings\Resources\CommitteeTypes\Pages\ManageCommitteeTypes;
use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Models\SystemCommitteeType;
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

class CommitteeTypeResource extends Resource
{
    protected static ?string $model = SystemCommitteeType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 20;

    protected static string|UnitEnum|null $navigationGroup = 'Group Structure';

    protected static ?string $pluralLabel = 'Committee Types';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Details')->schema([
                TextInput::make('name')->required(),
                Textarea::make('description')->default(''),
                Toggle::make('active')->inline(false),
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
                TextColumn::make('description')->limit(60),
                IconColumn::make('active')->boolean(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created')->label('Created At')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('createdby')->label('Created By')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageCommitteeTypes::route('/')];
    }
}

<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\WarrantTypes;

use App\Filament\Admin\Clusters\Settings\Resources\WarrantTypes\Pages\ManageWarrantTypes;
use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Models\AmsWarrantType;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class WarrantTypeResource extends Resource
{
    protected static ?string $model = AmsWarrantType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?string $pluralLabel = 'Warrant Types';

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 60;

    protected static string|UnitEnum|null $navigationGroup = 'Warrants';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                TextInput::make('shortName')
                    ->label('Short Name')
                    ->default(''),
                Textarea::make('description')
                    ->label('Description')
                    ->default('')
                    ->columnSpanFull(),
                Toggle::make('national')
                    ->label('National')
                    ->inline(false),
                Toggle::make('region')
                    ->label('Region')
                    ->inline(false),
                Toggle::make('district')
                    ->label('District')
                    ->inline(false),
                Toggle::make('group')
                    ->label('Group')
                    ->inline(false),
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
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('shortName')->label('Short Name')->searchable(),
                IconColumn::make('national')->label('National')->boolean(),
                IconColumn::make('region')->label('Region')->boolean(),
                IconColumn::make('district')->label('District')->boolean(),
                IconColumn::make('group')->label('Group')->boolean(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('position')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('description')->limit(60)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created')->label('Created At')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('createdby')->label('Created By')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('modified')->label('Modified At')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('modifiedby')->label('Modified By')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageWarrantTypes::route('/'),
        ];
    }
}

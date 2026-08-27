<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\LicenceTypes;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\LicenceTypes\Pages\ManageLicenceTypes;
use App\Models\AmsLicenceType;
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

class LicenceTypeResource extends Resource
{
    protected static ?string $model = AmsLicenceType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?string $pluralLabel = 'Licence Types';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 80;

    protected static string|UnitEnum|null $navigationGroup = 'Licences & Disciplinary';

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
                Toggle::make('active')
                    ->label('Active')
                    ->default(true)
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: water activity licence types (called charges in the legacy schema), used on the charge add, manage and view screens and on member and youth charge listings and profiles.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('shortName')->label('Short Name')->searchable(),
                IconColumn::make('active')->label('Active')->boolean(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('position')->sortable()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('forScouts')->label('For Scouts')->boolean()->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ManageLicenceTypes::route('/'),
        ];
    }
}

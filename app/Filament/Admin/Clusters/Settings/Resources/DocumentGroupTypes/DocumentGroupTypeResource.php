<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\DocumentGroupTypes;

use App\Filament\Admin\Clusters\Settings\Resources\DocumentGroupTypes\Pages\ManageDocumentGroupTypes;
use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Models\AmsDocumentTypesGroup;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class DocumentGroupTypeResource extends Resource
{
    protected static ?string $model = AmsDocumentTypesGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::FolderOpen;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 71;

    protected static string|UnitEnum|null $navigationGroup = 'Documents';

    protected static ?string $pluralLabel = 'Document Group Types';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            Textarea::make('description')->default(''),
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
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageDocumentGroupTypes::route('/'),
        ];
    }
}

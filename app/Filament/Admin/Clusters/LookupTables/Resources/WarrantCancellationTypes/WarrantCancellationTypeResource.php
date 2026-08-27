<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\WarrantCancellationTypes;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\WarrantCancellationTypes\Pages\ManageWarrantCancellationTypes;
use App\Models\AmsWarrantCancellationType;
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

class WarrantCancellationTypeResource extends Resource
{
    protected static ?string $model = AmsWarrantCancellationType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::XCircle;

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 61;

    protected static string|UnitEnum|null $navigationGroup = 'Warrants';

    protected static ?string $pluralLabel = 'Warrant Cancellation Types';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            Toggle::make('active')->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: the reason options when cancelling a warrant in AMS.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->searchable()->sortable(),
                IconColumn::make('active')->boolean(),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageWarrantCancellationTypes::route('/'),
        ];
    }
}

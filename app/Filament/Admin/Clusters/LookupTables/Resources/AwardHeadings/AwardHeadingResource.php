<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\AwardHeadings;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\AwardHeadings\Pages\ManageAwardHeadings;
use App\Models\AmsAwardHeading;
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

class AwardHeadingResource extends Resource
{
    protected static ?string $model = AmsAwardHeading::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Trophy;

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 52;

    protected static string|UnitEnum|null $navigationGroup = 'Awards';

    protected static ?string $pluralLabel = 'Award Headings';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('reason')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: groups the award types on the AMS award add screen and the individual award view.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('reason')->searchable()->sortable(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('reason');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAwardHeadings::route('/'),
        ];
    }
}

<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ResignReasons;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\ResignReasons\Pages\ManageResignReasons;
use App\Models\AmsResignReason;
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

class ResignReasonResource extends Resource
{
    protected static ?string $model = AmsResignReason::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?string $pluralLabel = 'Resign Reasons';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 90;

    protected static string|UnitEnum|null $navigationGroup = 'Member Status';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reason')
                    ->label('Reason')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: the reason options when resigning an adult in AMS, shown on the inactive adults screen.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('reason')->label('Reason')->searchable()->sortable(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('reason');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageResignReasons::route('/'),
        ];
    }
}

<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\DisciplinaryHeadings;

use App\Filament\Admin\Clusters\Settings\Resources\DisciplinaryHeadings\Pages\ManageDisciplinaryHeadings;
use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Models\AmsDisciplinaryHeading;
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

class DisciplinaryHeadingResource extends Resource
{
    protected static ?string $model = AmsDisciplinaryHeading::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?string $pluralLabel = 'Disciplinary Headings';

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 81;

    protected static string|UnitEnum|null $navigationGroup = 'Charges & Disciplinary';

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
            ->description('Database table: ' . app(static::getModel())->getTable())
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
            'index' => ManageDisciplinaryHeadings::route('/'),
        ];
    }
}

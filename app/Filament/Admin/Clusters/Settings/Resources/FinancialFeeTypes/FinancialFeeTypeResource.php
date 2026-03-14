<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\FinancialFeeTypes;

use App\Filament\Admin\Clusters\Settings\Resources\FinancialFeeTypes\Pages\ManageFinancialFeeTypes;
use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Models\SystemFinancialFeeType;
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

class FinancialFeeTypeResource extends Resource
{
    protected static ?string $model = SystemFinancialFeeType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 42;

    protected static string|UnitEnum|null $navigationGroup = 'Financial';

    protected static ?string $pluralLabel = 'Financial Fee Types';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            Textarea::make('description')->default(''),
            Toggle::make('canBeProrated')->inline(false),
            Toggle::make('active')->default(true)->inline(false),
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
                IconColumn::make('canBeProrated')->boolean(),
                IconColumn::make('active')->boolean(),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageFinancialFeeTypes::route('/')];
    }
}

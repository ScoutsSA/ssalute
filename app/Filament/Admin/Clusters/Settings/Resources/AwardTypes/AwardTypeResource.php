<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\AwardTypes;

use App\Filament\Admin\Clusters\Settings\Resources\AwardTypes\Pages\ManageAwardTypes;
use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Models\AmsAwardHeading;
use App\Models\AmsAwardType;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
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

class AwardTypeResource extends Resource
{
    protected static ?string $model = AmsAwardType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?string $pluralLabel = 'Award Types';

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 51;

    protected static string|UnitEnum|null $navigationGroup = 'Awards';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('headingID')
                    ->label('Heading')
                    ->options(fn () => AmsAwardHeading::query()->orderBy('reason')->pluck('reason', 'id'))
                    ->searchable()
                    ->required(),
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
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable())
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('shortName')->label('Short Name')->searchable(),
                TextColumn::make('heading.reason')->label('Heading'),
                IconColumn::make('active')->label('Active')->boolean(),
                TextColumn::make('headingID')->label('Heading ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ManageAwardTypes::route('/'),
        ];
    }
}

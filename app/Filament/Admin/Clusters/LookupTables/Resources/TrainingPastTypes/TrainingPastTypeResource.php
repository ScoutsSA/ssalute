<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\TrainingPastTypes;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\TrainingPastTypes\Pages\ManageTrainingPastTypes;
use App\Models\AmsTrainingPastType;
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

class TrainingPastTypeResource extends Resource
{
    protected static ?string $model = AmsTrainingPastType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Clock;

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 111;

    protected static string|UnitEnum|null $navigationGroup = 'Training';

    protected static ?string $pluralLabel = 'Training Past Types';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            TextInput::make('shortName')->default(''),
            Textarea::make('description')->default(''),
            TextInput::make('code')->numeric(),
            TextInput::make('calendarColour'),
            Toggle::make('active')->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: the course options when capturing past training, booking courses and creating bookable courses, and on training views, reports and member past training lists.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('shortName')->searchable(),
                TextColumn::make('code')->sortable(),
                TextColumn::make('calendarColour'),
                IconColumn::make('active')->boolean(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ManageTrainingPastTypes::route('/'),
        ];
    }
}

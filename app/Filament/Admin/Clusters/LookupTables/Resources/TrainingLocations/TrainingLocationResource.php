<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\TrainingLocations;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\TrainingLocations\Pages\ManageTrainingLocations;
use App\Models\AmsTrainingLocation;
use App\Models\Region;
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
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class TrainingLocationResource extends Resource
{
    protected static ?string $model = AmsTrainingLocation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AcademicCap;

    protected static ?string $pluralLabel = 'Training Locations';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 112;

    protected static string|UnitEnum|null $navigationGroup = 'Training';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required(),
            Select::make('assocToRegion')->label('Region')->options(fn (): array => Region::query()->orderBy('name')->get()->mapWithKeys(fn (Region $region): array => [$region->id => "{$region->name} (#{$region->id})"])->all())->required()->searchable(),
            Textarea::make('address')->label('Address')->default('')->columnSpanFull(),
            TextInput::make('gpsLat')->label('GPS Latitude')->default(''),
            TextInput::make('gpsLon')->label('GPS Longitude')->default(''),
            TextInput::make('trainingSeats')->label('Training Seats')->numeric()->required()->default(0),
            TextInput::make('contact')->label('Contact Person')->default(''),
            TextInput::make('tel')->label('Telephone'),
            TextInput::make('cell')->label('Cell'),
            TextInput::make('email')->label('Email')->email(),
            Toggle::make('active')->label('Active')->default(true)->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: training venues managed by the regional training admin screens, and shown on future training listings, course bookings and training reports.')
            ->modifyQueryUsing(fn (Builder $query) => $query->with('region'))
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->label('Name')->searchable()->sortable()->toggleable(),
                TextColumn::make('assocToRegion')->label('Region')->state(fn (AmsTrainingLocation $record): ?string => $record->region ? "{$record->region->name} (#{$record->assocToRegion})" : null)->sortable()->toggleable(),
                TextColumn::make('trainingSeats')->label('Seats')->sortable()->toggleable(),
                TextColumn::make('contact')->label('Contact')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tel')->label('Telephone')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('cell')->label('Cell')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email')->label('Email')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('address')->label('Address')->limit(60)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gpsLat')->label('GPS Latitude')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gpsLon')->label('GPS Longitude')->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('active')->label('Active')->boolean()->toggleable(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created')->label('Created')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('createdby')->label('Created By')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTrainingLocations::route('/'),
        ];
    }
}

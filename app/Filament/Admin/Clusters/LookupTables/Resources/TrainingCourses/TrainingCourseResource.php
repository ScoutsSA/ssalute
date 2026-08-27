<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\TrainingCourses;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\TrainingCourses\Pages\ManageTrainingCourses;
use App\Models\AmsTrainingCourse;
use App\Models\Region;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
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

class TrainingCourseResource extends Resource
{
    protected static ?string $model = AmsTrainingCourse::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AcademicCap;

    protected static ?string $pluralLabel = 'Training Courses';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 113;

    protected static string|UnitEnum|null $navigationGroup = 'Training';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required(),
            Select::make('assocToRegion')->label('Region')->options(fn (): array => Region::query()->orderBy('name')->get()->mapWithKeys(fn (Region $region): array => [$region->id => "{$region->name} (#{$region->id})"])->all())->required()->searchable(),
            TextInput::make('nrOfDays')->label('Number Of Days')->numeric()->required()->default(1),
            TextInput::make('trainingSeats')->label('Training Seats')->numeric(),
            TextInput::make('maxBookings')->label('Max Bookings')->numeric(),
            TextInput::make('agendaPDFLocation')->label('Agenda PDF Location'),
            TextInput::make('materialPDFLocation')->label('Material PDF Location'),
            Toggle::make('active')->label('Active')->default(true)->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: the standard training course catalogue per region, managed by the regional training admin screens and used when creating bookable courses and training bookings.')
            ->modifyQueryUsing(fn (Builder $query) => $query->with('region'))
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->label('Name')->searchable()->sortable()->toggleable(),
                TextColumn::make('assocToRegion')->label('Region')->state(fn (AmsTrainingCourse $record): ?string => $record->region ? "{$record->region->name} (#{$record->assocToRegion})" : null)->sortable()->toggleable(),
                TextColumn::make('nrOfDays')->label('Days')->sortable()->toggleable(),
                TextColumn::make('trainingSeats')->label('Seats')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('maxBookings')->label('Max Bookings')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('agendaPDFLocation')->label('Agenda PDF')->limit(40)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('materialPDFLocation')->label('Material PDF')->limit(40)->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ManageTrainingCourses::route('/'),
        ];
    }
}

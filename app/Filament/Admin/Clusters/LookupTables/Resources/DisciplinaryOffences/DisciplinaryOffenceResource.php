<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\DisciplinaryOffences;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\DisciplinaryOffences\Pages\ManageDisciplinaryOffences;
use App\Models\AmsDisciplinaryHeading;
use App\Models\AmsDisciplinaryOffence;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class DisciplinaryOffenceResource extends Resource
{
    protected static ?string $model = AmsDisciplinaryOffence::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::XCircle;

    protected static ?string $pluralLabel = 'Disciplinary Offences';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 82;

    protected static string|UnitEnum|null $navigationGroup = 'Charges & Disciplinary';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('headingID')->label('Disciplinary Heading')->options(fn (): array => AmsDisciplinaryHeading::query()->orderBy('reason')->get()->mapWithKeys(fn (AmsDisciplinaryHeading $heading): array => [$heading->id => "{$heading->reason} (#{$heading->id})"])->all())->required()->searchable(),
            Textarea::make('offense')->label('Offence')->required()->columnSpanFull(),
            Toggle::make('active')->label('Active')->default(true)->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: the offence list offered when capturing adult disciplinary records on the AMS disciplinary screens, grouped under the disciplinary headings.')
            ->modifyQueryUsing(fn (Builder $query) => $query->with('heading'))
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('headingID')->label('Heading')->state(fn (AmsDisciplinaryOffence $record): string => $record->heading ? "{$record->heading->reason} (#{$record->headingID})" : (string) $record->headingID)->sortable()->toggleable(),
                TextColumn::make('offense')->label('Offence')->searchable()->limit(80)->toggleable(),
                IconColumn::make('active')->label('Active')->boolean()->toggleable(),
                TextColumn::make('countryID')->label('Country ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('headingID');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageDisciplinaryOffences::route('/'),
        ];
    }
}

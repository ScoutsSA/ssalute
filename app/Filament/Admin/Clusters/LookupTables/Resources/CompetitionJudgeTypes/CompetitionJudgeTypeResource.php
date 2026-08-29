<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\CompetitionJudgeTypes;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\CompetitionJudgeTypes\Pages\ManageCompetitionJudgeTypes;
use App\Models\EventCompetitionsJudgesType;
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

class CompetitionJudgeTypeResource extends Resource
{
    protected static ?string $model = EventCompetitionsJudgesType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Trophy;

    protected static ?string $pluralLabel = 'Competition Judge Types';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 37;

    protected static string|UnitEnum|null $navigationGroup = 'Events & Programs';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required(),
            Toggle::make('canAdmin')->label('Can Administer Competition')->inline(false),
            Toggle::make('canCaptureScores')->label('Can Capture Scores')->inline(false),
            Toggle::make('canAdminJudges')->label('Can Administer Judges')->inline(false),
            Toggle::make('canAdminFinances')->label('Can Administer Finances')->inline(false),
            Toggle::make('canAdminTeams')->label('Can Administer Teams')->inline(false),
            Toggle::make('medical')->label('Medical Role')->inline(false),
            Toggle::make('seaWorthiness')->label('Sea Worthiness Role')->inline(false),
            Toggle::make('active')->label('Active')->default(true)->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: judge role types for event competitions. The flags control what a judge may do on the competition dashboards, such as capturing scores or administering judges, finances and teams.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->label('Name')->searchable()->sortable()->toggleable(),
                IconColumn::make('canAdmin')->label('Admin')->boolean()->toggleable(),
                IconColumn::make('canCaptureScores')->label('Scores')->boolean()->toggleable(),
                IconColumn::make('canAdminJudges')->label('Judges')->boolean()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('canAdminFinances')->label('Finances')->boolean()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('canAdminTeams')->label('Teams')->boolean()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('medical')->label('Medical')->boolean()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('seaWorthiness')->label('Sea Worthiness')->boolean()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('active')->label('Active')->boolean()->toggleable(),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCompetitionJudgeTypes::route('/'),
        ];
    }
}

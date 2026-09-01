<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\RelationManagers;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Tables\BadgesTable;
use App\Models\SystemBadgeScoutsSecond;
use App\Services\LegacyHtmlService;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class AutoSignOffTasksRelationManager extends RelationManager
{
    protected static string $relationship = 'toBadgeLinks';

    protected static ?string $title = 'Auto Sign-Off Tasks';

    private static function taskLabel(?SystemBadgeScoutsSecond $task): ?string
    {
        if ($task === null) {
            return null;
        }

        $badgeName = $task->badgeFirst ? LegacyHtmlService::decode($task->badgeFirst->name) : 'Unknown badge';

        return "{$badgeName}: " . Str::limit((string) LegacyHtmlService::preview($task->task), 80) . " (#{$task->id})";
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('toBadgeTaskID')
                ->label('Badge task')
                ->required()
                ->searchable()
                ->getSearchResultsUsing(fn (string $search): array => SystemBadgeScoutsSecond::query()
                    ->with('badgeFirst')
                    ->where(fn (Builder $query) => $query
                        ->where('task', 'like', "%{$search}%")
                        ->orWhereHas('badgeFirst', fn (Builder $badge) => $badge->where('name', 'like', "%{$search}%")))
                    ->limit(50)
                    ->get()
                    ->mapWithKeys(fn (SystemBadgeScoutsSecond $task): array => [$task->id => self::taskLabel($task)])
                    ->all())
                ->getOptionLabelUsing(fn ($value): ?string => self::taskLabel(SystemBadgeScoutsSecond::query()->with('badgeFirst')->find($value)))
                ->helperText('When this badge is awarded, the selected task in the other badge is automatically signed off.'),
            Toggle::make('active')
                ->default(true)
                ->inline(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['toBadgeTask.badgeFirst']))
            ->description('Legacy behaviour: when this badge is fully signed off, each linked task below is automatically signed off for the youth member as well.')
            ->defaultPaginationPageOption(25)
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                BadgesTable::deactivateAction()
                    ->modalDescription('The link stops auto signing off the task. Existing awarded records are not touched.'),
                BadgesTable::activateAction(),
            ])
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('toBadgeTask.badgeFirst.name')
                    ->label('Badge')
                    ->state(fn ($record): string => $record->toBadgeTask?->badgeFirst
                        ? LegacyHtmlService::decode($record->toBadgeTask->badgeFirst->name) . " (#{$record->toBadgeTask->badgeFirst->id})"
                        : '-'),
                TextColumn::make('toBadgeTask.task')
                    ->label('Task')
                    ->state(fn ($record): string => $record->toBadgeTask
                        ? Str::limit((string) LegacyHtmlService::preview($record->toBadgeTask->task), 100) . " (#{$record->toBadgeTask->id})"
                        : '-')
                    ->wrap(),
                IconColumn::make('active')->boolean()->sortable()->toggleable(),
            ]);
    }
}

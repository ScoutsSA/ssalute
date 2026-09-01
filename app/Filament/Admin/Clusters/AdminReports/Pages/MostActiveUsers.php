<?php

namespace App\Filament\Admin\Clusters\AdminReports\Pages;

use App\Filament\Admin\Clusters\AdminReports\AdminReportsCluster;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Listeners\RecordSuccessfulLogin;
use App\Models\SystemUser;
use App\Models\SystemUserLogging;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Ranks users by their recorded activity in system_user_logging over a
 * selectable window. Legacy records every page view there; Ssalute sessions
 * only add a '/logon-action' row per login (see RecordSuccessfulLogin), so
 * page counts skew towards legacy usage while it is still in service.
 */
class MostActiveUsers extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $cluster = AdminReportsCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Fire;

    protected static ?string $navigationLabel = 'Most Active Users';

    protected static ?string $title = 'Most Active Users';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.admin.clusters.admin-reports.report';

    protected Width|string|null $maxContentWidth = Width::Full;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => $this->rankedQuery())
            ->defaultPaginationPageOption(25)
            ->description('Database table: system_user_logging. Page views recorded by the legacy system plus one logon row per Ssalute login. Ranked by pages viewed inside the selected window.')
            ->columns([
                TextColumn::make('name')
                    ->label('User')
                    ->state(fn (SystemUser $record): string => "{$record->name} (#{$record->id})")
                    ->searchable(['first_name', 'surname', 'username'])
                    ->url(fn (SystemUser $record): string => UserResource::getUrl('view', ['record' => $record])),
                TextColumn::make('pages_count')
                    ->label('Pages Viewed')
                    ->sortable(),
                TextColumn::make('logons_count')
                    ->label('Logins')
                    ->sortable(),
                TextColumn::make('last_activity')
                    ->label('Last Activity')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),
            ])
            ->defaultSort('pages_count', 'desc')
            ->filters([
                SelectFilter::make('window')
                    ->label('Window')
                    ->options([
                        7 => 'Last 7 days',
                        30 => 'Last 30 days',
                        90 => 'Last 90 days',
                        365 => 'Last year',
                    ])
                    ->default(30)
                    ->selectablePlaceholder(false)
                    ->query(fn (Builder $query): Builder => $query),
            ]);
    }

    private function rankedQuery(): Builder
    {
        $windowDays = (int) ($this->getTableFilterState('window')['value'] ?? 30);

        $activity = SystemUserLogging::query()
            ->selectRaw(
                'userID, COUNT(*) as pages_count, SUM(page = ?) as logons_count, MAX(created) as last_activity',
                [RecordSuccessfulLogin::LOGON_PAGE],
            )
            ->where('userID', '>', 0)
            ->where('page', 'not like', '/ajax/%')
            ->where('created', '>=', now()->subDays($windowDays))
            ->groupBy('userID');

        return SystemUser::query()
            ->joinSub($activity, 'activity', 'activity.userID', '=', 'system_users.id')
            ->select('system_users.*')
            ->addSelect(['activity.pages_count', 'activity.logons_count', 'activity.last_activity']);
    }
}

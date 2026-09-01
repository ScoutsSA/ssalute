<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Clusters\AdminReports\Resources\GoodLogons\GoodLogonResource;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Listeners\RecordSuccessfulLogin;
use App\Models\AdminGoodLogon;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

/**
 * The ten most recent successful logins across legacy and Ssalute. Rows link
 * to the member's BackOffice page when the username still matches a member,
 * and the heading links through to the full Logins report.
 */
class RecentLoginsWidget extends TableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = ['lg' => 3];

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent Logins')
            ->headerActions([
                Action::make('allLogins')
                    ->label('Full report')
                    ->link()
                    ->url(GoodLogonResource::getUrl('index')),
            ])
            ->query(fn (): Builder => AdminGoodLogon::query()
                ->leftJoin('system_users', 'system_users.username', '=', 'admin_good_logons.username')
                ->select('admin_good_logons.*')
                ->addSelect('system_users.id as linked_user_id')
                ->latest('date')
                ->limit(10))
            ->paginated(false)
            ->recordUrl(fn (AdminGoodLogon $record): ?string => $record->linked_user_id
                ? UserResource::getUrl('view', ['record' => $record->linked_user_id])
                : null)
            ->columns([
                TextColumn::make('username'),
                TextColumn::make('date')->dateTime('Y/m/d H:i'),
                TextColumn::make('fromSD')
                    ->label('Source')
                    ->badge()
                    ->formatStateUsing(fn (?int $state): string => (int) $state === RecordSuccessfulLogin::FROM_SSALUTE ? 'Ssalute' : 'Scouts Digital')
                    ->color(fn (?int $state): string => (int) $state === RecordSuccessfulLogin::FROM_SSALUTE ? 'success' : 'gray'),
            ]);
    }
}

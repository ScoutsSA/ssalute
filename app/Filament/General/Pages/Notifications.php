<?php

namespace App\Filament\General\Pages;

use App\Models\Notification as LegacyNotification;
use App\Settings\FeatureSettings;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Notifications extends Page
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::BellAlert;

    protected static ?string $navigationLabel = 'Notifications';

    protected static ?string $title = 'Notifications';

    protected static ?int $navigationSort = 5;

    public string $tab = 'active';

    protected string $view = 'filament.general.pages.notifications';

    public static function canAccess(): bool
    {
        return resolve(FeatureSettings::class)->users_can_view_notifications;
    }

    public function getNotifications(): LengthAwarePaginator
    {
        $user = auth()->user();

        $query = LegacyNotification::query()
            ->where('active', 1)
            ->where('userID', $user->id)
            ->where(function ($q) {
                $q->whereNull('doNotShowBefore')
                    ->orWhere('doNotShowBefore', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('doNotShowAfter')
                    ->orWhere('doNotShowAfter', '>=', now());
            });

        if ($this->tab === 'active') {
            $query->whereNull('dismissDate');
        } else {
            $query->whereNotNull('dismissDate');
        }

        return $query->orderByDesc('created')->paginate(20);
    }

    public function switchTab(string $tab): void
    {
        $this->tab = $tab;
    }

    public function dismiss(int $notificationId): void
    {
        LegacyNotification::where('id', $notificationId)
            ->where('userID', auth()->id())
            ->update([
                'dismissDate' => now(),
                'shown' => 1,
            ]);
    }
}

<?php

namespace App\Filament\Member\Widgets;

use App\Models\Notification as LegacyNotification;
use App\Settings\FeatureSettings;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class LegacyNotificationsWidget extends Widget
{
    protected static ?int $sort = 1;

    protected string $view = 'filament.member.widgets.legacy-notifications';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return resolve(FeatureSettings::class)->users_can_view_notifications;
    }

    public function getNotifications(): Collection
    {
        $user = auth()->user();

        return LegacyNotification::query()
            ->where('active', 1)
            ->where('userID', $user->id)
            ->where(function ($query) {
                $query->whereNull('doNotShowBefore')
                    ->orWhere('doNotShowBefore', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('doNotShowAfter')
                    ->orWhere('doNotShowAfter', '>=', now());
            })
            ->whereNull('dismissDate')
            ->orderByDesc('created')
            ->limit(5)
            ->get();
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

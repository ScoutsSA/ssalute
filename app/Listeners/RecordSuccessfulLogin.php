<?php

namespace App\Listeners;

use App\Models\AdminGoodLogon;
use App\Models\SystemUser;
use App\Models\SystemUserLogging;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Records every successful Ssalute login into the legacy login history tables,
 * mirroring what the legacy logon handling writes for Scouts Digital sessions:
 * a row in admin_good_logons (the BackOffice Logins report) and a
 * '/logon-action' row in system_user_logging (the Most Active Users report),
 * and system_users.lastLoginDate (the dashboard's recently active count).
 * Without this the reports would only ever show legacy activity.
 */
class RecordSuccessfulLogin
{
    /**
     * Legacy writes fromSD = 2 for its own sessions; 3 marks a login that
     * happened on Ssalute.
     */
    public const int FROM_SSALUTE = 3;

    public const string LOGON_PAGE = '/logon-action';

    private const int DEFAULT_COUNTRY_ID = 196;

    public function handle(Login $event): void
    {
        $user = $event->user;

        if (! $user instanceof SystemUser) {
            return;
        }

        try {
            $this->record($user);
        } catch (Throwable $exception) {
            Log::warning('Failed to record successful login', [
                'user_id' => $user->id,
                'exception' => $exception->getMessage(),
            ]);
        }
    }

    private function record(SystemUser $user): void
    {
        $primaryRole = $user->activeRoleAttachments()
            ->where('defaultRole', 1)
            ->orderByDesc('id')
            ->first();

        $userAgent = (string) request()->userAgent();

        AdminGoodLogon::query()->create([
            'username' => $user->username,
            'date' => now(),
            'ip' => (string) request()->ip(),
            'fromSD' => self::FROM_SSALUTE,
            'roleID' => $primaryRole?->roleID ?? 0,
            'groupID' => $primaryRole?->groupID ?? 0,
            'districtID' => $primaryRole?->districtID ?? 0,
            'regionID' => $primaryRole?->regionID ?? 0,
            'countryID' => self::DEFAULT_COUNTRY_ID,
            'userAgent' => $userAgent,
            'usingMobile' => $this->isMobileUserAgent($userAgent) ? 1 : 0,
        ]);

        SystemUserLogging::query()->create([
            'countryID' => self::DEFAULT_COUNTRY_ID,
            'regionID' => $primaryRole?->regionID ?? 0,
            'districtID' => $primaryRole?->districtID ?? 0,
            'groupID' => $primaryRole?->groupID ?? 0,
            'userID' => $user->id,
            'page' => self::LOGON_PAGE,
            'IP' => (string) request()->ip(),
            'userAgent' => $userAgent,
        ]);

        $user->newQueryWithoutScopes()
            ->whereKey($user->id)
            ->toBase()
            ->update(['lastLoginDate' => now()]);
    }

    private function isMobileUserAgent(string $userAgent): bool
    {
        return (bool) preg_match('/Mobile|Android|iPhone|iPad|Windows Phone/i', $userAgent);
    }
}

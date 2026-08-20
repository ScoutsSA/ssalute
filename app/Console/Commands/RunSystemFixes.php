<?php

namespace App\Console\Commands;

use App\Services\SystemFixes\EnsureEachUserHasOnlyOnePrimaryRole;
use App\Services\SystemFixes\EnsureLegacyValuesAreCanonical;
use App\Services\SystemFixes\EnsureYouthMemberIdsAreInSync;
use App\Services\SystemFixes\FlagUsersWithoutRoleInHomeLocation;
use App\Services\SystemFixes\ReportsFindings;
use App\Services\SystemFixes\SystemFix;
use App\Services\SystemFixes\SystemFixResult;
use App\Settings\DataFixesSettings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\SlackAlerts\Facades\SlackAlert;

class RunSystemFixes extends Command
{
    /**
     * The webhook name registered at runtime from DataFixesSettings.
     */
    private const SLACK_WEBHOOK_NAME = 'data_fixes';

    /**
     * Display name and icon shown for the bot in Slack.
     */
    private const SLACK_USERNAME = 'Data Fixes Bot';

    private const SLACK_ICON_EMOJI = ':wrench:';

    protected $signature = 'app:system-fixes';

    protected $description = 'Run system data-integrity fixes that keep records in the expected state.';

    /**
     * The fixes to run, in order. Each is individually toggleable via DataFixesSettings.
     *
     * @var list<class-string<SystemFix>>
     */
    private array $fixes = [
        EnsureEachUserHasOnlyOnePrimaryRole::class,
        EnsureYouthMemberIdsAreInSync::class,
        EnsureLegacyValuesAreCanonical::class,
        FlagUsersWithoutRoleInHomeLocation::class,
    ];

    public function handle(DataFixesSettings $settings): int
    {
        foreach ($this->fixes as $fixClass) {
            $fix = app($fixClass);

            if (! ($settings->{$fix->settingKey()} ?? false)) {
                $this->warn("Skipping (disabled): {$fix->label()}");
                Log::info('system_fix.skipped', ['fix' => $fixClass]);

                continue;
            }

            $this->info("Running: {$fix->label()}");
            Log::info('system_fix.started', ['fix' => $fixClass]);

            $result = $fix->run();

            $this->line($result->summary);
            Log::info('system_fix.completed', [
                'fix' => $fixClass,
                'summary' => $result->summary,
                'change_count' => count($result->changes),
                'changes' => $result->changes,
                'attention_count' => count($result->attentions),
                'attentions' => $result->attentions,
            ]);

            if ($result->shouldNotify()) {
                $this->notify($fix, $result, $settings);
            }
        }

        return self::SUCCESS;
    }

    /**
     * Send a Slack alert for a single fix result, immediately after it runs.
     * Suppressed unless both the global and the per-fix notification toggles are
     * on and a webhook is configured.
     */
    private function notify(SystemFix $fix, SystemFixResult $result, DataFixesSettings $settings): void
    {
        if (! $settings->notifications_enabled || ! ($settings->{$fix->notificationSettingKey()} ?? false)) {
            Log::info('system_fix.alert_skipped_notifications_disabled', [
                'fix' => $result->fix,
                'global_enabled' => $settings->notifications_enabled,
                'fix_enabled' => $settings->{$fix->notificationSettingKey()} ?? false,
            ]);

            return;
        }

        if (blank($settings->slack_webhook_url)) {
            Log::warning('system_fix.alert_skipped_no_webhook', ['fix' => $result->fix]);

            return;
        }

        config(['slack-alerts.webhook_urls.' . self::SLACK_WEBHOOK_NAME => $settings->slack_webhook_url]);

        SlackAlert::to(self::SLACK_WEBHOOK_NAME)
            ->withUsername(self::SLACK_USERNAME)
            ->withIconEmoji(self::SLACK_ICON_EMOJI)
            ->message($this->buildAlertMessage($result, $fix));
    }

    private function buildAlertMessage(SystemFixResult $result, ?SystemFix $fix = null): string
    {
        // A fix with its own page in the Data Fixes cluster sends a ping, not a dump: how many
        // items are outstanding and where to action them. Listing them in Slack gives an admin
        // something to read and nothing to click, and the same lines recur every night until
        // somebody acts.
        if ($fix instanceof ReportsFindings && filled($url = $fix->findingsUrl())) {
            $lines = [sprintf('*%s — %s*', config('app.name'), $result->fix)];

            if ($result->hasChanges()) {
                $lines[] = '';
                $lines[] = sprintf('Fixed automatically: %d %s.', count($result->changes), Str::plural('change', count($result->changes)));
            }

            if ($result->needsAttention()) {
                $count = count($result->attentions);
                $lines[] = '';
                $lines[] = sprintf('%d %s outstanding.', $count, Str::plural('item', $count));
            }

            $lines[] = '';
            $lines[] = sprintf('<%s|Review and fix →>', $url);

            return implode("\n", $lines);
        }

        $lines = [sprintf('*%s — %s*', config('app.name'), $result->fix)];

        if ($result->hasChanges()) {
            $lines[] = '';
            $lines[] = '*Changes made:*';
            foreach ($result->changes as $change) {
                $lines[] = "• {$change}";
            }
        }

        if ($result->needsAttention()) {
            $lines[] = '';
            $lines[] = '*Needs admin attention:*';
            foreach ($result->attentions as $attention) {
                $lines[] = "• {$attention}";
            }
        }

        return implode("\n", $lines);
    }
}

---
name: adding-a-data-fix
description: "Use this skill whenever you add a new data-integrity fix to the app:system-fixes command, or change how that command runs, schedules, logs, or notifies. Covers the SystemFix interface, SystemFixResult, registering a fix in RunSystemFixes, the per-fix enable/notification toggles in DataFixesSettings, and the Slack alerting flow. Do not use for one-off data scripts, generic console commands unrelated to system-fixes, or Filament resources."
---

# Adding a Data Fix

Data fixes keep legacy records in their expected state. They run nightly through one command, `app:system-fixes` (`App\Console\Commands\RunSystemFixes`), scheduled in `routes/console.php` at 04:00 SAST. The command iterates a list of fixes, runs each one if it is enabled, logs the outcome, and sends a Slack alert when the fix changed data or flagged something for an admin.

A new fix has four parts that must stay in sync:

1. A class implementing `App\Services\SystemFixes\SystemFix` in `app/Services/SystemFixes`.
2. Its registration in `RunSystemFixes::$fixes`.
3. Two toggles on `DataFixesSettings` (enable, and notify), plus the matching migration, Filament tab, and test seed. See the `adding-a-setting` skill for that half.
4. A feature test in `tests/Feature/Console`.

## 1. The fix class

Implement the `SystemFix` interface. A fix must be idempotent: when the data is already correct it makes no changes and returns a result with empty `changes` and `attentions`.

```php
namespace App\Services\SystemFixes;

class EnsureSomethingIsConsistent implements SystemFix
{
    public function label(): string
    {
        return 'Ensure something is consistent';
    }

    public function settingKey(): string
    {
        return 'ensure_something_is_consistent_enabled';
    }

    public function notificationSettingKey(): string
    {
        return 'ensure_something_is_consistent_notifications';
    }

    public function run(): SystemFixResult
    {
        // ... detect violators, fix only the rows that actually change ...

        return new SystemFixResult(
            $this->label(),
            $summary,        // one line, logged only, never the Slack body
            $changes,        // list<string>, one line per data change made
            $attentions,     // list<string>, one line per thing an admin must resolve
        );
    }
}
```

Conventions and expectations:

- `settingKey()` and `notificationSettingKey()` return the two `DataFixesSettings` property names for this fix. The convention is `<snake_label>_enabled` and `<snake_label>_notifications`.
- Detect only the records that violate the invariant (an aggregate query with `HAVING`, a targeted `where`, etc.) rather than scanning every row. See `EnsureEachUserHasOnlyOnePrimaryRole::usersNeedingReconciliation()`.
- Write only rows that actually change, so re-runs stay quiet and the audit trail is not noisy.
- Use Eloquent (models here use the `AppServiceProvider::DB_SD_CORE` connection). Eager-load relations you read while building change descriptions to avoid N+1.
- Log a structured `Log::warning('system_fix.<name>.<event>', [...])` for each change with useful context (ids and human names), in addition to the result lines.

## 2. SystemFixResult and the changes vs attentions split

`SystemFixResult($fix, $summary, $changes = [], $attentions = [])` is a readonly value object. The distinction drives the alert:

- **`summary`**: a single line describing the run ("Reconciled 3 users ..." or "Nothing to do"). It is logged via `system_fix.completed`. It is never sent to Slack.
- **`changes`**: data the fix changed on its own. Rendered under "Changes made" in the alert.
- **`attentions`**: problems the fix could not safely resolve and that need a human. Rendered under "Needs admin attention" in the alert.

`shouldNotify()` returns true when either `changes` or `attentions` is non-empty. If a fix only ever auto-resolves, it never populates `attentions`; reserve `attentions` for problems the fix cannot safely resolve on its own and that a human must decide on (for example two records that both look authoritative and cannot be merged automatically).

## 3. Registering the fix

Add the class to the ordered `$fixes` list on `RunSystemFixes`:

```php
private array $fixes = [
    EnsureEachUserHasOnlyOnePrimaryRole::class,
    EnsureSomethingIsConsistent::class,
];
```

The command handles the rest per fix: it skips the fix when `settingKey()` is off (logging `system_fix.skipped`), runs it, logs `system_fix.started` and `system_fix.completed`, then calls `notify()` when `shouldNotify()` is true. You do not write scheduling or notification code per fix.

## 4. The toggles (DataFixesSettings)

Every fix gets two booleans on `DataFixesSettings`, both defaulting to `true`:

- `<name>_enabled`: whether the fix runs at all.
- `<name>_notifications`: whether this fix may send Slack alerts.

Add the properties, a `database/settings` migration that seeds them, a new `Tab` on `ManageDataFixesSettings`, and the defaults in `SdCoreTestCase::ensureSettingsExist()`. Follow the `adding-a-setting` skill for the mechanics. Match the existing "Primary Role" tab: an enable toggle plus a notify toggle that is `->disabled(fn (Get $get) => ! $get('notifications_enabled'))->dehydrated()`.

The notification gate (already implemented in `RunSystemFixes::notify()`, do not reimplement it) sends a Slack message only when all of these hold:

1. The global master switch `notifications_enabled` is on, AND
2. this fix's `notificationSettingKey()` is on, AND
3. `slack_webhook_url` is set, AND
4. the result `shouldNotify()` (data changed or attention needed).

Slack alerts are posted to a runtime-registered `data_fixes` webhook (it does not clobber the global error webhook) as "Data Fixes Bot".

## 5. Tests

Add a feature test under `tests/Feature/Console` (see `RunSystemFixesTest`). Cover:

- Each branch of the invariant (the fix acts; the fix is a no-op when data is already correct).
- The fix is skipped when its `_enabled` toggle is off.
- No alert is sent when the global toggle is off, the per-fix toggle is off, or no webhook is set.

Use `SlackAlert::fake()` with `expectMessageSentContaining(...)` / `expectNoMessagesSent()`. Set toggles in the test with `app(DataFixesSettings::class)->fill([...])->save();`.

## Checklist

- [ ] Fix class implements `SystemFix` in `app/Services/SystemFixes`, idempotent, writes only changed rows.
- [ ] `settingKey()` / `notificationSettingKey()` follow the `_enabled` / `_notifications` convention.
- [ ] Structured `Log` context added for each change.
- [ ] Class registered in `RunSystemFixes::$fixes`.
- [ ] Two toggles added to `DataFixesSettings` (+ migration, Filament tab, test seed) per the `adding-a-setting` skill.
- [ ] Feature test covers behaviour, the disabled fix, and all three notification-suppression paths.
- [ ] `php artisan test --compact tests/Feature/Console/RunSystemFixesTest.php` passes.
- [ ] `vendor/bin/duster fix --dirty` run.

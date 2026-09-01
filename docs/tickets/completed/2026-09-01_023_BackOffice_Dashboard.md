# BackOffice Dashboard

**Priority when actioned:** p2

## Synopsis

The BackOffice dashboard was the stock Filament page with only the account, Filament info and beta warning widgets. Rebuild the legacy admin dashboard idea, modernised: platform KPI tiles, recent activity tables, and an attention area surfacing anything in the BackOffice needing a human, with expensive widgets cached and everything degrading gracefully.

## Resolution

Four new widgets in `app/Filament/Admin/Widgets`, discovered automatically by the admin panel's widget discovery; the stock `FilamentInfoWidget` was dropped and the account and beta warning widgets kept.

- **`PlatformKpisWidget`** (stats overview): Invested Youth, Invested Adults, Total Invested, Parents & Helpers, Total Administered, Active Warrants, and Recently Active (last hour, with last 24 hours in the description). Definitions follow the legacy admin dashboard exactly: invested youth are active users with an investiture date holding an active primary youth role (Meerkat, Cub, Scout, Rover, resolved by role name rather than the legacy hardcoded IDs), invested adults hold an active primary role whose type is adult leader and warranted, parents and helpers are the non-warranted adult leader types plus the Parent role, and warrants are active with an unexpired expiry date. All counts are cached for ten minutes (`Cache::remember`).
- **`AttentionWidget`**: one row per outstanding queue, each with a count badge linking to where it is actioned. Data-fix worklists are discovered from the DataFixes cluster (every `FindingsPage` subclass), so a new fix page appears here without touching the widget; pending AAM requests are the other queue, and moderation queues (tickets 016, 017, 019) land as extra rows in `queues()` later. Counts are cached for ten minutes because `findings()` runs live queries; the findings read path stays free of writes and logging. Rows with a zero count are hidden and an explicit all-clear message shows when nothing is outstanding.
- **`RecentLoginsWidget`** (table): the ten latest `admin_good_logons` rows with a source badge (Scouts Digital or Ssalute), each row linking to the member's BackOffice page when the username matches a member, and a header link to the full Logins report from ticket 021.
- **`RecentUpdatesWidget`** (table): the ten latest audit log entries (who, when, event, record as `Model (#id)`), reusing the shared `HasAuditDisplay` trait so the row action opens the same audit detail view used everywhere else.

Supporting changes:

- `RecordSuccessfulLogin` (ticket 021's listener) now also updates `system_users.lastLoginDate` via a quiet query update (no model events, so no audit noise), which powers the Recently Active KPI for Ssalute sessions; legacy already maintains the column for its own logins.
- `RunSystemFixes::fixes()` replaces the private `$fixes` property so the fixes registry has one public source; the existing pinning test now consumes it directly.
- Migration `2026_09_01_153849_add_date_index_to_admin_good_logons_table` adds an index on `admin_good_logons.date`: both the dashboard widget and the ticket 021 Logins report sort ~925k rows by that column, which previously had no index. Run on the local database.

Branch: `feature/023-backoffice-dashboard`, cut from `feature/021-backoffice-admin-reports` because the login widgets and Recently Active KPI build on that ticket's recording listener and report.

## Verification

- `php artisan test --compact tests/Feature/Filament/BackofficeDashboardTest.php`: 9 tests, 23 assertions, all passing. Coverage: dashboard access control, the KPI definitions against seeded fixture data (invested versus uninvested youth, warranted versus helper versus parent roles, expired versus current warrants, last hour versus last day activity), KPI widget rendering, the attention widget with outstanding queues and with the all-clear state, the recent logins widget, the recent updates widget on an audited change, and `lastLoginDate` refresh on login.
- Full suite on 2026-09-01: 658 passed, 3 skipped (pre existing skips) on this branch, zero failures. Re-derive with `php artisan test --compact`.
- Mutation checks: dropping the investiture date constraint from the invested youth count reds `kpis_follow_the_legacy_definitions`; removing the zero-count filter from the attention widget reds `attention_widget_shows_the_all_clear_when_nothing_is_outstanding`. Both applied, observed red, reverted.
- `vendor/bin/duster fix --dirty` run.
- Not verified: visual appearance in a browser, and KPI query timings against production volumes (the counts are cached, so even a slow cold compute runs at most once per ten minutes).

## Risk assessment

- KPI and attention counts can be up to ten minutes stale by design. The cache keys are `backoffice.dashboard.kpis` and `backoffice.dashboard.attention` if an admin ever needs them flushed.
- Youth roles are resolved by type name (Meerkat, Cub, Scout, Rover). Renaming those system user types would silently empty the invested youth count; the legacy dashboard had the same fragility via hardcoded IDs 15 to 18.
- The recent logins widget joins `admin_good_logons.username` to `system_users.username`. If usernames are ever reused across members the link could point at the wrong member; today the username is the unique login identifier.
- `lastLoginDate` is written with a direct query update that bypasses auditing intentionally. If auditing of logins is ever wanted, the login history tables already carry the record.
- The date index migration runs against a ~925k row production table; MySQL builds it online but the deploy will hold a metadata lock briefly.

## Decisions

- The legacy dashboard's bounce and PWA report entry points were not rebuilt, per the ticket notes (bad email remediation remains an open candidate ticket).
- Legacy KPI tiles also carried online program adoption, SD Lite usage and competition counts; these measure legacy-only features and were left out of the starting set. The ticket asks for the tile list to be reviewed with the product owner during the build, which has not happened; the shipped set is the ticket's starting list and adding or trimming tiles is a follow-up conversation, not a code change of any size.
- The attention area discovers data-fix worklists dynamically from the cluster rather than keeping its own registry, so the adding-a-data-fix flow needs no extra step for a new fix to reach the dashboard.
- The `FilamentInfoWidget` (Filament and Laravel version links) was removed as part of the modernisation; the account widget stays.

## Original ticket

Background: wiki/SD-Migration/Legacy-Navigation-Inventory, dashboards nav (Admin Dashboard)
Panel: backoffice

### Goal

The BackOffice dashboard is currently the stock Filament page with only the account, Filament info and beta warning widgets. The legacy admin dashboard gives the system administrator platform KPI tiles (invested youth, invested adults, active warrants, total invested, parents and helpers, total administered, users active in the last hours) plus pending-action notices. Rebuild that idea here, modernised: KPIs, recent activity tables, and a place that highlights anything in the BackOffice needing attention.

### Requirements

- KPI stat widgets, taking the legacy tile set as the starting list: invested youth, invested adults, active warrants, parents and helpers, overall totals, and recently active users. Review the list with the product owner during the build, the legacy set is a guide, not a spec.
- Recent activity tables: most recent logins, most recent record updates (the audit log already captures changes), and similar. Each row links through to the record or its BackOffice page.
- An attention area: outstanding data-fix findings per fix with counts, linking to the DataFixes worklist pages, plus other actionable queues as they exist (for example pending AAM requests). Built to take future queues, such as the moderation tickets 016, 017 and 019, without redesign.
- Performance: the legacy dashboard recomputed every count with live queries on each page load, and the data-fix findings are also computed live. Cache or throttle expensive widgets so the dashboard stays fast, and keep the findings read path free of writes and logging as the DataFixes convention requires.
- Widgets should degrade gracefully when a source is empty or its feature is disabled.

### Notes

- The legacy admin dashboard is also the only entry point to its bounce and PWA reports. Those are separate decisions (bad email remediation is still an open candidate ticket) and are not part of this dashboard build.
- Login and activity widgets share the data question in ticket 021: make sure Ssalute sessions are recorded, not just legacy ones.

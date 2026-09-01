# BackOffice Admin Reports Section

**Priority when actioned:** p2

## Synopsis

Legacy gives the system administrator an Admin Reports menu; the BackOffice had no reports section at all. Create one, port only the three reports we actually want (Most Active Users, Logins, No Primary Roles), make sure Ssalute sessions are recorded in the underlying data rather than only legacy sessions, and leave the section easy to extend with future metric and tracking reports.

## Resolution

New `AdminReports` Filament cluster (`app/Filament/Admin/Clusters/AdminReports`, route `/backoffice/admin-reports`, System navigation group beside Lookup Tables and Data Fixes). Three reports inside:

- **Most Active Users** (`Pages/MostActiveUsers.php`): a table page ranking users by activity in `system_user_logging` over a selectable window (7, 30, 90, 365 days, default 30), showing pages viewed (excluding `/ajax/` noise, matching the legacy report), logins, and last activity, each row linking to the user's BackOffice page. The legacy report looped one query per user over the whole table; this is a single aggregated join.
- **Logins** (`Resources/GoodLogons`): a read only resource on `AdminGoodLogon` (`admin_good_logons`), newest first, searchable by username and IP, filterable by date range and source (Scouts Digital or Ssalute), with role, group, district and region shown as `Name (#id)`. Create, edit and delete are disabled.
- **No Primary Roles** (`Pages/NoPrimaryRoles.php`): active members with no active primary role, with their active role count, home area columns and a header link to the DataFixes Primary Roles worklist.

Login recording: Ssalute logins previously landed nowhere (the Holding Zone Filament login and the Scouts Digital SSO controller both authenticate via the session guard without touching the legacy tables). `App\Listeners\RecordSuccessfulLogin` now listens to `Illuminate\Auth\Events\Login` and writes what the legacy logon handler writes: a row in `admin_good_logons` (scoped by the user's active primary role) and a `/logon-action` row in `system_user_logging`. Failures are swallowed with a warning log so login can never break on history bookkeeping. Factories added for `AdminGoodLogon` and `SystemUserLogging`.

Branch: `feature/021-backoffice-admin-reports`, cut from master (independent of tickets 013/014).

## Verification

- `php artisan test --compact tests/Feature/Filament/AdminReportsClusterTest.php`: 14 tests, 30 assertions, all passing. Coverage: access control for all three reports (super admin, regular user, guest), login listing, date filter and username search, both history rows written on `Auth::login` with primary role scoping, recording for a user with no roles, the most active ranking (window exclusion, `/ajax/` exclusion, page and login counts), and the no primary role definition (active user without an active primary shown, user with a primary or inactive user hidden).
- Full suite on 2026-09-01: 649 passed, 3 skipped (pre existing skips) on this branch, zero failures. Re-derive with `php artisan test --compact`.
- Mutation checks: changing the listener's `fromSD` value reds `a_successful_login_is_recorded_in_both_history_tables`; dropping the window constraint from the most active query reds `most_active_users_ranks_by_page_views_inside_the_window`. Both applied, observed red, reverted.
- `vendor/bin/duster fix --dirty` run.
- Not verified: appearance in a browser, and behaviour against the production `admin_good_logons` volume (~925k rows measured on the 2026-09-01 sync; the table is indexed by primary key only, so date sorting relies on MySQL filesort over the full table, see Risk assessment). Note that `rouxt:sync` anonymizes `admin_good_logons.username`, so local rows show `redacted`.

## Risk assessment

- `admin_good_logons` has no index on `date` or `username`; the report defaults to sorting ~925k rows by date. If the page is slow in production, add an index on `date` via a migration (new roll forward migration, never editing an old one).
- The login listener fires for every guard login. Filament Holding Zone logins and the SSO controller both go through it; `actingAs` in tests does not fire the event. If a future feature logs users in programmatically for internal reasons, those logins will be recorded as real ones.
- Most Active Users counts only what lands in `system_user_logging`. Legacy writes every page view; Ssalute writes one row per login. Ranking therefore skews towards legacy usage until either legacy winds down or Ssalute page view recording is added.
- The listener resolves the primary role with one extra query per login; negligible load.

## Decisions

- No Primary Roles stays a separate report rather than folding into the DataFixes Primary Roles worklist, because the two answer different questions. The nightly fix repairs users who hold active roles but a broken primary flag, and explicitly allows a user with no active roles to have no primary. The report lists exactly those leftover members (plus anything the fix has not yet swept), so it links to the worklist instead of duplicating it.
- Ssalute logins are marked `fromSD = 3` in `admin_good_logons`. Legacy data uses 2 exclusively (925,405 rows measured 2026-09-01), so 3 unambiguously identifies Ssalute sessions and the Source filter surfaces it.
- Ssalute page views are deliberately NOT recorded into `system_user_logging`. That would add a database write to every request for a report that Pulse largely supersedes; only logins are recorded, which keeps last activity and login counts alive as legacy winds down. If full parity is ever wanted, file a ticket for middleware based recording.
- The remaining legacy reports (disk usage, bad logons, forced logouts, pages not found, possible hacking, regions/districts/groups, challenges with roles) are not ported, as the ticket instructed.
- Extension path: a new report is either a page (`Pages/`) for computed tables or a read only resource (`Resources/`) for row backed ones, both inside the cluster; the shared `report.blade.php` view renders any `InteractsWithTable` page.

## Original ticket

Background: wiki/SD-Migration/Legacy-Navigation-Inventory, Admin Reports under the system administrator nav
Panel: backoffice

### Goal

Legacy gives the system administrator an Admin Reports menu (user disk usage, most active users, bad and good logons, regions/districts/groups, challenges with roles, no primary roles, forced logouts, pages not found). The BackOffice has no reports section at all. Create one, but port only the reports we actually want and leave room for new metric and tracking reports to land in the same section later.

### Requirements

- An Admin Reports section in the BackOffice (its own cluster or nav group under System).
- Port these three reports:
  - Most Active Users: activity ranking over recent user activity.
  - Logins: the successful logon history (model AdminGoodLogon), filterable by user and date.
  - No Primary Roles: users without a primary role.
- Check what actually records logins and activity for Ssalute panel sessions. Legacy writes these tables from its own session handling, so if Ssalute logins do not land in the same data, add recording via Laravel auth events, otherwise the reports only ever show legacy activity, and they will go quiet as legacy winds down.
- The DataFixes cluster already has a Primary Roles worklist backed by the nightly fix. Decide whether the No Primary Roles report links there instead of duplicating a second table over the same finding, and record the decision.
- The remaining legacy reports (disk usage, bad logons, forced logouts, pages not found, possible hacking, regions/districts/groups, challenges with roles) are deliberately not ported. Structure and area listings are covered by the Area cluster, role challenges by the data-fix worklists, and the security ones belong to framework auth and observability (Pulse, logs).

### Notes

- New metric and tracking reports are wanted in this section but are not yet defined. File them as their own tickets once specified; this ticket only needs to leave the section easy to extend.

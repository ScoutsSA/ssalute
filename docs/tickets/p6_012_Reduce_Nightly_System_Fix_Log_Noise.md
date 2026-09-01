# Reduce Nightly System Fix Log Noise

Module: console (app:system-fixes)
Panel: console

## Problem

The nightly `app:system-fixes` run dominates the production Laravel log to the point that real errors are hard to find. Across 2026-08-09 to 2026-09-01 the per row warnings account for the overwhelming majority of all log lines:

- `system_fix.youth_member_ids.conflict` from `EnsureYouthMemberIdsAreInSync`: roughly 4,250 warnings over the period, about 300 per night, re-logging the same unresolved conflict rows (mostly `advancement_scouts`) every single night.
- `system_fix.role_in_home_location.flagged` from `FlagUsersWithoutRoleInHomeLocation`: the same set of flagged users logged again each night, and each line carries the member's full name, which puts personal data into log files it does not need to be in.

These conflicts already have a proper human surface, the DataFixes pages in the BackOffice, plus a Slack count. The per row nightly WARNING adds nothing on top of that: nobody reads 300 identical warnings, and they bury the handful of genuine production errors (this ticket came out of a log review where the real signal was five errors under thousands of these lines).

## Scope

- Change the per row logging in the affected fixes to a single summary line per fix per run (counts per table, plus a delta against the previous run if cheap to compute). The detailed rows are already available on the fix's findings page, so the log only needs to say how many and where to look.
- Stop logging member names. Identifiers (row id, user id) are enough to chase a record, matching how the Slack notification already carries only a count and a link.
- Keep genuinely actionable one-off events (a fix writing a correction, a fix failing) at their current verbosity, the target is the repeated per row findings noise only.
- Follow the conventions in the `adding-a-data-fix` skill when touching the fixes, and update that skill's guidance in the same commit if it currently prescribes the per row logging pattern.
- Counts above were measured from `storage/logs/production-logs/laravel-2026-08-*.log` on 2026-09-01, re-derive with a grep before relying on them.

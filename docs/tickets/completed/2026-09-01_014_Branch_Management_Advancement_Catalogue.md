# Branch Management: Advancement Catalogue

**Priority when actioned:** p2

## Synopsis

Add the Advancement area to the Branch Management structure delivered by ticket 013: manage each branch's advancement scheme (levels and the parts and tasks beneath them) with the same add, edit, deactivate, reorder and viewing treatment as badges, starting from an inventory of the model families, and resolve the duplicate edit path in the LookupTables Advancement Levels group.

## Resolution

Added `Resources/Advancement` to the `BranchManagement` cluster: one Advancement resource per branch on the branch's levels model, appearing beside Badges inside each branch's navigation group. As with badges, an abstract `BaseAdvancementResource` holds the shared level form, infolist and table (reorderable by `position`, activate/deactivate soft toggles reused from the badges table, legacy HTML handling), and the concrete resources add the branch specific colour fields and their relation managers.

Inventory of the model families, and what each tier means (verified against the legacy source and live data):

- `SystemAdvancement{Branch}Level` (`*_levels`): the levels, position ordered, with highLevel, investment, active flags. All four branches. Managed here.
- Meerkats: `system_advancement_meerkats_second` holds tasks directly under a level (27 rows). Managed as the Tasks relation manager. `system_advancement_meerkats_third` and `system_advancement_meerkats_challenges` are both empty and unused by the current legacy screens; not managed.
- Cubs: three tiers. `system_advancement_cubs_second` holds areas under a level (80 rows, no active column), `system_advancement_cubs_third` holds tasks (178 rows) linked to a level and an area, with an optional challenge name drawn from `system_advancement_cubs_challenges` (10 rows). Areas and Tasks are two relation managers on the level view page; the challenge is a select on the task form sourced from the challenges table, which itself is not editable here.
- Scouts: two tiers. `system_advancement_scouts_second` holds tasks (225 rows) with an optional Entsha theme (`system_advancement_scouts_second_entsha_themes`, 6 rows) and camping, badge and PGA task flags. Managed as the Tasks relation manager with a theme select. `system_advancement_scouts_second_entsha_badges` (75 rows) is a two way auto sign-off link between a Scout advancement task and a Scout badge; not managed here (see Decisions).
- Rovers: two tiers. `system_advancement_rovers_second` holds tasks (34 rows). Managed. `system_advancement_rovers_challenges` (7 rows) is a small lookup not referenced by the second tier; not managed.

Model additions: `tasks()` HasMany on the four level models, `areas()` on the Cub level, `entshaTheme()` and `entshaBadges()` on the Scout second model. Factories added for the second and third tier models, the Cub challenges and the Entsha themes.

The four bare Advancement Levels editors in the LookupTables cluster (`CubLevels`, `MeerkatLevels`, `ScoutLevels`, `RoverLevels`) were removed, and their tests pruned from `SettingsReferenceDataTest`, so Branch Management is the single edit path.

Branch: `feature/014-branch-management-advancement-catalogue`, cut from the ticket 013 branch (`feature/013-branch-management-badge-catalogue`) because it builds on the cluster delivered there.

## Verification

- `php artisan test --compact tests/Feature/Filament/BranchManagementAdvancementTest.php`: 24 tests, 87 assertions, all passing. Coverage: access control for all four resources, level listing, create with auto appended position, edit, deactivate and activate, level drag reorder, task creation for every branch (Meerkat task, Cub area plus task with area and challenge selects, Scout task with Entsha theme, Rover task), the Cub areas manager exposing no deactivate action, awarded advancement records untouched by catalogue deactivation, and relation manager registration.
- Full suite on 2026-09-01: 673 passed, 3 skipped (pre existing skips), zero failures. Re-derive with `php artisan test --compact`.
- Mutation checks: zeroing the position append logic in the base relation manager reds `meerkat_tasks_can_be_created_with_appended_position`; removing `->reorderable('position')` from the levels table reds `levels_can_be_reordered`. Both applied, observed red, reverted.
- `vendor/bin/duster fix --dirty` run.
- Not verified: visual appearance in a browser; row counts quoted above were measured on the 2026-09-01 synced database.

## Risk assessment

- Same concurrency caveat as ticket 013: no foreign keys, and the legacy system writes these tables too.
- Level and task reordering uses Filament's bulk position update, which bypasses model events, so reorders produce no audit log entries.
- The advancement level tables carry no created/modified columns, so level edits rely on the audit log alone for history.
- Cub areas cannot be deactivated because `system_advancement_cubs_second` has no active column; a mis-created area can only be edited or reordered. Adding a column is a schema change on a legacy shared table and was deliberately not done.
- The legacy admin screens only display levels with `highLevel = 1` and `programType` 1 (2 for Scouts); this catalogue shows every row so the admin can see and repair oddities, with programType as a hidden by default column. New levels rely on the database defaults for `programType` and `countryID`, matching what the legacy insert paths do.

## Decisions

- The Advancement Levels group in LookupTables was removed rather than absorbed unchanged. Branch Management supersedes it with reordering, view pages and the tier management the lookup editors lacked. Recorded in the feature spec.
- Scout Entsha badge links are inventoried but not manageable in this UI. They hang off an individual task, which is a relation manager row rather than a page, so managing them cleanly needs either a task view page or a dedicated action. The badge side equivalent (ticket 013's Auto Sign-Off Tasks) covers the Scout badge to badge case; if link management is wanted from the advancement side, file a follow-up ticket.
- The Cub challenges, Rover challenges and Entsha themes lookup tables are not editable in this UI. They are tiny, near static reference lists; the Cub challenge and Entsha theme values are consumed through selects on the task forms.
- `theme` on the Meerkat, Cub third and Rover task tables is vestigial (always 0 in data, unused by legacy display) and is not exposed on forms.
- The vestigial `advancementArea` varchar columns on the Meerkat and Cub second tables (null in every row) are not exposed.

## Original ticket

Module: 04-advancements-badges
Background: wiki/SD-Migration/Legacy-Navigation-Inventory, system administrator nav
Panel: backoffice

### Goal

Add the Advancement area to the Branch Management structure delivered by ticket 013: manage each branch's advancement scheme (the levels and the parts and tasks beneath them) with the same add, edit, deactivate, reorder and pleasant viewing treatment as badges.

### Requirements

- Advancement per branch inside Branch Management, alongside Badges.
- The catalogue spans several model families per branch: SystemAdvancement{Branch}Level plus the Second and Third tiers, Challenge tables for some branches, and the Scout Entsha tables. Start with an inventory of these models and record which are managed here and what each tier means functionally.
- Levels, and the parts and tasks beneath them: list, view, add, edit, deactivate, reorder, following ticket 013's rules (soft deactivation only, ordering via reorderable tables, awarded advancement records untouched by catalogue edits).
- The LookupTables cluster currently exposes the four advancement level tables as bare lookup editors (the Advancement Levels group). Decide whether those editors are absorbed into Branch Management or removed, so there are not two competing edit paths, and record the decision.

### Notes

- Depends on ticket 013 for the Branch Management structure.
- The legacy admin screens for the advancement catalogue were partly non-functional, so treat this as a design task informed by the data model, not a port of legacy screens.

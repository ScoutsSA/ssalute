# Branch Management: Badge Catalogue

**Priority when actioned:** p2

## Synopsis

The BackOffice had no badge catalogue management. The ticket asked for a single Branch Management entry point (branch first, then management areas within the branch) delivering the Badges area: per branch listing, viewing, adding, editing, deactivating and reordering of badges and their tasks, with soft deactivation only and awarded records never touched. Ticket 014 adds the Advancement area to the same structure.

## Resolution

Built a new `BranchManagement` Filament cluster in the BackOffice (`app/Filament/Admin/Clusters/BranchManagement`, route `/backoffice/branch-management`, navigation group Youth). Inside the cluster, each branch (Meerkats, Cubs, Scouts, Rovers) is a sub navigation group holding its Badges resource, giving the branch first, area second structure the ticket asked for. Ticket 014 slots its Advancement resources into the same groups.

The four branches share one UI. `Resources/Badges/BaseBadgeResource.php` is an abstract resource holding the shared form (`Schemas/BadgeForm.php`), infolist (`Schemas/BadgeInfolist.php`), table (`Tables/BadgesTable.php`) and the `BadgeTasksRelationManager`. The four concrete resources (`MeerkatBadgeResource`, `CubBadgeResource`, `ScoutBadgeResource`, `RoverBadgeResource`) are thin subclasses that bind the model, slug, labels, navigation group and pages (List and View per branch).

Key behaviours:

- Badge lists default to grouping by badge `type` (collapsible), ordered by name, with an active TernaryFilter defaulted to active, matching the legacy listing (legacy orders by type then name and shows active only).
- Create and edit run in modals; the view page shows the infolist plus the Tasks relation manager.
- Tasks are reorderable by drag (`->reorderable('position')`), and a newly created task is appended at max position plus one within its badge.
- Deactivation everywhere is an activate/deactivate action pair toggling the `active` flag with confirmation. No delete action is offered anywhere in the cluster.
- Badge names, notes, headings and tasks run through `LegacyHtmlService` (normalize on edit, decode/preview on display) because the legacy data carries double encoded HTML entities.
- Scout badges get a second relation manager, `AutoSignOffTasksRelationManager`, managing `system_badge_scouts_to_badge`.
- Model additions: `tasks()` HasMany on the four `SystemBadge{Branch}First` models, `toBadgeLinks()` on `SystemBadgeScoutsFirst`. Factories added for all eight catalogue models plus the Scout link model.
- The beta banner render hook in `AdminPanelProvider` now covers `backoffice/branch-management*`.

Branch: `feature/013-branch-management-badge-catalogue`.

## Verification

- `php artisan test --compact tests/Feature/Filament/BranchManagementClusterTest.php`: 27 tests, 91 assertions, all passing. Coverage: access control for all four resources (super admin, regular user, guest), listing, create, edit, deactivate and activate actions, task creation with auto appended position, drag reorder persistence, task deactivation, awarded records untouched by catalogue deactivation (a `badges_scouts` row keeps its references and active flag), and Scout auto sign-off link create and deactivate.
- Full suite on 2026-09-01: 662 passed, 3 skipped (pre existing skips), zero failures. Re-derive with `php artisan test --compact`.
- Mutation check: changing the deactivate action to a hard delete reds `deactivate_action_toggles_the_active_flag_without_deleting`; removing the position append logic reds `creating_a_task_appends_it_to_the_end_of_the_badge`. Both mutations were applied, observed red, and reverted.
- `vendor/bin/duster fix --dirty` run.
- Not verified: visual appearance in a browser, and behaviour against production data volumes (the ~1200 row Scout task table paginates at 25 so no concern is expected).

## Risk assessment

- The catalogue tables have no foreign keys and are written by the legacy system as well. A legacy admin editing the same rows concurrently will not conflict at the database level; last write wins.
- Table reordering uses Filament's bulk position update, which bypasses Eloquent model events, so reorders do not produce audit log entries (creates, edits and the activate/deactivate actions do).
- The badge `type` list in `BadgeForm::TYPES` is the union of the legacy form options and values observed in data (adds Awareness and Rover Award). Legacy accepts free typed values on some paths, so an unforeseen type would display fine but the create form constrains to the known list.
- `countryID` and `programType` rely on their database defaults (196 and 1) for new rows, matching the legacy inserts. The columns are visible as hidden by default table columns but are not editable.
- Awarded record safety rests on catalogue actions only ever updating the `active` flag on the catalogue row itself; the test suite pins this.

## Decisions

- The ticket claimed ordering exists at both levels. The schema and legacy code disagree for badges: no `system_badge_*_first` table has a position column, and legacy lists badges ordered by type then name. Badges therefore get type grouping and name ordering rather than a reorderable table; only tasks are reorderable.
- Scout linking table inventory: `system_badge_scouts_to_badge` is the only extra Scout badge table. It links a badge to tasks inside other badges; when the badge is fully signed off, legacy auto signs off the linked tasks (see `group-badge-badge.php` in the legacy source). It IS managed here, on the Scout badge view page, as the Auto Sign-Off Tasks relation manager. The Entsha tables are advancement side and belong to ticket 014.
- Placed the cluster in the Youth navigation group beside Advancements, since the catalogue defines the youth program. Navigation sorts 10/20/30/40 leave room for ticket 014's Advancement resources inside each branch group.
- Sub navigation uses sidebar groups (no `SubNavigationPosition::Top`) so the branch grouping reads as a tree, unlike the tabbed Advancements cluster.
- Removed the unused `requirements()` relation on `SystemBadgeCubsFirst` (same target as the new `tasks()` relation, referenced nowhere) so the catalogue has one relation name across all four branches.

## Original ticket

Module: 04-advancements-badges
Background: wiki/SD-Migration/Legacy-Navigation-Inventory, Admin Badges under the system administrator nav
Panel: backoffice

### Goal

The legacy system administrator maintains the badge catalogue per branch (Meerkats, Cubs, Scouts, Rovers): the badges themselves and the tasks that make up each badge. The BackOffice currently has no badge catalogue management at all. Build it, entered through a single Branch Management area where the admin picks the branch first, then a management area within that branch. This ticket delivers the Branch Management structure and its Badges area. Ticket 014 adds the Advancement area to the same structure.

### Requirements

- One Branch Management entry point in the BackOffice (page or cluster). Branch first (Meerkat, Cub, Scout, Rover), then the management areas within that branch. Badges is the first area, Advancement (ticket 014) is the second.
- Badges per branch: list, view, add, edit, deactivate, with a pleasant browsing view. The catalogue models are the per-branch pairs SystemBadge{Branch}First (badges) and SystemBadge{Branch}Second (tasks).
- Badge tasks: within a badge, list, add, edit, deactivate, reorder.
- Ordering exists at both levels: badges are ordered within their branch, and tasks are ordered within their badge. Use reorderable tables rather than exposing raw position integers.
- Deactivation is a soft toggle on the active flag, never a hard delete. Awarded badge records (Badges{Branch} plus their documents and photos) reference catalogue rows, so catalogue edits, deactivation and reordering must never touch or orphan awarded records.
- The Scout branch carries extra linking tables (for example SystemBadgeScoutsToBadge). Inventory these during implementation and record what they do and whether they are managed here.

### Notes

- The four branches are parallel table families with near identical shapes. Prefer one shared UI over four copied resources.

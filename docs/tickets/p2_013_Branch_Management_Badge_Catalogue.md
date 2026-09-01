# Branch Management: Badge Catalogue

Module: 04-advancements-badges
Background: wiki/SD-Migration/Legacy-Navigation-Inventory, Admin Badges under the system administrator nav
Panel: backoffice

## Goal

The legacy system administrator maintains the badge catalogue per branch (Meerkats, Cubs, Scouts, Rovers): the badges themselves and the tasks that make up each badge. The BackOffice currently has no badge catalogue management at all. Build it, entered through a single Branch Management area where the admin picks the branch first, then a management area within that branch. This ticket delivers the Branch Management structure and its Badges area. Ticket 014 adds the Advancement area to the same structure.

## Requirements

- One Branch Management entry point in the BackOffice (page or cluster). Branch first (Meerkat, Cub, Scout, Rover), then the management areas within that branch. Badges is the first area, Advancement (ticket 014) is the second.
- Badges per branch: list, view, add, edit, deactivate, with a pleasant browsing view. The catalogue models are the per-branch pairs SystemBadge{Branch}First (badges) and SystemBadge{Branch}Second (tasks).
- Badge tasks: within a badge, list, add, edit, deactivate, reorder.
- Ordering exists at both levels: badges are ordered within their branch, and tasks are ordered within their badge. Use reorderable tables rather than exposing raw position integers.
- Deactivation is a soft toggle on the active flag, never a hard delete. Awarded badge records (Badges{Branch} plus their documents and photos) reference catalogue rows, so catalogue edits, deactivation and reordering must never touch or orphan awarded records.
- The Scout branch carries extra linking tables (for example SystemBadgeScoutsToBadge). Inventory these during implementation and record what they do and whether they are managed here.

## Notes

- The four branches are parallel table families with near identical shapes. Prefer one shared UI over four copied resources.

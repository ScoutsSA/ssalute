# Role Assignment Create Fails When Scope Left As None

Module: 02-adult-management
Panel: backoffice

## Problem

Creating (and likely editing) a role attachment from the BackOffice user page throws a `QueryException` whenever Region, District or Group is left as "None". The insert into `system_users_other_roles` sends `null` for the unselected scope columns, but the legacy schema declares `regionID`, `districtID` and `groupID` as `int NOT NULL DEFAULT 0`. The legacy convention for "no scope at this level" is `0`, not `null`.

Seen in production logs:

- 2026-09-01 13:13 to 13:15, three attempts by user #4073 to attach role #376 to user #10845 with no region selected (`Column 'regionID' cannot be null`). The admin retried three times and gave up, so this is actively blocking role administration.
- 2026-08-13 14:57, user #12976 attaching role #289 (Assistant Leader Trainer: National Adult Leader Training Team) to user #1493 with a region but no district (`Column 'districtID' cannot be null`).

Any role scoped at national level (all three "None") or region level (district and group "None") is impossible to create through this form. The stack trace goes through `Filament\Actions\CreateAction` on the user's role attachments relation manager.

## Where

- `app/Filament/Admin/Resources/Users/RelationManagers/UserRoleAttachmentsRelationManager.php`. The `regionID`, `districtID` and `groupID` selects use `->placeholder('None')` with no requirement, and `mutateFormDataUsing()` on the `CreateAction` only sets `created` and `createdby`, so nulls pass straight through to the insert. The `EditAction` has no mutation at all, so clearing a scope on edit should fail the same way.
- Check `RoleRoleAttachmentsRelationManager` (Roles resource) and any other surface that writes `system_users_other_roles` for the same gap.

## Scope

- Coerce null scope values to `0` on create and edit. Prefer doing it once on the `UserRole` model (mutators or a saving hook) rather than per action, so every write path is covered.
- Display side must keep treating `0` as "no scope" (the table columns already use `->placeholder('-')`, verify the infolist and select hydration handle `0` correctly, a select hydrated with `0` must show "None" rather than an invalid option).
- Consider whether some role types should require a scope level (a group level role with no group is probably bad data), but do not block this fix on that; if validation rules per role level are wanted, split them into a follow-up ticket.
- Feature test: create a role attachment with all scopes left empty and assert the row lands with zeros; same for edit.

Existing rows confirm the `0` convention. As of the 2026-08-22 sync copy, `system_users_other_roles` held 96,646 rows of which 1,184 have `regionID = 0`, 2,521 have `districtID = 0` and 2,164 have `groupID = 0`. Re-derive against a current sync before relying on these numbers.

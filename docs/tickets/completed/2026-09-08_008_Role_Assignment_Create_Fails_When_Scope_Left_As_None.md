# Role Assignment Create Fails When Scope Left As None

**Priority when actioned:** p3

## Synopsis

Attaching a role to a user from the BackOffice user page threw a `QueryException` whenever Region, District or Group was left as "None". Filament posted `null` for the unselected scope, and the legacy `system_users_other_roles` table declares those columns `int NOT NULL DEFAULT 0`. Any national or regional role was impossible to create through the form. The ticket asked for the nulls to be coerced to the legacy `0` convention, preferably once on the model so every write path is covered, for the edit form to keep showing "None" for a stored `0`, and for feature tests that observe both.

Picked up on 2026-09-08 after a fresh production occurrence at 12:17 that day: user #4073 attaching role #376 (National Tech Team, a national appointment role) to user #65496 with every scope left as "None" (`Column 'regionID' cannot be null`). That is the same admin and role as the 2026-09-01 attempts listed in the original ticket, so the admin has been blocked on this for a week.

## Resolution

- `app/Models/SystemUsersOtherRole.php`. A `saving` hook coerces a `null` in any legacy `NOT NULL` column (`countryID`, `regionID`, `districtID`, `groupID`, `roleID`, `defaultRole`, the five `action*` scope columns, `retired`, `resigned`, `suspended`, `multiID`) to the value Scouts Digital writes for "not set": `0`, or `SystemUsersOtherRole::DEFAULT_COUNTRY_ID` (196) for the country. Only attributes that are present and null are touched, so a column the caller never set still takes its database default. On create the hook also mirrors each scope column into its `action*` twin (`regionID` into `actionRegionID` and so on, country into `actionCountryID`), unless the caller set the `action*` value explicitly. This is what every legacy insert does (`ams-adult-role-add`, `ams-adult-edit`, `group-youth-manage`) and what `hasValidWarrantOrAppointment()` and the legacy duplicate-role checks read, so without it a role created from the BackOffice would insert but never match a warrant.
- `app/Filament/Admin/Resources/Users/RelationManagers/UserRoleAttachmentsRelationManager.php`. The three scope selects hydrate a stored `0` as `null` via `formatStateUsing`, so the edit form shows the "None" placeholder rather than an option that does not exist. Create and edit both go through the model hook, so no per-action mutation was needed beyond the existing `created`/`createdby` one.
- `docs/features/01-adult-member-system/technical.md`. Documented the zero convention, the hook and the `action*` mirroring under the `SystemUsersOtherRole` model.
- `tests/Feature/Filament/UserRoleAttachmentsRelationManagerTest.php`. New feature tests, see Verification.

`RoleRoleAttachmentsRelationManager` (Roles resource) and the Area cluster's `RoleAttachmentsRelationManager` were checked as the ticket asked: both are view only and never write `system_users_other_roles`, so there was no second gap to close. The Member panel's `UserRolesRelationManager` only toggles `defaultRole`. The Holding Zone and `SystemUser::roles()->attach()` go through the same pivot model and therefore the same hook.

## Verification

Run on 2026-09-08 against the MySQL test database, which loads the real legacy schema dump (`database/schema/sd-core-schema.sql`) so the `NOT NULL` constraints are the production ones.

- `tests/Feature/Filament/UserRoleAttachmentsRelationManagerTest.php`, six tests, green:
  - national role created through the relation manager with every scope "None" lands with zeros and country 196, attributed to the acting admin;
  - regional role stores `0` for district and group and mirrors all four `action*` scope columns;
  - clearing every scope on edit stores zeros;
  - the edit form hydrates a stored `0` district and group as `null` (asserted with `assertNull`, because `assertSchemaStateSet` compares `0 == null` loosely and passed under mutation until tightened);
  - the model coerces nulls on a plain factory create, covering non-Filament write paths;
  - explicit `action*` values are not overwritten by the mirroring.
- Mutation check, each restored afterwards: removing the coercion call reds four tests with the original `QueryException`; removing the mirroring reds the regional test; removing `formatStateUsing` reds the hydration test.
- Related suites green: `BackofficeEditAuditTest`, `Member/WarrantAccessTest`, `UserLifecycleActionsTest`, `MemberPanelTest`, `Services/MergeUsersServiceTest`, `Auditing/AuditingTest` (59 tests).
- Full suite green on 2026-09-08: 729 passed, 3 skipped. Re-derive with `php artisan test --compact`, do not trust this line.
- `vendor/bin/duster fix --dirty` run.
- Not verified: the fix on production. The failing insert has not been retried there, and the admin's role #376 attachment for user #65496 still does not exist as of the 2026-09-08 log pull.

## Risk assessment

- The `action*` mirroring changes what a factory-created attachment looks like in tests (`actionCountryID` is now 196 rather than the database default 0). `AmsWarrantInfoFactory::forRoleAttachment()` reads the attachment's in-memory values, so warrant tests still line up; the warrant suite was run to confirm. Any future test that inserts a warrant with hard-coded `countryID 0` against a factory attachment will now miss, which is the correct behaviour but a change.
- The hook only mirrors on create. Editing a scope in the BackOffice does not update the `action*` twin, which matches legacy: `ams-adult-edit` only ever rewrites `roleID` and notes on an existing row and keys the update on `actionGroupID`. If the BackOffice edit form is later used to move a role between groups, that will need a deliberate decision about the `action*` side. Deferred, see Decisions.
- `system_users_other_roles` has no foreign keys and is written by the legacy system as well, so rows with a mismatched `action*` scope already exist (as of the 2026-09-07 sync copy, 88 of the roughly 13,955 rows created since 2025-01-01 differ between a scope column and its twin, re-derive before relying on it). Nothing here repairs those.
- Coercion is silent: a form that posts null for `roleID` would now insert `roleID 0` instead of failing. The BackOffice select is `required`, so that cannot happen from the form, but a programmatic caller gets no error.

## Decisions

- Coercion lives on the model, not the action, as the ticket preferred, so the Holding Zone, `attach()` and future forms are covered without remembering to add a mutation.
- The `action*` mirroring was added even though the ticket did not ask for it. Without it the fix would make the insert succeed but produce a row the warrant middleware and the legacy duplicate checks cannot see, which is a worse failure than the exception because it is silent. Read the legacy source to confirm the convention before adding it.
- Per-role-level scope validation (a group role with no group, a national role with a group) was not added, as the ticket allowed. It is small and worth doing, so it is filed as ticket 028 (`p6_028_Validate_Role_Attachment_Scope_Against_Role_Level.md`), which also covers whether an edit that changes the scope should update the `action*` twin.
- The hydration fix is `formatStateUsing` on the field rather than `mutateRecordDataUsing` on the `EditAction`, so it travels with the field if the form is ever reused.

## Original ticket

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

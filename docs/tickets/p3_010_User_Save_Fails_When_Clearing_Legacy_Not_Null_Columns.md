# User Save Fails When Clearing Legacy Not Null Columns

Module: 02-adult-management
Panel: backoffice

## Problem

Saving a user from the BackOffice edit form throws a `QueryException` when a field backed by a legacy `NOT NULL` column is left empty. Filament sends `null` for an empty `TextInput`, and MySQL rejects the update.

Seen in production on 2026-08-19 18:11 (two occurrences, user #12976 editing user #11639): `Column 'SANJamb2017Role' cannot be null`. That column is `varchar(3) NOT NULL DEFAULT '0'` on `system_users`. The form declares it as a plain optional `TextInput` (`app/Filament/Admin/Resources/Users/Schemas/UserForm.php:499`), so any save with that field empty fails, which blocks the entire user edit, not just the one field.

This is a class of bug, not a single field. `system_users` has 33 `NOT NULL` columns (measured 2026-09-01 against the 2026-08-22 sync copy, re-derive from `information_schema` before relying on it). Any of them that appears in `UserForm` as an optional input without a null coercion is a save that fails only when an admin happens to clear it, which is why it surfaces rarely and looks random.

## Scope

- Audit every field in `UserForm` against the `system_users` schema. For each `NOT NULL` column, either coerce `null` to the column default on save (mutator on `SystemUser`, or `formatStateUsing`/`dehydrateStateUsing` pairs) or mark the input required if empty is genuinely invalid.
- Prefer model level coercion so the Holding Zone and any other write path get the same protection, matching the approach ticket 008 takes for `system_users_other_roles` scope columns.
- Keep the read side friendly: a stored `'0'` in `SANJamb2017Role` style columns should render as empty rather than a literal `0` where that is the legacy "not set" convention. Check the legacy source for the semantics before assuming.
- Feature test: save the user edit form with the affected fields cleared and assert it persists without error. Include at least one assertion on the stored value so the coercion is observable.

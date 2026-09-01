# Role Members Table Search Crashes On User Name

Module: 02-adult-management
Panel: backoffice

## Problem

Typing anything into the search box on the role members table (the role attachments relation manager on the Roles resource) throws a 500. The generated SQL is:

```
... and (`id` like %term% or `userID` like %term% or exists (
    select * from `system_users`
    where `system_users_other_roles`.`userID` = `system_users`.`id`
    and `name` like %term%))
```

`system_users` has no `name` column. `SystemUser::name()` is an Eloquent `Attribute` accessor (`app/Models/SystemUser.php:501`), so `TextColumn::make('user.name')->searchable()` compiles to a `where` on a column that does not exist and MySQL rejects it (`SQLSTATE[42S22] Unknown column 'name'`).

Seen in production on 2026-08-13 15:06 (two occurrences, user #4073 searching "FG" on role #289). The whole table render fails, not just the search, so the page is unusable until the search is cleared.

## Where

- `app/Filament/Admin/Resources/Roles/RelationManagers/RoleRoleAttachmentsRelationManager.php`. The `user.name` column is declared `->searchable()` around line 117, and `->recordTitleAttribute('name')` (line 105) also points at a column that does not exist on `system_users_other_roles`.

## Scope

- Make the user column searchable against real columns, `->searchable(['firstname', 'surname'])` style against the actual `system_users` name columns (check what the `name()` accessor concatenates and mirror it), or drop `searchable()` from that column if the ID search is considered enough.
- Fix or remove the `recordTitleAttribute('name')` so record titles (used in action modal headings and notifications) do not reference a missing column.
- Audit the other relation managers and tables for `->searchable()` on accessor-backed attributes (`user.name`, `createdBy.name`, `modifiedBy.name` and similar) since any of them will fail the same way the moment they are searchable.
- Feature test: render the relation manager, search for a member by part of their real name, assert matching records are returned and no exception is thrown.

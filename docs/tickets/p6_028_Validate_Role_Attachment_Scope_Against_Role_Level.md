# Validate Role Attachment Scope Against Role Level

Module: 01-adult-member-system
Panel: backoffice

Split from ticket 008, which fixed the `NOT NULL` failure when a scope is left as "None" but deliberately did not add validation. Filed at p6 because nothing is blocked on it: the BackOffice form now saves, and the legacy system has never validated this either.

## Problem

The BackOffice role attachment form (`UserRoleAttachmentsRelationManager`) accepts any combination of role type and scope. A group level role with no group, or a national role with a group, saves without complaint and produces a row that the member panel tenant switcher labels oddly and that area scoped queries never find. Bad data of this shape already exists from the legacy system; the BackOffice should stop adding to it.

## Scope

- Validate the scope selects against the chosen role type's level flags (`nationalRole`, `regionalRole`, `superDistrictRole`, `districtRole`, `groupRole`, and the section level flags). A group level role requires a group, a district level role requires a district and no group, and so on. Decide from the legacy `ams-adult-role-add` page what combinations it actually allowed before writing rules.
- Cascade the selects (region limits districts, district limits groups) so an admin cannot pick a group in a different region. `UsersResourceTest` already covers a cascading filter on the user list that can be reused as the pattern.
- Decide whether editing a scope should also update the `action*` twin columns. Ticket 008 mirrors them on create only, matching legacy, which never edits the scope of an existing row. If the BackOffice edit form is meant to move a role between areas, the twin must follow, and `hasValidWarrantOrAppointment()` and the warrant records keyed on the old scope need thought.
- Feature tests for each rejected combination and for the cascade.

# Member Area Adult Leader Directory

**Priority when actioned:** p3

## Synopsis

Bring the legacy Scouts Digital Directory (National, Regional, District and Group teams with lateral lookup into other areas) into the Member panel, with one deliberate change from legacy: every logged-in member may browse roles and names, while contact details stay locked to adult leaders and the infoRedacted flag is honoured. The product owner confirmed the two tier model at pick-up: the directory is open to everyone, contact info only for adult members.

## Resolution

A new `Directory` cluster in the Member panel (`app/Filament/Member/Clusters/Directory`) with four table pages that share one abstract base, `DirectoryTeamPage`:

- `NationalTeam`, `RegionalTeam`, `DistrictTeam`, `GroupTeam`, rendered as tabs (cluster sub-navigation at the top). Each page queries active `system_users_other_roles` rows of active `system_users`, joined to `system_user_types`, filtered on the level's flag (`nationalRole`, `regionalRole`, `districtRole`, `groupRole`). The level to flag mapping lives in the new `App\Enums\DirectoryLevel` enum.
- Legacy's seven pages ("My X Team" plus "Other Xs") collapse into one page per level with a scope filter that defaults to the viewer's own area and can be changed to browse any other region, district or group. District and Group pages carry a second filter (region, district) to narrow the lateral lookup. The viewer's own area comes from new `effectiveRegionId()`, `effectiveDistrictId()` and `effectiveGroupId()` helpers on `SystemUsersOtherRole`, which walk up from a group role to its district and region and fall back to the member's home area for roles without an area scope.
- Two visibility tiers, enforced in the data layer. `SystemUser::isAdultLeader()` (any active role whose type has `adultLeaderRole = 1`) decides whether contact details are queried at all. For adult leaders the user relation is eager loaded with `username`, `cellNr` and `infoRedacted`; for everyone else only `id`, `first_name`, `knownName` and `surname` are selected, and the Email and Cell Number columns are not built, so neither the values nor the column labels reach the response.
- `infoRedacted = 1` renders the word "Redacted" for both email and cell, as legacy does. The four national office holder roles legacy never shows a cell number for (National Administrator, CEO, Chief Commissioner, Chief Scout) keep that behaviour via a documented constant on `NationalTeam`.
- Role names pass through `LegacyHtmlService::decode()` for display because several carry double encoded entities.
- The feature is gated by a new `feature.users_can_browse_directory` setting (`FeatureSettings`, settings migration, toggle on the BackOffice Feature Settings page under General Navigation, default off). Pages check it themselves because a Filament cluster's `canAccess()` does not gate the routes of the pages inside it.
- Tables follow the panel conventions: names only (no IDs), every column toggleable, searchable by name and role, sorted first name then surname like legacy.
- `docs/features/01-adult-member-system/overview.md` gains an "Adult Leader Directory" section and a business rule.

## Verification

- `tests/Feature/Filament/Member/DirectoryTest.php` (12 tests) covers: feature flag off gives 403, guest redirect, adult leader sees names, roles, email and cell, parent sees names and roles but no contact details or contact column labels, a query listener proving the parent request never selects `username` or `cellNr` from `system_users`, redaction shows "Redacted" and hides the real values, inactive attachments and inactive users are excluded, the Group Team defaults to the viewer's group and excludes parents and non adult leader group roles, lateral browsing via the group filter through Livewire, National Team lists national roles for a parent viewer, Regional and District teams default to the viewer's area, and the national cell number suppression.
- Mutation checks run and reverted: forcing `isAdultLeader()` to true turns the two parent tier tests red; removing the `adultLeaderRole` predicate on the Group Team turns the group scoping test red.
- Full suite green on 2026-09-10: 749 passed, 3 skipped (pre-existing skips for empty area tables). Re-derive with `php artisan test --compact`, do not trust this line.
- `vendor/bin/duster fix --dirty` run.
- Not verified: the pages were not opened in a browser in this session, so layout in light and dark themes is unchecked. Behaviour against real production data (role type flags, `infoRedacted` counts) was reasoned from queries against the 2026-09-10 local sync, not exercised end to end.

## Risk assessment

- `system_users_other_roles` has no foreign keys and is written by the legacy system. Attachments pointing at a deleted group, district or region render with a blank scope column; the inner joins to `system_user_types` and `system_users` drop orphans silently.
- The adult leader tier is only as good as the `adultLeaderRole` flag on `system_user_types`. Today (2026-09-10 sync) every group scoped role type that is not youth or plain Parent carries it, including Pack, Den and Troop Adult Helpers, so parent helpers see contact details exactly as they did in legacy. A misflagged role type widens or narrows the tier; re-derive with a query on `system_user_types`, do not trust this line.
- `isAdultLeader()` looks at any active role, not the current tenant, and does not check warrant validity. A leader whose warrant lapsed is already bounced to the holding zone for that tenant, but if they also hold a non warranted role they keep contact visibility through it.
- The National Team follows legacy and includes the `Scouts.Digital System Administrator` role type (nationalRole = 1). Legacy additionally hard excluded one user record and hid the cell number for user 1; those two user level exclusions were not carried over.
- The Regional and District teams do not require `adultLeaderRole`, matching legacy. On the current data every active national, regional and district role type is an adult leader type (the only exceptions are inactive SANJAMB types with no attachments), so nothing non adult is listed today.
- Filament's filter defaults override a `filters[...]` query string on first load, so deep links into a specific group (like the Area cluster uses) will not work on these pages; lateral browsing is by the on page filter.
- Role type `active` is not filtered, as in legacy, so a member still attached to a deactivated role type is listed.

## Decisions

- Lateral lookup is open to every member (roles and names only), as the ticket suggested; no leader only gate on Other Regions, Districts or Groups.
- The Group Team requires `adultLeaderRole = 1` on top of `groupRole = 1`. Legacy's "My Group Team" page listed every active role in the group including youth and parents; its "Other Groups" and "Group Adult Leaders" pages required the adult leader flag, and the open tier must never include youth, so the adult leader variant is the one migrated. Parents therefore do not appear in the directory at all (the Parent role type has neither flag).
- The legacy reduced parent and youth pages are superseded: the adult leaders page by the open tier, and the scouts page (`directory-group-scouts.php`, which exposed youth and parent email and cell to any logged-in user and did not redact parent email) is deliberately not migrated. Youth contact information stays out of the Member panel.
- "My X Team" and "Other Xs" merged into one page per level with a defaulted filter rather than seven pages.
- Display name uses the Ssalute `name` accessor (known name if set, else first name, plus surname) rather than legacy's first name plus surname, for consistency with the rest of the panel.
- Missing or invalid email shows the panel's "-" placeholder instead of legacy's "No Email Address" text.
- Feature toggle defaults off; the product owner enables it in BackOffice when ready.
- The ticket stays filed under module 01 (adult member system); the docs/features overview was extended there.

## Original ticket

# Member Area Adult Leader Directory

Module: 01-adult-member-system
Background: wiki/SD-Migration/Legacy-Navigation-Inventory, topNav-directory.php; wiki/SD-Migration/Migration-Features, item 26 (Directory)
Panel: member

## Goal

Bring the legacy Directory to Ssalute. In Scouts Digital it is the adult leader contact directory: who holds which role at National, Regional, District, and Group level, with lateral lookup into other regions, districts, and groups. Filed at p3 because it changes who can see what about real people, and we want the deliberate visibility model below in place rather than inheriting the legacy gate by accident when members start relying on the member area.

## Legacy behaviour being migrated

- The Directory nav is gated to adult leaders (`defaultAdultLeaderRole > 0`) or Rovers who can admin their group (`defaultRoverCanAdminGroup > 0`). Parents and youth do not see it at all; they only get reduced group pages (adult leaders and scout contacts for their own group).
- Pages: National Team, My Regional Team, My District Team, My Group Team, plus Other Regions, Other Districts, Other Groups for lateral lookup.
- Data comes from active role assignments (`system_users_other_roles`) joined to `system_users` and `system_user_types`, using the role type flags (`nationalRole`, `groupRole`, `adultLeaderRole`, and so on) to decide which roles appear at which level.
- Each person can expose email and cell number, resolved through helper functions, and the `system_users.infoRedacted` flag replaces both with "Redacted" when set.
- The professional directory (Scouting Network, `directory-professional*`) and the alumni directory are separate features and are OUT of scope here. Ticket 019 covers Scouting Network moderation.

## Change from legacy: two visibility tiers

This is the one deliberate departure from legacy behaviour, and it is the point of the ticket.

- **Everyone who can log in, parents included, can browse the directory structure**: the roles at each level and the names of the people holding them. Legacy hid the whole Directory from parents; we are opening the roles and names up.
- **Personal information stays locked to adult leaders**, as it is in legacy. Email addresses, cell numbers, and any other contact or personal detail must never render for a viewer who is not an adult leader. Not hidden client side, not present in the payload at all.
- The `infoRedacted` flag must still be honoured for adult leader viewers, exactly as legacy does.

## Requirements

- Member panel directory pages mirroring the legacy scoping: National Team, My Regional Team, My District Team, My Group Team, and lateral browsing of other regions, districts, and groups.
- Roles listed with the human friendly role name and the holder's name (names only in the member panel, per the identifier display rules in CLAUDE.md).
- Contact details (email, cell) shown only to viewers who are adult leaders, with `infoRedacted` respected. The authorization decision belongs server side, in a policy or query scope, so the reduced view is enforced in the data layer rather than the template.
- Only active role assignments of active users appear, matching the legacy queries.
- Tests must cover both tiers: an adult leader sees contact details, and a parent (or any non leader login) sees roles and names but no personal information anywhere in the rendered response.

## Notes

- Decide during implementation where lateral lookup stops for non leaders. Roles and names are open to everyone by this ticket, so Other Regions, Districts, and Groups can reasonably be open too, but confirm and record the decision.
- Legacy also had reduced group pages for parents and youth (`directory-group-adult-leaders.php`, `directory-group-scouts.php`). The open roles-and-names tier largely supersedes the adult leaders page; check whether the scout contacts view carries anything worth keeping and record the decision. Youth personal information is never in scope for the open tier.
- Module choice: no docs/features module mentions the Directory today. It is filed under 01-adult-member-system because it surfaces adult role assignments; add it to that module's overview when implementing, and move it if the implementation lands more naturally elsewhere.

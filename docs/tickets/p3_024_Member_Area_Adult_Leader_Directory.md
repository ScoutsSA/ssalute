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

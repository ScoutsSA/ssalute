# BackOffice Admin Reports Section

Background: wiki/SD-Migration/Legacy-Navigation-Inventory, Admin Reports under the system administrator nav
Panel: backoffice

## Goal

Legacy gives the system administrator an Admin Reports menu (user disk usage, most active users, bad and good logons, regions/districts/groups, challenges with roles, no primary roles, forced logouts, pages not found). The BackOffice has no reports section at all. Create one, but port only the reports we actually want and leave room for new metric and tracking reports to land in the same section later.

## Requirements

- An Admin Reports section in the BackOffice (its own cluster or nav group under System).
- Port these three reports:
  - Most Active Users: activity ranking over recent user activity.
  - Logins: the successful logon history (model AdminGoodLogon), filterable by user and date.
  - No Primary Roles: users without a primary role.
- Check what actually records logins and activity for Ssalute panel sessions. Legacy writes these tables from its own session handling, so if Ssalute logins do not land in the same data, add recording via Laravel auth events, otherwise the reports only ever show legacy activity, and they will go quiet as legacy winds down.
- The DataFixes cluster already has a Primary Roles worklist backed by the nightly fix. Decide whether the No Primary Roles report links there instead of duplicating a second table over the same finding, and record the decision.
- The remaining legacy reports (disk usage, bad logons, forced logouts, pages not found, possible hacking, regions/districts/groups, challenges with roles) are deliberately not ported. Structure and area listings are covered by the Area cluster, role challenges by the data-fix worklists, and the security ones belong to framework auth and observability (Pulse, logs).

## Notes

- New metric and tracking reports are wanted in this section but are not yet defined. File them as their own tickets once specified; this ticket only needs to leave the section easy to extend.

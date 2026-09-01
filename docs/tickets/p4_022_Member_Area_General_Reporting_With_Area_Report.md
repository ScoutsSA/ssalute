# Member Area General Reporting, Starting With The Area Report

Module: 09-reports-census
Background: wiki/SD-Migration/Legacy-Navigation-Inventory, Admin Reports under the system administrator nav
Panel: member

## Goal

Start a general reporting area in the main user area (the Member panel). The first report to land there is the legacy admin report over regions, districts and groups (the structure listing with member counts), which in legacy was locked away as a system administrator report but deserves to be visible to the whole membership.

## Requirements

- A Reports section in the Member panel that further reports can slot into.
- The Regions, Districts and Groups report: the area structure with member counts per level, browsable and readable rather than a raw table dump.
- Counts are aggregates, so this is not a scope leak, but sanity-check that nothing row-level or personal rides along (names only ever appear per the display rules, and the Member panel shows names without IDs).
- Follow the Member panel feature-flag convention: a FeatureSettings toggle for the reports area (adding-a-setting skill), consistent with how other member features are gated.
- Clarify before building: "full public area" may mean visible to all logged-in members, or truly public without login. Build members-only first and confirm with the product owner whether an unauthenticated version is wanted; if so, that is a separate exposure decision and likely its own ticket.

## Notes

- The BackOffice Area cluster already covers the admin view of this structure; this ticket is about member visibility, not admin management.

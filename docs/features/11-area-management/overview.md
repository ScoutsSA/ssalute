# Feature: Area Management

> Module: Area Management
> Panel(s): Admin (backoffice), Member
> Status: Backoffice complete (2026-09-11). Member panel read only. Super districts and the active toggle warnings are not built.
> Phase: 1 (Foundation)

---

## Overview

The geographic hierarchy in Scouts South Africa is: National, Region, District, Group, and Sections (Meerkat Den, Cub Pack, Scout Troop, Rover Crew). All member activity, including roles, warrants, youth records, finances, and census submissions, is scoped within this hierarchy. The backoffice panel provides full management of every level of the hierarchy, while the member panel gives group leaders read access to their own area.

---

## Geographic Hierarchy

```
National (1 record)
└── Region (e.g. Gauteng, Western Cape)
    ├── Super District (optional grouping of multiple districts)
    └── District
        └── Group
            ├── Meerkat Den
            ├── Cub Pack
            ├── Scout Troop
            └── Rover Crew
```

---

## Backoffice (Admin) Requirements

### Common rules for regions, districts and groups

- Every column on the legacy table is editable in the backoffice form. The audit columns (`id`, `created`, `createdby`, `modified`, `modifiedby`, and on groups `groupLastUpdated` and `groupLastUpdatedBy`) are shown read only on the edit page and stamped by the system.
- Related records (region, district, super district, account, group type, country) are chosen from selects labelled `Name (#id)`.
- Deleting a record that nothing references is a plain confirmation.
- Deleting a record that other rows reference opens a modal that lists every referencing table with its row count and states what a forced delete does. The legacy schema has no foreign keys, so the reference list is derived from the schema dump and covers districts, groups, role attachments, users, sections, committees, finance, advancements, badges, adult membership records, logs and every other referencing table.
- A forced delete removes only the area record. The referencing rows are neither deleted nor changed: they keep the old id, which no longer matches anything, so the area shows as missing wherever they appear and area scoped queries no longer find them. The admin must tick an acknowledgement and type the record name before the force goes through, and a persistent warning afterwards repeats what was left behind.
- Related rows are never nullified (0 means "no scope" in this schema, which would silently widen a role) and never cascaded (that would delete member data across roughly a hundred tables). Moving or deleting them first, using the tabs on the record, avoids orphans.
- Every table that can block a delete is visible as a read only tab on the record's view and edit pages, with a count badge, hidden while empty. The view page also lists the blocking tables in a "Linked records" section.
- Deleting is a hard delete with no undo. Log tables also reference areas, so most real records will go through the forced path.

### Regions

- List all regions with their name, short code, position, active status, district count, and group count. Every column is available as a toggleable column.
- Filter by active status. Search by name or short code. Sort by name, position, or active status.
- View a region's full details including its description, physical address, and active status, along with all districts and groups within it.
- Create and edit regions with name, short code, sort position, country, account, active, using AMS, census done, description, and physical address.
- Name and short code must each be unique. Position must be zero or a positive integer.
- A region with districts, super districts, groups, role attachments, users or other referencing records can only be deleted through the forced path described above.

### Districts

- List all districts with their name, parent region, active status, and group count. Every column is available as a toggleable column.
- Filter by region and active status. Search by name. Sort by name, region, or active status.
- View a district's full details including its parent region, description, physical address, and all groups within it.
- Create and edit districts with name, parent region, super district (limited to the chosen region), country, account, active, census done, description, and physical address.
- Name is required. Region is required. The district name must be unique within its region.
- A district with groups, role attachments, users or other referencing records can only be deleted through the forced path described above.

### Groups

- List all groups with name, registration number, district, region, type, and active status. Every column is available as a toggleable column.
- Filter by region, district, group type, and active status. Search by name or registration number.
- View a group's full details including contact and social media information, banking details, and section units (Meerkat Dens, Cub Packs, Scout Troops, Rover Crews).
- Create and edit groups using a tabbed form covering: details (name, registration number, type, group account, region, district, countries, addresses, description, active, managed regionally, census done), sections (section flags, multi section flags, legacy program types, legacy branch flags), contact and social media (including weather location), banking information, and system settings.
- The district select only offers districts in the chosen region.
- Name, region, district, and group type are required. The registration number must be unique if provided.
- A group with role attachments, users, sections, committee members or other referencing records can only be deleted through the forced path described above.
- Not built: a dedicated active toggle action with a warning when the group has active adult warrants or active youth. The active flag is edited on the form like any other column.

### Group Sections

- Each group can have multiple section units: Meerkat Dens, Cub Packs, Scout Troops, and Rover Crews.
- Sections are managed within the group view and edit pages, with the ability to add, edit, and remove individual section units.
- Each section shows its name and active status.

### Super Districts

- Super districts are optional administrative groupings that span multiple districts within a region.
- They do not affect the primary hierarchy. Groups belong to districts, not super districts.
- Used for reporting and administration purposes in some regions.
- Not built: there is no super district resource. A district's super district is chosen on the district form.

---

## Member Panel Requirements

### Role Gating

- Users must have an active role scoped to a specific group, district, or region.
- All data is scoped to the user's current active role. Data from outside that scope is never accessible.

### View Own Group Details

- Group leaders can view their group's name, type, district, region, contact details, social media links, and section units with their leaders.
- Banking details, system flags, and internal notes are not visible.
- Group Scout Leaders have limited editing capability for contact details and social media links. Full editing requires backoffice access.

### View District Hierarchy

- Users can view their district's name, contact details, and a list of groups in the district (name, type, active status).
- No financial or personal member data is displayed.

### View Regional Information

- Users can view their region's name, contact details, list of districts, and regional leadership contacts.

---

## Business Rules and Constraints

- Deactivating a region or district must not automatically cascade to child records. Deactivation must be done deliberately at the group level. The warning shown when deactivating a parent with active children is not built.
- Deleting a referenced region, district or group requires an explicit forced delete after the consequences are shown. There is no cascade, no nullifying and no soft delete: the related rows are left as they are.
- Group registration numbers are a legacy concept. They must be unique where provided, but empty values are allowed since not all groups have a number.
- The address format (line 1, line 2, city, province, postal code) should be consistent across regions, districts, and groups for reliable exports and reporting.
- The member panel uses role based tenancy. When a user switches their active role, all area scoped data must re scope accordingly. Cached data must not persist across role switches.
- Super districts are purely administrative groupings used for reporting and email routing. They do not affect the primary parent/child hierarchy.

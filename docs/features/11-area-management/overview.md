# Feature: Area Management

> Module: Area Management
> Panel(s): Admin (backoffice), Member
> Status: Planned — Needs Human Review
> Phase: 1 — Foundation

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

### Regions

- List all regions with their name, short code, position, active status, district count, and group count.
- Filter by active status. Search by name or short code. Sort by name, position, or active status.
- View a region's full details including its description, physical address, and active status, along with all districts and groups within it.
- Create and edit regions with name, short code, sort position, active toggle, description, and physical address fields.
- Name and short code must each be unique. Position must be a positive integer.
- A region cannot be deleted if it contains any districts.

### Districts

- List all districts with their name, parent region, active status, and group count.
- Filter by region and active status. Search by name. Sort by name, region, or active status.
- View a district's full details including its parent region, description, physical address, and all groups within it.
- Create and edit districts with name, parent region, active toggle, description, and physical address fields.
- Name is required. Region is required. The district name must be unique within its region.
- A district cannot be deleted if it contains any groups.

### Groups

- List all groups with name, group number, district, region, type, and active status.
- Filter by region (with cascading district filter), group type, and active status. Search by name or group number.
- View a group's full details including contact and social media information, banking details, and section units (Meerkat Dens, Cub Packs, Scout Troops, Rover Crews) with their leaders.
- Create and edit groups using a tabbed form covering: details (name, group number, type, district, description, join date, active toggle), sections (add/edit/remove section units), contact and social media, banking information, and system settings.
- Name, district, and group type are required. Group number must be unique if provided.
- Toggle a group's active status with a confirmation prompt. Deactivating a group that has active adult warrants or active youth shows a warning but does not block the action. No data is deleted.

### Group Sections

- Each group can have multiple section units: Meerkat Dens, Cub Packs, Scout Troops, and Rover Crews.
- Sections are managed within the group view and edit pages, with the ability to add, edit, and remove individual section units.
- Each section shows its name, leader name, and active status.

### Super Districts

- Super districts are optional administrative groupings that span multiple districts within a region.
- They do not affect the primary hierarchy. Groups belong to districts, not super districts.
- Used for reporting and administration purposes in some regions.

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

- Deactivating a region or district must not automatically cascade to child records. Deactivation must be done deliberately at the group level. A warning is shown when deactivating a parent record that has active children.
- Group numbers are a legacy concept. They should be unique where provided, but null or empty values are allowed since not all groups may have a number initially.
- The address format (line 1, line 2, city, province, postal code) should be consistent across regions, districts, and groups for reliable exports and reporting.
- The member panel uses role based tenancy. When a user switches their active role, all area scoped data must re scope accordingly. Cached data must not persist across role switches.
- Super districts are purely administrative groupings used for reporting and email routing. They do not affect the primary parent/child hierarchy.

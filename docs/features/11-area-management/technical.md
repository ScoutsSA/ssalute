# Feature Spec: Area Management

> Module: Area Management
> Panel(s): Admin (backoffice), Member
> Status: Backoffice complete (2026-09-11). Member panel read only.
> Phase: 1 (Foundation)

---

## Overview

The geographic hierarchy in Scouts South Africa is: National, Region, District, Group, Sections (Meerkat Den, Cub Pack, Scout Troop, Rover Crew). All member activity (roles, warrants, youth records, finances, census submissions) is scoped within this hierarchy. The Area cluster in the Admin panel provides CRUD for regions, districts and groups, while the Member panel gives group leaders read access to their own area.

---

## Geographic Hierarchy

```
National (1 record)
└── Region (e.g. Gauteng, Western Cape)
    ├── DistrictsSuper (optional super-district grouping)
    └── District
        └── Group
            ├── GroupMeerkatDen (Meerkat Den)
            ├── GroupCubPack (Cub Pack)
            ├── GroupScoutTroop (Scout Troop)
            └── GroupRoverCrew (Rover Crew)
```

---

## Key Models

| Model | Table | Purpose |
|---|---|---|
| `National` | `national` | Single national-level record |
| `Region` | `regions` | Regional organisations (e.g. Gauteng, Western Cape) |
| `District` | `districts` | District-level organisations within a region |
| `DistrictsSuper` | `districts_super` | Optional super-district groupings spanning multiple districts |
| `Group` | `groups` | Individual Scout groups |
| `GroupsType` | `groups_types` | Group type definitions (Community, School, Church, NGO, DSD) |
| `GroupMeerkatDen` | `group_meerkat_dens` | Meerkat Den sections within a group |
| `GroupCubPack` | `group_cub_packs` | Cub Pack sections within a group |
| `GroupScoutTroop` | `group_scout_troops` | Scout Troop sections within a group |
| `GroupRoverCrew` | `group_rover_crews` | Rover Crew sections within a group |

`Region`, `District` and `Group` use the `PreventsDeletionWhenReferenced` concern (see Deletion guard below).

---

## Filament Cluster

**Location:** `app/Filament/Admin/Clusters/Area/`

The Area cluster groups all geographic hierarchy resources under the Admin panel.

```
Area/
    AreaCluster.php
    Actions/DeleteAreaAction.php                 guarded delete used on every page and table
    Schemas/AreaFormComponents.php               country select, account select, audit section
    Schemas/LinkedRecordsSection.php             infolist section listing the blocking tables
    RelationManagers/RoleAttachmentsRelationManager.php
    RelationManagers/Linked/LinkedRecordsRelationManager.php   abstract read only base
    RelationManagers/Linked/LinkedRelationManagers.php         registry, class and relationship naming
    RelationManagers/Linked/Linked*RelationManager.php         one generated subclass per referencing table
    Resources/Regions/RegionResource.php  (Pages, Schemas, Tables, RelationManagers)
    Resources/Districts/DistrictResource.php
    Resources/Groups/GroupResource.php
```

---

## Current Status

| Resource | List | View | Edit | Create | Delete |
|---|---|---|---|---|---|
| `RegionResource` | Complete | Complete | Complete | Complete | Guarded |
| `DistrictResource` | Complete | Complete | Complete | Complete | Guarded |
| `GroupResource` | Complete | Complete | Complete | Complete | Guarded |
| `DistrictsSuperResource` | Not built | Not built | Not built | Not built | Not built |

Every column on the three tables is editable. Audit columns are read only on edit. Bulk delete is deliberately not offered.

---

## Deletion guard

The legacy schema has no foreign keys, so nothing in the database stops a region, district or group being deleted while other rows point at it. The guard replaces that.

- `app/Services/Areas/AreaReferenceMap.php` lists every column that references an area. The `REGION`, `DISTRICT` and `GROUP` constants are generated from `database/schema/sd-core-schema.sql` by matching the column naming conventions (`regionID`, `assocToRegion`, `assoc_to_region` and the district and group equivalents). The `*_EXTRA` constants are hand curated references whose names do not follow the convention (for example `ams_adult_leader_moves.fromGroup`, `system_users.roverGroupID`, `system_users_other_roles.actionRegionID`). `MODELS` maps each referenced table to its Eloquent model; the five `commerce_*` tables have no model and are listed in `TABLES_WITHOUT_MODELS`.
- `tests/Unit/Services/AreaReferenceMapTest.php` re-derives the canonical maps from the dump and fails when they drift, checks every extra column exists in the dump, and checks every model entry sits on its table. When the schema dump changes, regenerate the constants and let this test confirm them.
- `app/Services/Areas/AreaDeletionGuard.php` (singleton) runs one query per blocking table on the `sd-core` connection. A table with one referencing column is a plain indexed `COUNT`. A table with several (for example `system_users_other_roles.regionID` and `actionRegionID`) gets one query returning the row total and a `SUM(column = id)` per column, so `blockersFor()` reports rows per table (a row pointing at the area in two columns is one row) and `referencesFor()` / `countFor()` report rows per column for the tabs. Results are memoised per record for the request so the view page, its tabs and the delete modal share one pass. The action clears the memo only on an acknowledged submit, where fresh counts decide between the forced and the plain path, which costs one extra pass on that click; the model's `deleting` hook also clears it before its own check. Log tables in `AreaReferenceMap::NON_BLOCKING_TABLES` are skipped entirely (`blockingFor()`), which keeps the pass to about 75 (region), 65 (district) or 110 (group) indexed queries.
- `app/Models/Concerns/PreventsDeletionWhenReferenced.php` throws `App\Exceptions\AreaStillReferencedException` from the `deleting` event, so tinker, services and any future bulk path are stopped with a clear message. `forceDeleteWhileReferenced()` on the model is the only bypass.
- `app/Filament/Admin/Clusters/Area/Actions/DeleteAreaAction.php` extends `DeleteAction` and keeps the action name `delete`. With no blockers it is a plain confirmation. With blockers the modal heading is `Delete Name (#id)`, the description states the total rows and tables, a badge list shows each table with its row count, a "What a forced delete does" section spells out the consequences, and a `Checkbox` (`accepted`) plus a `TextInput` that must equal the record name (`in`) gate the submit, labelled "Force delete". `using()` calls `forceDeleteWhileReferenced()` and then sends a persistent warning notification repeating what was left behind. Used on the edit and view pages and as a row action on all three tables.
- A forced delete removes only the area row. Referencing rows are not deleted and not nullified; they keep the old id. That policy is deliberate: 0 means "no scope" for role attachments, and a cascade would remove member data across roughly a hundred tables.

Log tables (`admin_good_logons`, `error_logging`, `system_user_logging`, `notifications`, `notifications_archive`) carry area ids but are listed in `AreaReferenceMap::NON_BLOCKING_TABLES`: they neither block a delete nor get a linked record tab. Every area that was ever used has rows in them, orphaned log rows are harmless, and `system_user_logging` (close to a million rows) has no index on its area columns, so counting it scanned the table on every page load. `AreaReferenceMapTest` checks each listed table still references the area, so a renamed column surfaces there.

The delete modal decides its path from the acknowledgement checkbox, not from a fresh guard pass. When the modal mounted with no references, submit runs the plain `delete()`; the model's `deleting` hook re-checks, and a reference created after the modal opened is caught in `DeleteAreaAction::deleteUnreferenced()`, which sends a persistent danger notification and halts the action with the record intact. When the modal mounted with references, the acknowledgement and the typed name are validated and the forced path runs; if the references were all cleared in the meantime the plain path runs instead, so the warning notification never reports zero rows.

Scoped selects on the forms (`assoc_to_district` under a region on the group form, `superDistrictID` under a region on the district form, and the shared account and country selects) keep the record's stored value selectable even when it is missing from the scoped list, via `AreaFormComponents::keepingCurrent()`. The stray value is listed first, labelled `Name (#id, in Region (#id), not this region)` or `Unknown district (#id)`, so an admin editing an unrelated field is not refused with "The selected district is invalid" and can see what needs fixing. The legacy data has such rows (no foreign keys).

---

## Linked record tabs

Every table that can block a delete is a relation manager tab on the record's view and edit pages.

- `app/Providers/AreaRelationshipsServiceProvider.php` registers a `hasMany` on `Region`, `District` and `Group` for every blocking table and column in `AreaReferenceMap` (the non blocking log tables get none) using `Model::resolveRelationUsing()`. Names are `linked{StudlyTable}` for convention columns and `linked{StudlyTable}{StudlyColumn}` for extra columns, for example `linkedAdvancementCubs` and `linkedSystemUsersRoverGroupID`.
- `LinkedRecordsRelationManager` is the abstract read only base: hidden unless the table's column has rows for the record and a count badge, both read from the memoised guard result through `AreaDeletionGuard::countFor()` so the tabs add no queries of their own, generic columns (id plus whichever of name, title, first_name, surname, username, description, type, status, date, userID, active, created, createdby the related model casts), and a row link to the related model's admin resource view page where one exists.
- The subclasses under `RelationManagers/Linked/` are generated and only set `$relationship`, `$linkedTable` and `$title`. `LinkedRelationManagers::for(Region::class)` returns the classes to register on a resource, skipping the pairs served by a bespoke manager (`BESPOKE`), modelless tables and the non blocking log tables (`isSkipped()`). Regenerate them with a script that iterates `LinkedRelationManagers::pairsFor()` when the map changes.
- `tests/Feature/Filament/Area/LinkedRecordsRelationManagersTest.php` asserts every table and column pair in the map has exactly one manager registered on the resource (bespoke or generated) whose relationship resolves to the right table and foreign key.

---

## Audit column stamping

`MightHaveCreatedBy` and `MightHaveModifiedBy` stamp `createdby` and `modifiedby` with the authenticated user on any model that casts those columns (previously they checked `$fillable`, which is empty on every model, so they never fired). An explicit value set by the caller is kept. Nothing is stamped without an authenticated user. Covered by `tests/Feature/Models/AuditColumnStampingTest.php`.

---

## Backoffice Panel (Admin) Requirements

### 1. Regions (RegionResource)

**Class:** `app/Filament/Admin/Clusters/Area/Resources/Regions/RegionResource.php`

#### List Regions

- **Columns:** ID, position, name, short code, description, physical address, country ID, account, using AMS, active, census done, district count, group count, counts per group type. All toggleable.
- **Filters:** Active status
- **Search:** Name, short code
- **Sort:** Position by default; any column
- **Actions:** View, Edit, Delete (row actions); Create (header action)

#### View Region

- **Sections displayed:** Region details; Linked records (blocking tables with counts)
- **Relation managers:** Districts, Groups, Roles, then one generated tab per referencing table that has rows
- **Header actions:** Edit, Delete (guarded)

#### Edit / Create Region

- **Fields:** Name, short code, position, country, account, active, using AMS, census done, description, physical address. Audit section (ID) read only on edit.
- **Validation:** Name required and unique; short code unique and at most 3 characters; position an integer of zero or more; country required

#### Delete Region

- **Behaviour:** Plain confirmation when nothing references the region. Otherwise the modal lists the referencing tables, explains that a forced delete leaves them untouched and orphaned, and requires an acknowledgement and the name typed back. Hard delete.

---

### 2. Districts (DistrictResource)

**Class:** `app/Filament/Admin/Clusters/Area/Resources/Districts/DistrictResource.php`

#### List Districts

- **Columns:** ID, name (with region), region, super district, description, physical address, country ID, active, account, census done, group counts, created, created by, modified, modified by. All toggleable. Grouped by region on request.
- **Filters:** Region, active status
- **Search:** Name, created by, modified by
- **Actions:** View, Edit, Delete (row actions); Create (header action)

#### View District

- **Sections displayed:** District details; Linked records
- **Relation managers:** Groups, Roles, then one generated tab per referencing table that has rows
- **Header actions:** Edit, Delete (guarded)

#### Edit / Create District

- **Fields:** Region, super district (limited to the chosen region, stored as 0 when empty), name, country, account, active, census done, description, physical address. Audit section (ID, created, created by, modified, modified by) read only on edit.
- **Validation:** Name required and unique within the chosen region; region required; country required

#### Delete District

- **Behaviour:** As for regions: plain confirmation when unreferenced, otherwise an informed forced delete.

---

### 3. Groups (GroupResource)

**Class:** `app/Filament/Admin/Clusters/Area/Resources/Groups/GroupResource.php`

#### List Groups

- **Columns:** ID, name (with region and district), region, district, registration number, group account, active, SD lite, scarf, group type, managed regionally, section flags, multi section flags, program type labels, website, email, census done, created, created by, modified, modified by, group last updated. All toggleable.
- **Filters:** Group type, region, district, active status. The district filter is not cascaded by the region filter.
- **Search:** ID, name, registration number, scarf, website, email
- **Actions:** View, Edit, Delete (row actions); Create (header action)

#### View Group

- **Sections displayed:** Group details (general, program configuration, system features, banking, social and contact, location and weather, changes); Linked records
- **Relation managers:** Cub Packs, Scout Troops, Rover Crews, Meerkat Dens, Committee, Roles, then one generated tab per referencing table that has rows
- **Header actions:** Edit, Delete (guarded)

#### Edit / Create Group (tabbed form)

- **Details:** Name, registration number, scarf, group type, group account (stored as 0 when empty), active, managed regionally, census done, description; Location: region, district (only districts in the chosen region), physical country, postal country, physical address, postal address
- **Sections:** Section flags, multi section flags, legacy program types (Meerkats, Cubs, Scouts, Rovers), legacy branch flags (branch 1 to 5, AMS only, rovers attached to group)
- **Contact & Social:** Email, website, social media links, GPS, weather location
- **Banking:** Account name, bank, branch, branch code, account number, banking details, invoice notes
- **System:** Feature flags; Audit section (ID, created, created by, modified, modified by, group last updated, group last updated by) read only on edit
- **Validation:** Name, region, district and group type required; registration number unique when provided

#### Delete Group

- **Behaviour:** As for regions: plain confirmation when unreferenced, otherwise an informed forced delete.

Not built: a dedicated "toggle active" action with a warning about active warrants or youth. The active flag is a form toggle.

---

### 4. Group Sections

Managed as relation managers on the group view and edit pages, under `app/Filament/Admin/Clusters/Area/Resources/Groups/RelationManagers/`.

| Relation manager | Table | Columns | Actions |
|---|---|---|---|
| `GroupMeerkatDensRelationManager` | `group_meerkat_dens` | ID, name, active | Create, edit, delete, bulk delete |
| `GroupCubPacksRelationManager` | `group_cub_packs` | ID, name, active | Create, edit, delete, bulk delete |
| `GroupScoutTroopsRelationManager` | `group_scout_troops` | ID, name, active | Create, edit, delete, bulk delete |
| `GroupRoverCrewsRelationManager` | `group_rover_crews` | ID, name, active | Create, edit, delete, bulk delete |
| `GroupCommitteeRelationManager` | `group_committee` | User, type, dates | Create, view, edit, delete |

Leader names are not shown on the section tabs.

---

### 5. Super Districts

Not built. There is no `DistrictsSuperResource`. A district's super district is chosen on the district form from the super districts in its region.

---

## Member Panel Requirements

### Role Gating

All member panel area pages enforce:
- User must have an active role scoped to a specific group, district, or region.
- Queries are scoped to the user's active tenant role's area. Data from outside that scope is never returned.

### 1. View Own Group Details

- **Type:** Read-only page in the Member panel
- **Class:** `app/Filament/Member/Pages/ViewMyGroup.php`
- **Displays:** Group name, type, district, region, contact details, social media links, section units (names and leaders)
- **Does not display:** Banking details, system flags, internal notes
- **Edit access:** Limited editing (contact details, social media links) for Group Scout Leader role; full edit requires backoffice access

### 2. View District Hierarchy

- **Type:** Read-only page
- **Class:** `app/Filament/Member/Pages/ViewMyDistrict.php`
- **Scope:** District of the user's active role
- **Displays:** District name, contact details, list of groups in the district (name, type, active status, no financial or personal member data)

### 3. View Regional Information

- **Type:** Read-only page
- **Class:** `app/Filament/Member/Pages/ViewMyRegion.php`
- **Scope:** Region of the user's active role
- **Displays:** Region name, contact details, list of districts, regional leadership contacts

---

## Tests Required

| Test | File | Type | Status |
|---|---|---|---|
| Pages render for a super admin, forbidden for others | `tests/Feature/Filament/AreaClusterImprovementsTest.php` | Feature | Covered |
| Reference map matches the schema dump, extras exist, models sit on their tables | `tests/Unit/Services/AreaReferenceMapTest.php` | Unit | Covered |
| Guard blocks on districts, groups, roles, users, sections, model-less tables; model delete throws | `tests/Feature/Services/AreaDeletionGuardTest.php` | Feature | Covered |
| Audit columns stamped on create and update, explicit values kept | `tests/Feature/Models/AuditColumnStampingTest.php` | Feature | Covered |
| Region create, edit, uniqueness, delete from edit, view and list, modal content, refused without acknowledgement, wrong name refused, forced delete leaves rows | `tests/Feature/Filament/Area/RegionCrudTest.php` | Feature | Covered |
| District create with createdby, unique within region, edit, delete, refused without acknowledgement, forced delete | `tests/Feature/Filament/Area/DistrictCrudTest.php` | Feature | Covered |
| Group create, cascading district select, registration number uniqueness, edit across tabs, delete, refused without acknowledgement, forced delete | `tests/Feature/Filament/Area/GroupCrudTest.php` | Feature | Covered |
| Every referencing column has one relation manager; tabs hide when empty; rows link to their resource | `tests/Feature/Filament/Area/LinkedRecordsRelationManagersTest.php` | Feature | Covered |
| Group active toggle with warrant warning | none | Feature | Not built |
| Group leader can view their own group details in the member panel | `tests/Feature/Filament/Member/Area/ViewMyGroupTest.php` | Feature | Planned |
| Group leader cannot view another group's details | `tests/Feature/Filament/Member/Area/ViewMyGroupTest.php` | Feature | Planned |

---

## Notes & Considerations

- **Cascade deactivation:** Deactivating a region or district does not cascade to child records. The warning when deactivating a parent with active children is not built.
- **Registration number uniqueness:** Registration numbers are a legacy concept. They are unique where provided; empty values are allowed and are stored as an empty string by `BaseModel`.
- **usingAMS flag:** Indicates whether a region is participating in the automated membership system. Its precise behaviour should be defined when AMS integration is scoped.
- **DistrictsSuper:** Super districts are purely administrative groupings used for reporting and email routing in some regions. They do not affect the primary hierarchy (groups belong to districts, not super-districts).
- **Legacy int columns:** `regions.accountID`, `districts.superDistrictID`, `districts.accountID` and `groups.groupAccountID` are `NOT NULL DEFAULT 0`. The selects show them as empty and store 0. See ticket 010 for the wider treatment of legacy `NOT NULL` columns.
- **Physical address fields:** The legacy tables hold a single free text address. Standardising the address schema (line1, line2, city, province, postal code) is still open.
- **Filament tenancy:** The Member panel uses role-based tenancy. When a user switches their active role (tenant), all area-scoped queries must re-scope accordingly. Ensure no caching of scoped queries across role switches.

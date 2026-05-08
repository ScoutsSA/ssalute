# Feature Spec: Area Management

> Module: Area Management
> Panel(s): Admin (backoffice), Member
> Status: WIP (scaffolded)
> Phase: 1 — Foundation

---

## Overview

The geographic hierarchy in Scouts South Africa is: National → Region → District → Group → Sections (Meerkat Den, Cub Pack, Scout Troop, Rover Crew). All member activity — roles, warrants, youth records, finances, census submissions — is scoped within this hierarchy. The Area cluster in the Admin panel provides CRUD for every level of the hierarchy, while the Member panel gives group leaders read access to their own area.

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

---

## Filament Cluster

**Location:** `app/Filament/Admin/Clusters/Area/`

The Area cluster groups all geographic hierarchy resources under the Admin panel.

---

## Current Status

| Resource | List | View | Edit | Create |
|---|---|---|---|---|
| `RegionResource` | Scaffolded | Scaffolded | Scaffolded | Scaffolded |
| `DistrictResource` | Scaffolded | Scaffolded | Scaffolded | Scaffolded |
| `GroupResource` | Scaffolded | Scaffolded | Scaffolded | Scaffolded |

Group form includes full tabs: Details, Sections, Contact & Social, Banking, System.

---

## Backoffice Panel (Admin) Requirements

### 1. Regions (RegionResource)

**Class:** `app/Filament/Admin/Clusters/Area/Resources/RegionResource.php`

#### List Regions

- **Columns:** Name, short code, position, active status, district count, group count
- **Filters:** Active status
- **Search:** Name, short code
- **Sort:** Name, position, active
- **Actions:** View, Edit (row actions); Create (header action)

#### View Region

- **Sections displayed:**
  - Region details (name, short code, position, description, physical address, active, usingAMS)
  - Relation manager: Districts (list of all districts in this region with district name, group count, active status)
  - Relation manager: Groups (flat list of all groups in this region)
- **Header actions:** Edit, Delete (guarded — blocked if districts exist)

#### Edit / Create Region

- **Editable fields:** Name, short code, position (integer sort order), active (toggle), usingAMS (toggle), description (textarea), physical address fields
- **Validation:** Name required and unique; short code required and unique; position must be a positive integer

#### Delete Region

- **Behaviour:** Blocked if the region has any child district records; shows a descriptive error notification
- **On success:** Soft delete or hard delete depending on application convention

---

### 2. Districts (DistrictResource)

**Class:** `app/Filament/Admin/Clusters/Area/Resources/DistrictResource.php`

#### List Districts

- **Columns:** Name, region, active status, group count
- **Filters:** Region (select), active status
- **Search:** Name
- **Sort:** Name, region, active
- **Actions:** View, Edit (row actions); Create (header action)

#### View District

- **Sections displayed:**
  - District details (name, region, description, physical address, active)
  - Relation manager: Groups (list of groups in this district — name, type, active status)
- **Header actions:** Edit, Delete (guarded — blocked if groups exist)

#### Edit / Create District

- **Editable fields:** Name, region (searchable select from `Region`), active (toggle), description (textarea), physical address fields
- **Validation:** Name required; region required; name must be unique within the selected region

#### Delete District

- **Behaviour:** Blocked if the district has any child group records; shows a descriptive error notification

---

### 3. Groups (GroupResource)

**Class:** `app/Filament/Admin/Clusters/Area/Resources/GroupResource.php`

#### List Groups

- **Columns:** Name, group number, district, region, type, active status
- **Filters:** Region (cascading select), district (filtered by selected region), group type, active status
- **Search:** Name, group number
- **Sort:** Name, district, active
- **Actions:** View, Edit, Toggle active (row actions); Create (header action)

#### View Group

- **Sections displayed:**
  - Group details (name, number, type, district, region, description, join date, active)
  - Contact & social (email, phone, website, social media links)
  - Banking details (bank name, account number, branch code, account type)
  - Relation managers: Meerkat Dens, Cub Packs, Scout Troops, Rover Crews, Committee members
- **Header actions:** Edit, Toggle Active

#### Edit / Create Group — Tabbed Form

- **Tab 1 — Details:** Name, group number, group type (`GroupsType`), district (searchable select), description, join date, active toggle, features toggles
- **Tab 2 — Sections:** Inline management of section units (Meerkat Dens, Cub Packs, Scout Troops, Rover Crews) — add, edit, remove section units
- **Tab 3 — Contact & Social:** Email address, phone number, physical address, postal address, website URL, Facebook, Twitter/X, Instagram links
- **Tab 4 — Banking:** Bank name, account holder name, account number, branch code, account type
- **Tab 5 — System:** Internal flags, system notes, usingAMS toggle, override settings
- **Validation:** Name required; district required; group type required; group number must be unique if provided

#### Toggle Group Active Status

- **Type:** Row action on list; header action on view
- **Behaviour:** Toggles the group's `active` flag; confirmation modal with current status shown; no data is deleted
- **Restrictions:** A group with active adult warrants or active youth should show a warning before deactivation but must not hard-block

---

### 4. Group Sections

Managed as relation managers on `ViewGroup` and inline repeater on `EditGroup` (Tab 2 — Sections).

#### Meerkat Dens Relation Manager

- **Class:** `app/Filament/Admin/Clusters/Area/Resources/GroupResource/RelationManagers/MeerkatDensRelationManager.php`
- **Columns:** Den name, leader name, active
- **Actions:** Add den, edit den, remove den

#### Cub Packs Relation Manager

- **Class:** `app/Filament/Admin/Clusters/Area/Resources/GroupResource/RelationManagers/CubPacksRelationManager.php`
- **Columns:** Pack name, leader name, active
- **Actions:** Add pack, edit pack, remove pack

#### Scout Troops Relation Manager

- **Class:** `app/Filament/Admin/Clusters/Area/Resources/GroupResource/RelationManagers/ScoutTroopsRelationManager.php`
- **Columns:** Troop name, leader name, active
- **Actions:** Add troop, edit troop, remove troop

#### Rover Crews Relation Manager

- **Class:** `app/Filament/Admin/Clusters/Area/Resources/GroupResource/RelationManagers/RoverCrewsRelationManager.php`
- **Columns:** Crew name, leader name, active
- **Actions:** Add crew, edit crew, remove crew

---

### 5. Super Districts (DistrictsSuperResource)

**Class:** `app/Filament/Admin/Clusters/Area/Resources/DistrictsSuperResource.php`

- **List columns:** Name, region, district count
- **Edit fields:** Name, region (select), member districts (multi-select of districts in the same region)
- **Purpose:** Administrative groupings that do not affect the primary hierarchy but allow reporting and administration to span multiple districts within a region

---

## Member Panel Requirements

### Role Gating

All member panel area pages enforce:
- User must have an active role scoped to a specific group, district, or region.
- Queries are scoped to the user's active tenant role's area — data from outside that scope is never returned.

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
- **Displays:** District name, contact details, list of groups in the district (name, type, active status — no financial or personal member data)

### 3. View Regional Information

- **Type:** Read-only page
- **Class:** `app/Filament/Member/Pages/ViewMyRegion.php`
- **Scope:** Region of the user's active role
- **Displays:** Region name, contact details, list of districts, regional leadership contacts

---

## Tests Required

| Test | File | Type | Status |
|---|---|---|---|
| Super admin can list all regions | `tests/Feature/Filament/Admin/Area/AreaClusterImprovementsTest.php` | Feature | Covered |
| Super admin can view a region | `tests/Feature/Filament/Admin/Area/AreaClusterImprovementsTest.php` | Feature | Covered |
| Super admin can edit a region | `tests/Feature/Filament/Admin/Area/AreaClusterImprovementsTest.php` | Feature | Covered |
| Super admin can create a region | `tests/Feature/Filament/Admin/Area/AreaClusterImprovementsTest.php` | Feature | Covered |
| Super admin can list all districts | `tests/Feature/Filament/Admin/Area/AreaClusterImprovementsTest.php` | Feature | Covered |
| Super admin can view a district | `tests/Feature/Filament/Admin/Area/AreaClusterImprovementsTest.php` | Feature | Covered |
| Super admin can edit a district | `tests/Feature/Filament/Admin/Area/AreaClusterImprovementsTest.php` | Feature | Covered |
| Super admin can create a district | `tests/Feature/Filament/Admin/Area/AreaClusterImprovementsTest.php` | Feature | Covered |
| Super admin can list all groups | `tests/Feature/Filament/Admin/Area/AreaClusterImprovementsTest.php` | Feature | Covered |
| Super admin can create a group | `tests/Feature/Filament/Admin/Area/AreaClusterImprovementsTest.php` | Feature | Covered |
| Regular user is forbidden from area management pages | `tests/Feature/Filament/Admin/Area/AreaClusterImprovementsTest.php` | Feature | Covered |
| Group creation fails when name is missing | `tests/Feature/Filament/Admin/Area/GroupValidationTest.php` | Feature | Planned |
| Group creation fails when group type is missing | `tests/Feature/Filament/Admin/Area/GroupValidationTest.php` | Feature | Planned |
| Region deletion is blocked when districts exist | `tests/Feature/Filament/Admin/Area/RegionDeletionTest.php` | Feature | Planned |
| District deletion is blocked when groups exist | `tests/Feature/Filament/Admin/Area/DistrictDeletionTest.php` | Feature | Planned |
| Group active toggle changes active status | `tests/Feature/Filament/Admin/Area/GroupToggleTest.php` | Feature | Planned |
| Group leader can view their own group details in the member panel | `tests/Feature/Filament/Member/Area/ViewMyGroupTest.php` | Feature | Planned |
| Group leader cannot view another group's details | `tests/Feature/Filament/Member/Area/ViewMyGroupTest.php` | Feature | Planned |

---

## Notes & Considerations

- **Cascade deactivation:** Deactivating a region or district should not automatically cascade to child records. This must be a deliberate action at the group level. Provide a warning notification to the admin when deactivating a parent record that has active children.
- **Group number uniqueness:** Group numbers are a legacy concept from the old numbering system. They should be unique where provided, but not all groups may have a number initially — allow null/empty.
- **usingAMS flag:** This flag indicates whether a group/region is participating in the automated membership system. Its precise behaviour should be defined when AMS integration is scoped.
- **DistrictsSuper:** Super districts are purely administrative groupings used for reporting and email routing in some regions. They do not affect the primary foreign-key hierarchy (groups belong to districts, not super-districts).
- **Physical address fields:** Standardise the address schema (line1, line2, city, province, postal code) across Region, District, and Group so that export and reporting are consistent.
- **Filament tenancy:** The Member panel uses role-based tenancy. When a user switches their active role (tenant), all area-scoped queries must re-scope accordingly. Ensure no caching of scoped queries across role switches.

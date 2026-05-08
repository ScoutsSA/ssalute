# Feature Spec: Youth Management

> Module: Youth Management
> Panel(s): Admin (backoffice), Member
> Status: PLANNED
> Phase: 3 — Group Operations

---

## Overview

Youth members are stored as `SystemUser` records, distinguished from adults by their assigned role type. They are organised within group sections: Meerkat Dens, Cub Packs, Scout Troops, and Rover Crews. Youth progress through sections as they age via the Entsha program, which governs formal section transitions.

---

## Section Age Groups

| Section | Typical Age Range | Unit Type |
|---|---|---|
| Meerkats | 5–8 years | Den |
| Cubs | 8–11 years | Pack |
| Scouts | 11–17 years | Troop |
| Rovers | 18–26 years | Crew |

---

## Key Models

| Model | Table | Purpose |
|---|---|---|
| `SystemUser` | `system_users` | Youth record (same model as adults, distinguished by role type) |
| `GroupMeerkatDen` | `group_meerkat_dens` | Meerkat Den section record within a group |
| `GroupCubPack` | `group_cub_packs` | Cub Pack section record within a group |
| `GroupScoutTroop` | `group_scout_troops` | Scout Troop section record within a group |
| `GroupRoverCrew` | `group_rover_crews` | Rover Crew section record within a group |
| `GroupsEntshaMove` | `groups_entsha_moves` | Youth section transitions (Entsha moves) |
| `GroupUserPictureChange` | `group_user_picture_changes` | Profile picture change records |
| `GroupYouthCharge` | `group_youth_charges` | Youth charge/complaint records |
| `SystemParentType` | `system_parent_types` | Parent/guardian relationship type definitions |

---

## Filament Cluster

**Location:** `app/Filament/Admin/Clusters/Youth/`

The Youth Management cluster lives under the Admin panel. It groups all youth-related resources and pages for backoffice access.

---

## Backoffice Panel (Admin) Requirements

### 1. Youth List

- **Type:** `ListRecords` page within `YouthResource`
- **Class:** `app/Filament/Admin/Clusters/Youth/Resources/YouthResource/Pages/ListYouth.php`
- **Table columns:** Full name, membership number, section, group, patrol/six/den/crew, active status, date of birth, age
- **Filters:** Section (Meerkat/Cub/Scout/Rover), group, active status, age range
- **Search:** Name (first + last), membership number, group name
- **Actions:** View, Edit, Deactivate/Re-activate (row actions); Bulk email, Bulk deactivate (bulk actions)

### 2. View Youth Profile

- **Type:** `ViewRecord` page within `YouthResource`
- **Class:** `app/Filament/Admin/Clusters/Youth/Resources/YouthResource/Pages/ViewYouth.php`
- **Sections displayed:**
  - Personal details (name, DOB, gender, membership number, join date)
  - Current section and group assignment
  - Patrol/six/den/crew assignment
  - Parent/guardian list (with relationship type from `SystemParentType`)
  - Active status and any deactivation reason
  - Profile picture
  - Section transition history (Entsha moves from `GroupsEntshaMove`)
  - Charge history (from `GroupYouthCharge`)
  - Green card / attendance card summary
- **Header actions:** Edit, Deactivate/Re-activate, Process Entsha Move, Upload Profile Picture

### 3. Edit Youth Profile

- **Type:** `EditRecord` page within `YouthResource`
- **Class:** `app/Filament/Admin/Clusters/Youth/Resources/YouthResource/Pages/EditYouth.php`
- **Editable fields:**
  - Personal details: first name, last name, date of birth, gender, ID/passport number
  - Section assignment: section type, group, den/pack/troop/crew
  - Sub-unit assignment: patrol name / six name / den name / crew name (conditional on section)
  - Contact details (where applicable for older youth)
  - Active status flag
- **Validation:** Date of birth must be consistent with assigned section age range (warning, not hard block for edge cases)

### 4. Add New Youth

- **Type:** `CreateRecord` page within `YouthResource`
- **Class:** `app/Filament/Admin/Clusters/Youth/Resources/YouthResource/Pages/CreateYouth.php`
- **Required fields:** First name, last name, date of birth, gender, group, section, den/pack/troop/crew assignment
- **Optional fields:** ID number, alternative contact, sub-unit assignment
- **On save:** Creates `SystemUser` record with appropriate youth role type; links to selected section unit

### 5. Deactivate / Re-activate Youth

- **Type:** Row action on `ListYouth` and header action on `ViewYouth`
- **Deactivation:** Requires a reason (text field in modal confirmation). Sets active status to false and records the reason and date.
- **Re-activation:** Confirmation modal. Clears deactivation reason. Restores active status.

### 6. Move Youth Between Groups

- **Type:** Custom action on `ViewYouth` / `EditYouth`
- **Class:** `app/Filament/Admin/Clusters/Youth/Resources/YouthResource/Actions/MoveYouthBetweenGroupsAction.php`
- **Modal fields:** Target group, target section unit (filtered by section type), effective date, reason/notes
- **On save:** Updates youth's group and section assignment; records move history
- **History view:** Shown on `ViewYouth` in a dedicated timeline/table section

### 7. Process Entsha Move (Section Transition)

- **Type:** Custom action on `ViewYouth` and dedicated page
- **Class:** `app/Filament/Admin/Clusters/Youth/Resources/YouthResource/Actions/ProcessEntshaAction.php`
- **Entsha transitions:**
  - Meerkat → Cub
  - Cub → Scout
  - Scout → Rover
- **Modal fields:** Target section, target group unit (if moving groups), effective date, notes
- **Validation:**
  - Youth age must be within acceptable range for target section (configurable via `GeneralSettings`)
  - Source section must logically precede target section (no skipping)
- **On save:** Creates `GroupsEntshaMove` record; updates `SystemUser` section assignment; sends notification to group leaders of both sections
- **Edge cases:** Overriding an age validation requires a super-admin or regional-admin confirmation step

### 8. Youth Charges Management

- **Type:** Relation manager on `ViewYouth` / `EditYouth`
- **Class:** `app/Filament/Admin/Clusters/Youth/Resources/YouthResource/RelationManagers/YouthChargesRelationManager.php`
- **Table columns:** Date raised, charge type, raised by, status (open/resolved), resolution date
- **Actions:**
  - Add charge (modal: date, type, description, raised by)
  - View charge detail
  - Resolve charge (modal: resolution notes, resolution date)
- **Filters:** Status (open/resolved), date range

### 9. Multi-select Bulk Actions

Available on `ListYouth`:

| Action | Behaviour |
|---|---|
| Bulk email | Opens modal to compose email; queues a job to send to all selected youth's contact details (or parent contacts for minors) |
| Bulk deactivate | Confirmation with required reason; deactivates all selected youth records |
| Export selected | CSV export of selected youth records |

### 10. Parent / Guardian Management

- **Type:** Relation manager on `ViewYouth` / `EditYouth`
- **Class:** `app/Filament/Admin/Clusters/Youth/Resources/YouthResource/RelationManagers/ParentsRelationManager.php`
- **Table columns:** Parent name, relationship type (from `SystemParentType`), email, phone, primary contact flag
- **Actions:**
  - Link existing user as parent (search by name/email)
  - Add new parent (creates a `SystemUser` record if not found, or links existing)
  - Unlink parent (removes the relationship, does not delete the parent user)
  - Set as primary contact

### 11. Green Card Management (Attendance Card)

- **Type:** Custom page or relation manager on `ViewYouth`
- **Class:** `app/Filament/Admin/Clusters/Youth/Resources/YouthResource/Pages/YouthGreenCard.php`
- **Purpose:** Records and displays the youth's attendance card data — meetings attended, activities, etc.
- **Display:** Attendance entries in a table with date, event type, and recording leader
- **Actions:** Add entry (date, event, notes), view history

### 12. Profile Picture Upload

- **Type:** Custom action on `ViewYouth` / `EditYouth`
- **Class:** `app/Filament/Admin/Clusters/Youth/Resources/YouthResource/Actions/UploadProfilePictureAction.php`
- **Behaviour:** Opens a file upload modal (image files only, max 5 MB). On save: stores the image via Laravel's storage system; creates a `GroupUserPictureChange` record logging the change (who changed it, when, previous image reference).

---

## Member Panel Requirements

The Member panel exposes a limited subset of youth management functionality, role-gated so that leaders can only access youth within their own group or section.

### Role Gating

All member panel youth pages enforce:
- User must have an active leadership role (e.g., Group Scout Leader, Section Leader, Assistant Leader) for the relevant group.
- Queries are scoped to the user's active tenant role's group — youth from other groups are never returned.

### 1. View Youth Roster

- **Type:** `ListRecords` page
- **Class:** `app/Filament/Member/Resources/YouthResource/Pages/ListYouth.php`
- **Columns:** Name, section, sub-unit, active status, age
- **Filters:** Section, active status
- **Search:** Name
- **Scope:** Limited to youth in the leader's own group

### 2. Add Youth to Own Group

- **Type:** `CreateRecord` page
- **Class:** `app/Filament/Member/Resources/YouthResource/Pages/CreateYouth.php`
- **Pre-filled:** Group and section derived from the leader's active role
- **Required fields:** Name, date of birth, gender, section unit assignment

### 3. Edit Youth Profile (Own Group Only)

- **Type:** `EditRecord` page
- **Class:** `app/Filament/Member/Resources/YouthResource/Pages/EditYouth.php`
- **Editable fields:** Personal details, sub-unit assignment
- **Not editable at member level:** Group assignment, section (use Entsha move instead), membership number
- **Authorization:** 403 if youth does not belong to the leader's group

### 4. Record Attendance

- **Type:** Custom action or dedicated page accessible from `ViewYouth` or the section's roster
- **Class:** `app/Filament/Member/Resources/YouthResource/Pages/RecordAttendance.php`
- **Scope:** Own section only
- **Fields per entry:** Date, meeting/event type, present (yes/no/excused), notes
- **Batch recording:** Allows marking attendance for multiple youth in a single session (checklist-style)

### 5. Process Entsha Move (Own Section)

- Same behaviour as the backoffice Entsha action, but scoped to the leader's own group and section.
- Creates `GroupsEntshaMove`; sends notifications.
- Age validation is enforced; age overrides require a request to a regional or national admin.

### 6. View Youth Charges (Own Group Only)

- Read-only view of open charges for youth in the leader's group.
- Leaders can add a new charge against their own group's youth.
- Resolution of charges is handled by admin/backoffice only.

---

## Tests Required

| Test | File | Type |
|---|---|---|
| Super admin can access all youth management pages | `tests/Feature/Filament/Admin/Youth/YouthResourceTest.php` | Feature |
| Super admin can create a new youth record | `tests/Feature/Filament/Admin/Youth/YouthResourceTest.php` | Feature |
| Super admin can edit a youth record | `tests/Feature/Filament/Admin/Youth/YouthResourceTest.php` | Feature |
| Super admin can deactivate and re-activate youth | `tests/Feature/Filament/Admin/Youth/YouthResourceTest.php` | Feature |
| Group leader can access their group's youth in the member panel | `tests/Feature/Filament/Member/Youth/YouthRosterTest.php` | Feature |
| Group leader cannot access another group's youth | `tests/Feature/Filament/Member/Youth/YouthRosterTest.php` | Feature |
| Regular member (no leadership role) cannot access youth management | `tests/Feature/Filament/Member/Youth/YouthRosterTest.php` | Feature |
| Entsha move fails if youth is outside the accepted age range for target section | `tests/Feature/Youth/EntshaTest.php` | Feature |
| Entsha move fails if target section does not logically follow source section | `tests/Feature/Youth/EntshaTest.php` | Feature |
| Entsha move succeeds and creates GroupsEntshaMove record | `tests/Feature/Youth/EntshaTest.php` | Feature |
| Youth charge can be added by group leader | `tests/Feature/Youth/YouthChargeTest.php` | Feature |
| Youth charge is visible on youth profile | `tests/Feature/Youth/YouthChargeTest.php` | Feature |
| Youth charge can be resolved by admin | `tests/Feature/Youth/YouthChargeTest.php` | Feature |
| Parent can be linked to and unlinked from youth | `tests/Feature/Youth/ParentLinkTest.php` | Feature |
| Profile picture upload creates GroupUserPictureChange record | `tests/Feature/Youth/ProfilePictureTest.php` | Feature |

---

## Notes & Considerations

- **Minor data protection (POPIA):** Youth records, especially for under-18s, must comply with POPIA. Only authorised roles may export or view sensitive personal data.
- **Parent contact priority:** For youth under 18, bulk communications (bulk email) should default to routing through the linked parent's contact details, not the youth's own contact details.
- **Entsha age overrides:** Build in a configurable tolerance (e.g., ±3 months) via `GeneralSettings` so edge cases near age boundaries are handled gracefully without requiring admin intervention every time.
- **Green card:** The green card/attendance card concept maps closely to a simple attendance log. Keep the data model simple; the legacy system used a physical card metaphor that should be preserved in the UI label but need not constrain the schema.

# Feature Spec: Group Operations

## Overview

Day-to-day group management including weekly program planning, committee and council management, attendance recording, equipment and property tracking, and group communications. The backoffice panel provides cross-group visibility and admin configuration, while the general panel gives group leaders self-service tools for their own group.

---

## Key Models

### Programs

| Model | Table | Purpose |
|---|---|---|
| `GroupProgram` | `group_programs` | Program/meeting plan record |
| `GroupProgramsDocument` | _(see model)_ | Supporting documents attached to a program |
| `GroupProgramsOnlineTask` | _(see model)_ | Online task/challenge definition |
| `GroupProgramsOnlineTasksCompletion` | _(see model)_ | Youth task completion records |
| `GroupProgramsOnlineTasksDocument` | _(see model)_ | Documents attached to an online task |
| `GroupProgramsOnlineTasksImage` | _(see model)_ | Images attached to an online task |
| `GroupProgramsOnlineTasksNote` | _(see model)_ | Notes on an online task submission |
| `GroupProgramsOnlineTasksPenalty` | _(see model)_ | Penalty records for an online task |
| `GroupProgramsOnlineWorkingOn` | _(see model)_ | Tracks which task a youth is actively working on |

### Committees & Councils

| Model | Table | Purpose |
|---|---|---|
| `GroupCommittee` | `group_committee` | Committee member record per group |
| `GroupCouncil` | `group_council` | Rover council member record |
| `GroupParentsCommitteeMinute` | `group_parents_committee_minutes` | Parents committee meeting minutes |
| `SystemCommitteeType` | `system_committee_types` | Committee role type reference |
| `SystemCouncilType` | `system_council_types` | Council role type reference |

### Attendance

| Model | Table | Purpose |
|---|---|---|
| `GroupAttendance` | `group_attendance` | Weekly attendance records per group meeting |

### Equipment & Property

| Model | Table | Purpose |
|---|---|---|
| `GroupEquipment` | `group_equipment` | Equipment/asset record |
| `GroupEquipmentStore` | `group_equipment_store` | Storage location definitions per group |
| `GroupsProperty` | `groups_property` | Group property/building record |
| `GroupsPropertyOwnershipType` | _(see model)_ | Ownership type definitions (owned, leased, etc.) |
| `GroupsPropertyUpdate` | _(see model)_ | Property condition/update history |
| `SystemAssetCondition` | _(see model)_ | Asset condition status reference (good, fair, poor, etc.) |

### Communications

| Model | Table | Purpose |
|---|---|---|
| `GroupNewsletter` | `group_newsletters` | Newsletter record per group |
| `GroupWeeklyEmailsEmailed` | _(see model)_ | Weekly email delivery tracking |
| `GroupDocument` | `group_documents` | Group document storage |

---

## Backoffice Panel (Admin)

### Resource Location

Existing `GroupOperations` cluster under `app/Filament/Admin/Clusters/GroupOperations/`.

### 1. View All Programs

- List `GroupProgram` records across all groups.
- Search by group name, program title, date.
- Filter by section type (Cubs, Scouts, Rovers, etc.) and date range.
- View program detail including attached documents.

### 2. Manage Committee Members

- List `GroupCommittee` records per group.
- Add a committee member: select user, role (`SystemCommitteeType`), start date, end date.
- Edit or deactivate existing committee records.
- Filter by region, district, or group.

### 3. Manage Council Members (Rovers)

- List `GroupCouncil` records per group.
- Add a council member: select user, role (`SystemCouncilType`), start date.
- Edit or remove council records.

### 4. View Attendance Records

- List `GroupAttendance` records across groups.
- Filter by group, date range, section.
- Show attendance count and percentage per meeting.
- Export attendance report (CSV).

### 5. Manage Group Equipment

- List `GroupEquipment` records across all groups.
- Filter by group, condition (`SystemAssetCondition`), storage location (`GroupEquipmentStore`).
- Add or edit equipment: name, description, serial number, condition, storage location, purchase date, value.
- View condition history.

### 6. Manage Group Property

- List `GroupsProperty` records.
- Add or edit property: name, address, ownership type (`GroupsPropertyOwnershipType`), size, value.
- Record a property update/inspection (`GroupsPropertyUpdate`).
- Filter by region, district, or ownership type.

### 7. View Group Newsletters

- List all `GroupNewsletter` records across groups.
- View newsletter content and dispatch history (`GroupWeeklyEmailsEmailed`).
- Admin cannot edit group newsletters, only view.

### 8. Online Program Task Administration

- Create and manage `GroupProgramsOnlineTask` definitions (title, description, points, deadline).
- Attach documents and images to task definitions.
- View completion records (`GroupProgramsOnlineTasksCompletion`) per task.
- Apply or remove penalties (`GroupProgramsOnlineTasksPenalty`).

---

## General Panel (Group Leader / Group Admin)

### Resource Location

`app/Filament/General/` — Group Operations section scoped to the authenticated user's group.

### 1. Create & Manage Programs

- Create a `GroupProgram`: title, date, section, description, objectives, theme.
- Attach supporting documents (`GroupProgramsDocument`).
- Edit or delete own group's programs.
- View program history (past programs list).

### 2. Share Program with Other Groups

- Mark a program as shareable.
- Browse programs shared by other groups (read-only).
- Copy a shared program as a new draft for own group.

### 3. Record Weekly Attendance

- Select meeting date and section.
- Mark each active member as present, absent, or excused.
- Save attendance record (`GroupAttendance`).
- View attendance history per member.

### 4. Manage Committee

- View current committee members for own group.
- Add a committee member: select user, role (`SystemCommitteeType`), start date.
- Remove or update committee roles.
- View committee member history.

### 5. Upload & View Group Documents

- Upload documents to `GroupDocument` with title, category, and description.
- View and download existing group documents.
- Archive or delete own documents.

### 6. Create & Send Group Newsletter

- Create a `GroupNewsletter`: subject, body (rich text), target audience.
- Preview newsletter before sending.
- Send newsletter to group members/parents.
- View delivery tracking (`GroupWeeklyEmailsEmailed`).

### 7. Record & View Meeting Minutes

- Create `GroupParentsCommitteeMinute` records: date, attendees, agenda, minutes text.
- View past minutes in chronological order.
- Download minutes as PDF.

### 8. Manage Equipment Inventory

- View own group's `GroupEquipment` records.
- Add new equipment item: name, description, condition, storage location, purchase date.
- Update condition or storage location.
- Manage storage locations (`GroupEquipmentStore`): add/edit/remove.

### 9. Online Programs — Youth Task Tracking & Leaderboard

- View available `GroupProgramsOnlineTask` definitions for own group's section.
- Mark tasks as in progress (`GroupProgramsOnlineWorkingOn`) or completed (`GroupProgramsOnlineTasksCompletion`).
- Submit task evidence (documents, images, notes).
- View leaderboard showing points earned per youth within the group.

---

## Tests Required

### Feature Tests (`tests/Feature/GroupOperations/`)

1. **Super admin can view programs and operations resources**
   - Assert admin can access the programs list, committee list, attendance list, equipment list, and property list.
   - _(Partially covered by existing `GroupOperationsClusterTest` — extend rather than replace.)_

2. **Group leader can create programs for their group**
   - Assert group leader can submit the create program form and a `GroupProgram` record is persisted.
   - Assert the program is associated with the correct group.

3. **Group leader cannot access another group's programs**
   - Assert group leader receives 403/404 when attempting to view or edit a `GroupProgram` belonging to a different group.

4. **Committee management workflow**
   - Assert a committee member can be added with a valid role and start date.
   - Assert an inactive committee member does not appear in the active committee list.

5. **Attendance recording and viewing**
   - Assert that submitting an attendance record creates the correct `GroupAttendance` entry.
   - Assert attendance history is viewable and filterable by date range.

6. **Equipment inventory CRUD**
   - Assert group leader can create, update, and view equipment records for their group.
   - Assert group leader cannot modify equipment records belonging to another group.

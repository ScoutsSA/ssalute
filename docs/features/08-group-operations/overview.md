# Feature: Group Operations

> Module: Group Operations
> Panel(s): Admin (backoffice), Member
> Status: Planned — Needs Human Review
> Phase: 8

---

## What This Feature Does

Group Operations covers the day to day management of Scout groups. This includes weekly program planning, committee and council management, attendance recording, equipment and property tracking, group communications (newsletters and documents), and online youth task programs. The admin backoffice provides cross group visibility and configuration, while the member panel gives group leaders self service tools scoped to their own group.

---

## Admin Backoffice Requirements

### Programs

- View all group programs across the organisation.
- Search by group name, program title, or date.
- Filter by section type (Cubs, Scouts, Rovers, etc.) and date range.
- View program details including any attached supporting documents.

### Committee Members

- View committee members per group.
- Add a committee member by selecting a user, assigning a role, and setting a start date (and optional end date).
- Edit or deactivate existing committee records.
- Filter by region, district, or group.

### Council Members (Rovers)

- View Rover council members per group.
- Add a council member by selecting a user, assigning a role, and setting a start date.
- Edit or remove council records.

### Attendance Records

- View attendance records across all groups.
- Filter by group, date range, and section.
- See attendance count and percentage per meeting.
- Export attendance reports as CSV.

### Group Equipment

- View equipment records across all groups.
- Filter by group, condition (good, fair, poor, etc.), and storage location.
- Add or edit equipment records including name, description, serial number, condition, storage location, purchase date, and value.
- View condition history for each piece of equipment.

### Group Property

- View group property and building records.
- Add or edit property records including name, address, ownership type (owned, leased, etc.), size, and value.
- Record property condition updates and inspections.
- Filter by region, district, or ownership type.

### Group Newsletters

- View all newsletters across groups (read only for admins).
- View newsletter content and email delivery history.
- Admins cannot edit group newsletters, only view them.

### Online Program Tasks

- Create and manage online task/challenge definitions with a title, description, points value, and deadline.
- Attach documents and images to task definitions.
- View completion records per task.
- Apply or remove penalties on task submissions.

---

## Member Panel Requirements

These features are available to group leaders and group admins, scoped to their own group.

### Create and Manage Programs

- Create a program (meeting plan) with a title, date, section, description, objectives, and theme.
- Attach supporting documents to a program.
- Edit or delete programs belonging to the group.
- View the history of past programs.

### Share Programs with Other Groups

- Mark a program as shareable so other groups can see it.
- Browse programs shared by other groups (read only).
- Copy a shared program as a new draft for the group.

### Record Weekly Attendance

- Select a meeting date and section, then mark each active member as present, absent, or excused.
- View attendance history per member.

### Manage Committee

- View current committee members for the group.
- Add new committee members by selecting a user, assigning a role, and setting a start date.
- Update or remove committee roles.
- View committee member history.

### Upload and View Group Documents

- Upload documents with a title, category, and description.
- View and download existing group documents.
- Archive or delete documents.

### Create and Send Group Newsletters

- Create a newsletter with a subject, rich text body, and target audience.
- Preview the newsletter before sending.
- Send the newsletter to group members and parents.
- View email delivery tracking.

### Record and View Meeting Minutes

- Record meeting minutes with a date, attendees, agenda, and minutes text.
- View past minutes in chronological order.
- Download minutes as PDF.

### Manage Equipment Inventory

- View the group's equipment records.
- Add new equipment with name, description, condition, storage location, and purchase date.
- Update equipment condition or storage location.
- Manage storage locations (add, edit, remove).

### Online Youth Task Tracking and Leaderboard

- View available online tasks for the group's section.
- Mark tasks as in progress or completed.
- Submit task evidence (documents, images, notes).
- View a leaderboard showing points earned per youth member within the group.

---

## Business Rules and Constraints

1. **Group scoping.** Group leaders can only manage programs, attendance, equipment, documents, newsletters, and committee records for their own group. Attempting to access another group's data is denied.
2. **Program sharing is opt in.** Programs are only visible to other groups when explicitly marked as shareable. Shared programs are read only to other groups and can be copied as drafts.
3. **Admin newsletter access is read only.** Admins can view group newsletters and their delivery history but cannot edit or send newsletters on behalf of a group.
4. **Committee and council roles are time bound.** Committee and council member records have start dates (and optional end dates). Inactive members are excluded from the active committee view.
5. **Online task penalties.** Admins can apply or remove penalties on online task submissions, which affect the points earned and leaderboard standings.
6. **Equipment condition tracking.** Equipment records maintain a condition history, allowing groups and admins to track changes in asset condition over time.
7. **Property updates are logged.** Property condition updates and inspections are recorded as a history, preserving a full audit trail of the property's state over time.

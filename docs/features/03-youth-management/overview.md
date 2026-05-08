# Feature: Youth Management

> Module: Youth Management
> Panel(s): Admin (backoffice), Member
> Status: Planned — Needs Human Review
> Phase: 3 — Group Operations

---

## Overview

Youth Management handles the registration, tracking, and progression of all youth members within Scouts South Africa. Youth are organised into four sections based on age: Meerkats (ages 5 to 8), Cubs (ages 8 to 11), Scouts (ages 11 to 17), and Rovers (ages 18 to 26). Each section is structured into units within a group (dens, packs, troops, and crews respectively). Youth progress through sections as they age via the Entsha program, which governs formal section transitions.

---

## Section Age Groups

| Section | Typical Age Range | Unit Type |
|---|---|---|
| Meerkats | 5 to 8 years | Den |
| Cubs | 8 to 11 years | Pack |
| Scouts | 11 to 17 years | Troop |
| Rovers | 18 to 26 years | Crew |

---

## Backoffice (Admin) Requirements

### Youth List and Search

- Administrators can browse all youth members across the organisation, with columns showing name, membership number, section, group, sub-unit (patrol/six/den/crew), active status, date of birth, and age.
- Filtering is available by section type, group, active status, and age range.
- Search covers name, membership number, and group name.

### View Youth Profile

- Administrators can view a youth member's full profile, including personal details, current section and group assignment, sub-unit assignment, linked parents or guardians (with relationship type), active status, profile picture, section transition history, charge history, and attendance card summary.

### Add and Edit Youth

- Administrators can register new youth members by providing name, date of birth, gender, group, section, and unit assignment.
- Administrators can edit all youth profile fields, including personal details, section assignment, sub-unit assignment, contact details (for older youth), and active status.
- Date of birth is validated against the assigned section's age range, though edge cases produce a warning rather than a hard block.

### Deactivate and Re-activate Youth

- Administrators can deactivate a youth member, which requires providing a reason. The deactivation reason and date are recorded.
- Re-activation clears the deactivation reason and restores the youth to active status.

### Move Youth Between Groups

- Administrators can transfer a youth member from one group to another by selecting the target group, target section unit, effective date, and providing a reason.
- Move history is recorded and displayed on the youth's profile.

### Entsha Move (Section Transition)

- Administrators can process an Entsha move to advance a youth from one section to the next (Meerkat to Cub, Cub to Scout, or Scout to Rover).
- The youth's age must fall within the acceptable range for the target section. Sections cannot be skipped.
- Overriding an age validation requires super-admin or regional-admin confirmation.
- Notifications are sent to group leaders of both the source and target sections.
- The age tolerance for boundary cases is configurable.

### Youth Charges

- Administrators can view, add, and resolve charges (complaints or disciplinary matters) against youth members.
- Each charge records the date raised, type, description, who raised it, and status (open or resolved).
- Charges can be resolved by providing resolution notes and a resolution date.

### Bulk Actions

- Administrators can perform bulk actions on selected youth: sending bulk emails, bulk deactivation (with required reason), and CSV export.
- For youth under 18, bulk emails are routed to parent or guardian contacts rather than the youth's own contact details.

### Parent and Guardian Management

- Administrators can link existing users as parents or guardians to a youth member, or create new parent records.
- Parents can be unlinked without deleting the parent record.
- One parent or guardian can be designated as the primary contact.
- Each linked parent shows the relationship type, email, phone, and primary contact status.

### Attendance Card (Green Card)

- Administrators can view and record attendance data for youth members, tracking meetings attended, activities, and the recording leader.

### Profile Picture Upload

- Administrators can upload a new profile picture for a youth member (image files only, maximum 5 MB). Each picture change is logged, recording who made the change, when, and what the previous image was.

---

## Member Panel Requirements

The member panel provides limited youth management functionality to leaders, restricted to youth within their own group.

### Access Control

- All member panel youth pages require the user to hold an active leadership role (such as Group Scout Leader, Section Leader, or Assistant Leader) for the relevant group.
- Youth from other groups are never visible or accessible.

### View Youth Roster

- Leaders can view a list of youth in their own group, showing name, section, sub-unit, active status, and age.
- Filtering is available by section and active status, with search by name.

### Add and Edit Youth

- Leaders can add new youth members to their own group. The group and section are pre-filled based on the leader's active role.
- Leaders can edit personal details and sub-unit assignments for youth in their own group.
- Leaders cannot change group assignment, section assignment (which requires an Entsha move), or membership numbers.

### Record Attendance

- Leaders can record attendance for youth in their own section, with batch recording support to mark attendance for multiple youth in a single session.
- Each entry records the date, meeting or event type, attendance status (present, absent, or excused), and optional notes.

### Process Entsha Move

- Leaders can process Entsha moves for youth in their own group and section, following the same rules as the backoffice version.
- Age validation is enforced. Age overrides require a request to a regional or national administrator.

### Youth Charges

- Leaders can view open charges for youth in their own group and add new charges.
- Resolution of charges is restricted to the admin backoffice.

---

## Business Rules and Constraints

- Youth are distinguished from adults by their assigned role type; both share the same underlying member record.
- Each section has a defined age range. Entsha transitions must follow a sequential path (Meerkat to Cub to Scout to Rover) with no skipping.
- A configurable age tolerance (e.g., plus or minus 3 months) allows graceful handling of edge cases near age boundaries without requiring administrator intervention each time.
- Youth records (especially for those under 18) must comply with POPIA data protection requirements. Only authorised roles may export or view sensitive personal data.
- Bulk communications for youth under 18 must be routed through parent or guardian contact details, not the youth's own.
- Profile picture changes are fully audited, recording the previous image, the new image, who made the change, and when.
- Charge resolution is restricted to administrators; leaders can only raise and view charges.

# Feature: Adult Member System (AMS)

> Module: 01 — Adult Member System
> Status: Planned — Needs Human Review
> Depends on: Infrastructure (Done), Area Management (WIP), Role Management (WIP)

---

## Overview

The Adult Member System manages the full lifecycle of all adult Scouters within Scouts South Africa. Every adult in the system has a profile containing personal details, demographics, contact information, and authentication credentials. Adults can hold multiple simultaneous roles at different organisational levels (group, district, region, or national), and their active context in the member panel is always tied to a specific role assignment.

---

## Backoffice (Admin) Requirements

### User Management

- Administrators can browse, search, view, and edit all adult members across the entire organisation without geographic restriction.
- The user list displays key identifying information (name, known name, email, masked ID number, date of birth, active roles count, start date) and supports filtering by active status, role type, and geographic level with cascading region/district/group selectors.
- Global search covers first name, surname, email, and ID number.
- Super administrators can impersonate any user.

### View and Edit Profiles

- Administrators can view a member's full profile organised into tabs: personal details, contact information, demographics, roles, warrants, documents, police clearances, past service, and emergency contacts.
- All profile fields are editable by administrators, including identity details, contact information, demographics, dates, and profile photo.
- Email must be unique. ID numbers, if provided, must be exactly 13 digits. Date of birth must be at least 18 years in the past for adults. First name and surname are required.

### Activate and Deactivate

- Administrators can activate or deactivate a member's role assignment. Deactivation does not delete the user; it removes their access to the member panel.
- A confirmation dialog is shown before deactivation.

### Move Member Between Groups

- Administrators can transfer a member from one group to another through a guided process: selecting the target group, optionally assigning a new role type, and confirming the move. An audit trail record is created.
- Super administrators can move members across districts.

### Resign, Retire, Suspend, and Terminate

- Administrators can process four types of exit actions against a member's role: resignation, retirement, suspension, and termination.
- Each action requires a reason (selected from a predefined list), a date, and optional notes. Suspensions also require an end date.
- On confirmation, the member's role is marked accordingly, their access is removed (except for temporary suspensions), and a notification email is sent.

### Document Management

- Administrators can upload, view, download, and deactivate documents associated with a member (e.g., ID copies, medical certificates, proof of address).
- Each document has a type, description, and file attachment.

### Police Clearance Management

- Administrators can view, create, edit, and deactivate police clearance records for members.
- Each record includes the result, date completed, and an optional document attachment.
- Filtering is available by result type and date range.

### Past Service Records

- Administrators can manage historical service records for members, documenting prior roles at previous groups, districts, or regions.
- Each record includes the service type, geographic scope, date range, and optional supporting documents.
- Records for pre-system history can include free-text organisation names.

### Emergency Contacts

- Administrators can view and edit up to two emergency contacts per member, including name, phone numbers, and relationship.

---

## Member Panel Requirements

The member panel is scoped to the logged-in user's currently active role assignment. All pages operate within that context.

### View Own Profile

- Members can view their own profile in a read-only tabbed layout showing personal details, contact information, demographics, active roles, and emergency contacts.
- Members can navigate to edit their profile or report an issue.

### Edit Own Profile

- Members can edit a limited set of their own fields: known name, scout name, phone numbers, addresses, marital status, home language, English proficiency, and profile photo.
- Sensitive fields (email, ID/passport number, date of birth, role assignments, start date, date invested) require an administrator to change.

### View Own Documents

- Members can view their own active documents (type, description, upload date, download link) in read-only mode.
- Members cannot upload or manage documents; that is an admin-only function.

### View Own Past Service

- Members can view their own past service history (service type, organisation, date range) in read-only mode.
- Past service records are created and managed by administrators only.

---

## Business Rules and Constraints

- A member can hold multiple roles simultaneously at different organisational levels.
- Deactivating a role removes member panel access but does not delete the user record.
- Resignation, retirement, suspension, and termination each require a categorised reason and are tracked for audit purposes.
- Suspensions may be temporary (role remains but is suspended) or permanent (role is deactivated).
- Moving a member between groups deactivates the old role assignment and creates a new one in the target group.
- Members are limited in what personal data they can self-edit; identity fields and role assignments are managed exclusively by administrators.
- Document and past service management is restricted to administrators.

# Feature Spec: Adult Member System (AMS)

**Module:** 01 — Adult Member System
**Status:** Planned
**Depends on:** Infrastructure (Done), Area Management (WIP), Role Management (WIP)

---

## 1. Context

The Adult Member System manages the lifecycle of all adult Scouters within Scouts South Africa. An adult is represented as a `SystemUser` record. Their "membership" at any given organisational level is tracked through active `SystemUsersOtherRole` pivot records that associate a user to a `SystemUserType` (role definition) at a specific geographic level (group / district / region / national).

The legacy equivalent is spread across `ams-adult-*.php` files and `user-*.php` profile files. All data lives in the `sd-core` database and must be accessed through the Eloquent models described below.

A user can hold **multiple simultaneous roles** at different levels. The Filament general panel uses `SystemUsersOtherRole` as the tenant, so the user's active context is always a specific role attachment.

---

## 2. Key Models

### `SystemUser` — `system_users`
The core user record. Holds all personal details, demographics, contact information, and authentication credentials.

Key fields: `first_name`, `surname`, `knownName`, `username` (email), `idNumber`, `passportNumber`, `sex` (enum), `race` (enum), `dob`, `title` (enum), `startDate`, `dateInvested`, `photo`, `thumb`.

Relationships:
- `otherRoles(): HasMany` → `SystemUsersOtherRole`
- `activeRoles(): HasMany` → `SystemUsersOtherRole` (filtered `active = 1`)
- `emergencyContacts(): HasMany` → `SystemUsersEmergencyContact`
- `documents(): HasMany` → `AmsDocument`
- `policeClearances(): HasMany` → `AmsPoliceClearance`
- `pastService(): HasMany` → `AmsPastServiceInfo`
- `warrants(): HasMany` → `AmsWarrantInfo`

### `SystemUserType` — `system_user_types`
Defines a role type (e.g., "Group Scout Leader", "District Commissioner"). Has boolean flags for every geographic level and every permission domain.

Key permission flags: `nationalRole`, `regionalRole`, `districtRole`, `groupRole`, `warrantedRole`, `canAdminGroup`, `canAdminDistrict`, `canAdminRegion`, `canAdminNational`, `canSignWarrants`, `canAdminPoliceClearance`, `requiresCriminalClearance`.

### `SystemUsersOtherRole` — `system_users_other_roles`
The pivot between a user and a role type, scoped to a geographic level. This is the Filament tenant model for the general panel.

Key fields: `userID`, `roleID`, `regionID`, `districtID`, `groupID`, `defaultRole`, `active`, `retired`, `resigned`, `suspended`, `creationNotes`.

Relationships: `user()`, `role()`, `region()`, `district()`, `group()`, `superDistrict()`.
Computed attributes: `roleTypeName`, `roleScopedModel`, `roleScopedFullLabel`, `getFilamentName()`.

### `AmsMaritalStatus` — `ams_marital_status`
Lookup table: id, name. Used as a dropdown on the profile edit form.

### `AmsHighestEducation` — (lookup table)
Lookup table: id, name. Highest level of formal education attained.

### `AmsLanguage` — (lookup table)
Lookup table: id, name. Home language / primary language.

### `AmsPastServiceInfo` — `ams_past_service_info`
Historical service record for a user at a previous group/district/region.

Key fields: `userID`, `pastServiceType`, `assocToRegion`, `assocToDistrict`, `assocToGroup`, `startDate`, `endDate`, `otherRegionName`, `otherDistrictName`, `otherGroupName`, `PDFLocation`.

### `AmsPastServiceType` — lookup table for past service categories.

### `AmsPoliceClearance` — `ams_police_clearance`
A police clearance check record for a user.

Key fields: `userID`, `result`, `documentLocation`, `dateDone`, `active`.

### `AmsCriminalCheck` — criminal check record (similar shape to police clearance).

### `AmsDocument` — `ams_documents`
A document uploaded and linked to a user.

Key fields: `userID`, `documentTypeID`, `description`, `PDFLocation`, `assocToRegion`, `assocToDistrict`, `assocToGroup`, `active`.

### `AmsDocumentType` — `ams_document_types`
Lookup for document categories (e.g., "ID Copy", "Medical Certificate", "Proof of Address").

### `SystemUsersEmergencyContact` — `system_users_emergency_contacts`
Up to two emergency contacts per user.

Key fields: `userID`, `contact1Title`, `contact1FirstName`, `contact1Surname`, `contact1Cell`, `contact1Relationship`, `contact2Title`, `contact2FirstName`, `contact2Cell`, `contact2Relationship`.

### Status-tracking models
These record the outcome of an exit/suspension action against a user's role:

| Model | Table | Key fields |
|-------|-------|-----------|
| `AmsResignLeader` | `ams_resign_leader` | `userID`, `roleID`, `resignReasonID`, `resignDate`, `notes` |
| `AmsRetireLeader` | `ams_retire_leader` | `userID`, `roleID`, `retireReasonID`, `retireDate`, `notes` |
| `AmsSuspendLeader` | `ams_suspend_leader` | `userID`, `roleID`, `suspendReasonID`, `suspendDate`, `suspendEndDate`, `notes` |
| `AmsTerminateLeader` | `ams_terminate_leader` | `userID`, `roleID`, `terminateReasonID`, `terminateDate`, `notes` |

Each has a corresponding reason lookup model: `AmsResignReason`, `AmsRetireReason`, `AmsSuspendReason`, `AmsTerminateReason`.

---

## 3. Backoffice Panel (Admin) Requirements

The admin panel provides system-wide management of all adult members without geographic restriction. All pages below live under the `AdminPanelProvider` at `/backoffice`.

---

### 3.1 Manage All Users

**Resource:** `App\Filament\Admin\Resources\Users\UserResource`
**Page type:** `ListRecords` (index) + `ViewRecord` + `EditRecord`
**Route:** `/backoffice/users`

**Table columns:**
- Full name (`first_name surname`)
- Known name (`knownName`) — shown as badge if different
- Username (email)
- ID number (masked)
- Date of birth
- Active roles count (count of active `SystemUsersOtherRole` records)
- Start date
- Created at

**Table filters:**
- Active / inactive (filter on whether the user has any `active = 1` role)
- Role type (select from `SystemUserType`)
- Geographic level (national / regional / district / group)
- Region (cascading from level filter)
- District (cascading from region)
- Group (cascading from district)

**Table actions:**
- View (row click → ViewRecord)
- Edit (icon button → EditRecord)
- Impersonate (stechstudio/filament-impersonate; super admin only)

**Global search:** `first_name`, `surname`, `username`, `idNumber`

---

### 3.2 View Full User Profile

**Page type:** `ViewRecord`
**Route:** `/backoffice/users/{record}`

Displayed using a `Schema` infolist with tabbed layout:

| Tab | Content |
|-----|---------|
| **Personal** | Title, first name, other name, surname, previous surname, known name, scout name, sex, race, date of birth, ID number, passport number, passport country |
| **Contact** | Username (email), cell number, home number, work number, physical address, postal address |
| **Demographics** | Marital status, home language, highest education, English proficiency, branch type |
| **Roles** | `RepeatableEntry` of all `SystemUsersOtherRole` records — role name, level, geographic scope, active flag, dates |
| **Warrants** | `RepeatableEntry` of `AmsWarrantInfo` records — warrant type, number, issue/expiry date, active flag |
| **Documents** | `RepeatableEntry` of `AmsDocument` records — type, description, upload date, download link |
| **Police Clearance** | `RepeatableEntry` of `AmsPoliceClearance` records — result, date done, document link |
| **Past Service** | `RepeatableEntry` of `AmsPastServiceInfo` records — service type, group/district, dates |
| **Emergency Contacts** | `Section` showing contact 1 and contact 2 details |

**Header actions:**
- Edit profile
- Impersonate (super admin only)

---

### 3.3 Edit User Profile

**Page type:** `EditRecord`
**Route:** `/backoffice/users/{record}/edit`

All fields from the view page are editable. Key form sections:

| Section | Fields |
|---------|--------|
| **Identity** | Title (select), first name, other name, surname, previous surname, known name, scout name |
| **Personal** | Sex (select enum), race (select enum), date of birth (date picker), ID number, passport number, passport country (select) |
| **Contact** | Username/email (unique), cell, home, work numbers, full physical + postal address |
| **Demographics** | Marital status (select `AmsMaritalStatus`), language (select `AmsLanguage`), highest education (select `AmsHighestEducation`), English proficiency (select enum), branch type (select enum) |
| **Dates** | Start date, date invested |
| **Photo** | Profile photo upload (stored via Laravel Storage) |

**Validation rules:**
- `username` — required, email format, unique in `system_users` excluding current record
- `idNumber` — optional, must be 13 digits if provided
- `dob` — required, must be in the past, must be at least 18 years ago for adults
- `first_name`, `surname` — required, max 100 characters

---

### 3.4 Activate / Deactivate User

**Trigger:** Table row action or view page header action (modal confirmation)
**Implementation:** Sets `active = 1` or `active = 0` on the relevant `SystemUsersOtherRole` record(s). Does not delete the user.
**Modal confirmation:** "Are you sure you want to deactivate [name]? This will remove their access to the general panel."

---

### 3.5 Move Member Between Groups

**Trigger:** Header action on ViewRecord page
**Page:** Custom action modal (wizard or multi-step form)

**Steps:**
1. Select target group (searchable select of `Group` records, scoped to same district or cross-district if super admin)
2. Optionally select target role type in the new group
3. Confirm — creates a new `SystemUsersOtherRole` for the new group, deactivates the old one
4. Optionally creates an `AmsAdultLeaderMove` record for audit trail

---

### 3.6 Resign / Retire / Suspend / Terminate

Each action follows the same pattern:

**Trigger:** Header action on ViewRecord page (separate actions per type)
**Page:** Confirmation modal with:
- Reason (select from appropriate lookup: `AmsResignReason` / `AmsRetireReason` / `AmsSuspendReason` / `AmsTerminateReason`)
- Date (date picker, defaults to today)
- Notes (optional textarea)
- For suspend: suspension end date (date picker)

**On confirm:**
1. Creates the relevant record (`AmsResignLeader` / `AmsRetireLeader` etc.) with all supplied fields
2. Sets `resigned = 1` / `retired = 1` / `suspended = 1` on the `SystemUsersOtherRole` record
3. Sets `active = 0` on the `SystemUsersOtherRole` record (except temporary suspend)
4. Fires a queued notification email to the user

---

### 3.7 Document Management

**Resource:** Embedded `RelationManager` on `UserResource` (or standalone within AMS cluster)
**Model:** `AmsDocument`

**List columns:** Document type name, description, created at, active flag, download button
**Create form fields:** Document type (select `AmsDocumentType`), description (text), file upload (PDF/image, stored via Laravel Storage), active (toggle)
**Actions:** View/download, edit, deactivate (soft-delete via `active = 0`)

---

### 3.8 Police Clearance Management

**Resource:** `App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\PoliceClearanceResource`
**Route:** `/backoffice/ams/police-clearances`

**Table columns:** User full name, result, date done, active, document download link
**Filters:** Result (clear / flagged), date range
**Create/Edit form:** User (searchable select), result (text), date done (date picker), document upload, active toggle
**Actions:** View, edit, deactivate

---

### 3.9 Past Service Records

**Resource:** `App\Filament\Admin\Clusters\AMS\Resources\PastService\PastServiceResource`
**Route:** `/backoffice/ams/past-service`

**Table columns:** User full name, service type, group/district/region, start date, end date, active
**Create/Edit form fields:** User (searchable select), service type (select `AmsPastServiceType`), geographic scope (region/district/group selects), start date, end date, other region/district/group names (for pre-system history), document upload, active toggle
**Actions:** View, edit, deactivate

---

### 3.10 Emergency Contacts

**Implementation:** `RelationManager` on `UserResource` using `SystemUsersEmergencyContact`
**Display:** Two-contact layout showing title, name, cell, home, work, relationship for each contact
**Edit:** Inline form within the relation manager
**Note:** The database schema stores both contacts on a single row; the form must handle this accordingly.

---

## 4. General Panel Requirements

The general panel is tenant-aware. All pages operate in the context of the authenticated user's currently active `SystemUsersOtherRole` tenant. Route prefix: `/general/{tenant}`.

---

### 4.1 View Own Profile

**Page:** `App\Filament\General\Pages\ViewProfile` (already scaffolded)
**Route:** `/general/{tenant}/profile`

Displays the authenticated user's own `SystemUser` record using a tabbed infolist. All fields are read-only. Already implemented tabs:

- Profile (personal details, photo)
- Contact details
- Demographics
- Role summary (active roles)
- Emergency contacts

**Actions available:**
- "Edit Profile" button → navigate to EditProfile
- "Report an Issue" modal → sends `ReportIssueEmail`

---

### 4.2 Edit Own Profile

**Page:** `App\Filament\General\Pages\EditProfile` (already scaffolded)
**Route:** `/general/{tenant}/profile/edit`

Allows the user to edit only the fields they are permitted to self-manage. Fields that require admin intervention (e.g., ID number, start date, roles) are not shown on this form.

**Editable fields:**
- Known name, scout name
- Cell / home / work numbers
- Physical address, postal address
- Marital status, home language, English proficiency
- Profile photo

**Not editable by self:**
- Username/email (requires admin)
- ID / passport number (requires admin)
- Date of birth (requires admin)
- Role assignments (requires admin)
- Start date / date invested (requires admin)

---

### 4.3 View Own Documents

**Page:** Read-only tab or section within `ViewProfile`
**Content:** List of `AmsDocument` records where `userID = auth()->id()` and `active = 1`
**Display:** Document type name, description, upload date, download link
**Note:** No upload capability; document management is admin-only.

---

### 4.4 View Own Past Service

**Page:** Read-only tab or section within `ViewProfile`
**Content:** List of `AmsPastServiceInfo` records where `userID = auth()->id()` and `active = 1`
**Display:** Service type, organisation, start date, end date
**Note:** Read-only; past service records are created by admins.

---

## 5. Tests Required

All tests must extend `Tests\Support\SdCoreTestCase` and use PHPUnit v11 attributes (`#[Test]`, `#[DataProvider]`).

---

### `Tests\Feature\Filament\AmsUserManagementTest`

**Happy paths:**

| Method | Asserts |
|--------|---------|
| `super_admin_can_view_user_list` | `->get(UserResource::getUrl('index'))->assertOk()` |
| `super_admin_can_view_user_profile` | `->get(UserResource::getUrl('view', ['record' => $user]))->assertOk()` |
| `super_admin_can_edit_user_profile` | `->get(UserResource::getUrl('edit', ['record' => $user]))->assertOk()` |
| `super_admin_can_save_edited_profile` | Livewire form fill + call save, assert record updated in DB |
| `super_admin_can_deactivate_user_role` | Assert `SystemUsersOtherRole` `active = 0` after action |
| `super_admin_can_activate_user_role` | Assert `SystemUsersOtherRole` `active = 1` after action |

**Forbidden paths:**

| Method | Asserts |
|--------|---------|
| `regular_user_cannot_access_user_list` | `->get(UserResource::getUrl('index'))->assertForbidden()` |
| `regular_user_cannot_view_other_user_profile_in_admin` | `assertForbidden()` on admin view URL |
| `guest_is_redirected_from_user_list` | `->get(UserResource::getUrl('index'))->assertRedirect()` |

**Validation failures:**

| Method | Asserts |
|--------|---------|
| `edit_fails_when_email_is_not_unique` | Submit form with duplicate username, assert validation error on `username` field |
| `edit_fails_when_id_number_is_wrong_length` | Submit 12-digit ID number, assert validation error |
| `edit_fails_when_first_name_is_missing` | Assert validation error on `first_name` |

---

### `Tests\Feature\Filament\AmsMemberActionsTest`

**Happy paths:**

| Method | Asserts |
|--------|---------|
| `super_admin_can_resign_a_member` | Assert `AmsResignLeader` record created; `SystemUsersOtherRole.resigned = 1` |
| `super_admin_can_retire_a_member` | Assert `AmsRetireLeader` record created; `SystemUsersOtherRole.retired = 1` |
| `super_admin_can_suspend_a_member` | Assert `AmsSuspendLeader` record created; `SystemUsersOtherRole.suspended = 1` |
| `super_admin_can_terminate_a_member` | Assert `AmsTerminateLeader` record created; `SystemUsersOtherRole.active = 0` |
| `super_admin_can_move_member_to_another_group` | Assert old role deactivated; new `SystemUsersOtherRole` created in target group |

**Forbidden paths:**

| Method | Asserts |
|--------|---------|
| `regular_user_cannot_resign_another_member` | Action returns 403 |
| `regular_user_cannot_move_another_member` | Action returns 403 |

**Validation failures:**

| Method | Asserts |
|--------|---------|
| `resign_fails_without_reason` | Assert validation error on `resignReasonID` |
| `resign_fails_without_date` | Assert validation error on `resignDate` |
| `suspend_fails_without_end_date` | Assert validation error on `suspendEndDate` |

---

### `Tests\Feature\Filament\AmsDocumentTest`

| Method | Asserts |
|--------|---------|
| `super_admin_can_view_documents_for_user` | Police clearance list page loads with user's documents |
| `super_admin_can_upload_document` | `AmsDocument` record created after form submit |
| `regular_user_cannot_manage_documents_in_admin` | `assertForbidden()` |
| `user_can_view_own_documents_in_general_panel` | Document list visible in ViewProfile |
| `user_cannot_see_other_users_documents_in_general_panel` | Documents filtered to `auth()->id()` |

---

### `Tests\Feature\Filament\AmsPoliceClearanceTest`

| Method | Asserts |
|--------|---------|
| `super_admin_can_view_police_clearance_list` | `PoliceClearanceResource::getUrl('index')` → `assertOk()` |
| `super_admin_can_create_police_clearance` | `AmsPoliceClearance` record created with correct `userID` |
| `regular_user_is_forbidden_from_police_clearance_list` | `assertForbidden()` |
| `police_clearance_requires_result_and_date` | Missing fields return validation errors |

---

### `Tests\Feature\Filament\AmsPastServiceTest`

| Method | Asserts |
|--------|---------|
| `super_admin_can_view_past_service_list` | `PastServiceResource::getUrl('index')` → `assertOk()` |
| `super_admin_can_create_past_service_record` | `AmsPastServiceInfo` record created |
| `regular_user_is_forbidden_from_past_service_admin` | `assertForbidden()` |
| `user_can_view_own_past_service_in_general_panel` | Past service visible in profile page |

---

### `Tests\Feature\Filament\GeneralPanelProfileTest`

| Method | Asserts |
|--------|---------|
| `authenticated_user_with_role_can_view_own_profile` | ViewProfile page returns `assertOk()` |
| `authenticated_user_with_role_can_access_edit_profile` | EditProfile page returns `assertOk()` |
| `user_cannot_view_another_users_profile_in_general_panel` | Attempt to access another user's profile returns `assertForbidden()` or redirects |
| `guest_is_redirected_from_general_panel_profile` | `assertRedirect()` |
| `edit_profile_saves_allowed_fields` | Known name, cell, language updated correctly |
| `edit_profile_does_not_expose_admin_only_fields` | Form does not contain `idNumber`, `startDate`, `username` fields |

# Feature Spec: Warrants

**Module:** 02 — Warrants
**Status:** Scaffolded — `WarrantResource` (list + view) exists; full management not yet built
**Depends on:** Adult Member System (01), Area Management (11), Role Management

---

## 1. Context

A **warrant** is the formal appointment document that authorises an adult to hold a specific role within Scouts South Africa. Every warranted role requires a valid, active warrant before the adult is considered fully appointed.

Warrants are managed at five geographic levels:

| Level | Scope | Example role |
|-------|-------|-------------|
| **National** | Applies nationwide | Chief Scout Commissioner |
| **Regional** | Scoped to a `Region` | Regional Commissioner |
| **District** | Scoped to a `District` | District Commissioner |
| **Group** | Scoped to a `Group` | Group Scout Leader |
| **Section** | Scoped to a section within a Group | Cub Master |

A warrant has a start date (`issueDate`) and optional expiry date (`expireDate`). The system sends automated expiry notifications (90, 60, and 30 days before expiry, and on the day of expiry). Warrants can be cancelled, extended, or disabled independently of the member's active role status.

The legacy equivalents are `ams-warrant-*.php` and `reports-warrants*.php` files.

---

## 2. Key Models

### `AmsWarrantInfo` — `ams_warrant_info`
The primary warrant record.

Key fields:
- `userID` — the warranted person (`SystemUser`)
- `roleID` — the `SystemUserType` this warrant is for
- `warrantTypeID` — the `AmsWarrantType` classification
- `warrantNr` — warrant reference number (string)
- `warrantName` — human-readable description
- `assocToRegion` / `assocToDistrict` / `assocToGroup` — geographic scope (only the relevant level is populated)
- `issueDate` — date warrant was issued
- `expireDate` — optional expiry date (null = no expiry)
- `limited` — boolean flag for limited appointments
- `appointment` — boolean flag for appointment-only (no full warrant)
- `PDFLocation` — stored warrant PDF path
- `cancellationTypeID` — set when cancelled
- `cancelationNotes` — cancellation narrative (note: intentional legacy typo in column name)
- `expireEmailCount` — tracks how many expiry reminder emails have been sent
- `active` — `1` = active, `0` = cancelled/disabled/expired

Relationships: `user()`, `role()`, `warrantType()`, `cancellationType()`, `region()`, `district()`, `group()`.

### `AmsWarrantType` — `ams_warrant_types`
Defines a classification of warrant. The boolean flags `national`, `region`, `district`, `group` declare which geographic levels this warrant type is valid at.

Key fields: `name`, `shortName`, `description`, `national`, `region`, `district`, `group`, `active`, `position`.

Relationships: `warrants(): HasMany`, `applications(): HasMany`.

### `AmsWarrantApplication` — `ams_warrant_applications`
A pending application for a warrant, submitted by or on behalf of an adult before the warrant is formally issued.

Key fields: `userID`, `warrantTypeID`, `assocToRegion`, `assocToDistrict`, `assocToGroup`, `awardDate`, `awardedBy`, `declinedDate`, `declinedBy`, `awardType`, `awardDescription`, `active`, `PDFLocation`.

Relationships: `user()`, `warrantType()`, `region()`, `district()`, `group()`, `awardedBy()`, `declinedBy()`.

### `AmsWarrantExtension` — `ams_warrant_extensions`
Records a single extension event for an existing warrant — preserving the old expiry date and recording the new one.

Key fields: `warrantID`, `userID`, `oldExpireDate`, `newExpireDate`, `assocToRegion`, `assocToDistrict`, `assocToGroup`, `PDFLocation`, `active`.

Relationships: `warrant()`, `user()`, `region()`, `district()`, `group()`.

### `AmsWarrantCancellationType` — `ams_warrant_cancellation_types`
Lookup table of reasons a warrant can be cancelled.

Key fields: `name`, `active`.

Relationships: `warrants(): HasMany`.

---

## 3. Backoffice Panel (Admin) Requirements

All warrant management pages live under the `AmsCluster` at `/backoffice/ams/`.

---

### 3.1 Warrant Management (All Levels)

**Resource:** `App\Filament\Admin\Clusters\AMS\Resources\Warrants\WarrantResource` (already scaffolded)
**Current state:** `ListWarrants` and `ViewWarrant` pages exist.
**Required extensions:** Add `CreateWarrant`, `EditWarrant`, cancel/extend/disable actions.

**List page** (`/backoffice/ams/warrants`):

Table columns:
- Warrant number (`warrantNr`)
- User full name (relationship column)
- Warrant type name (relationship column)
- Geographic level (computed from `assocToRegion` / `assocToDistrict` / `assocToGroup`)
- Geographic scope name (region/district/group name)
- Issue date
- Expiry date (with visual indicator: red if expired, amber if expiring within 90 days, green if valid)
- Active (icon column)

Table filters:
- Active / inactive / all
- Warrant type (select `AmsWarrantType`)
- Geographic level (national / regional / district / group)
- Region (select)
- District (select, cascading from region)
- Group (select, cascading from district)
- Expiring within: 30 / 60 / 90 days (date-range shortcut filter)

**View page** (`/backoffice/ams/warrants/{record}`):

Infolist sections:
- Warrant details (number, name, type, issue date, expiry date, limited flag, appointment flag)
- Warranted person (user name, link to user profile)
- Geographic scope (level, region/district/group name)
- Cancellation details (shown only if cancelled: type, notes)
- Extension history (`RepeatableEntry` of `AmsWarrantExtension` records)
- PDF download link (if `PDFLocation` is set)

---

### 3.2 Add Warrant

**Page type:** `CreateRecord`
**Route:** `/backoffice/ams/warrants/create`

Form fields:
- User (searchable select `SystemUser`)
- Warrant type (select `AmsWarrantType` — filtered to `active = 1`)
- Geographic level (radio: National / Regional / District / Group — determines which scope fields appear below)
- Region (conditional select, shown when level = Regional or lower)
- District (conditional select, cascading from region)
- Group (conditional select, cascading from district)
- Issue date (date picker, defaults to today)
- Expiry date (optional date picker)
- Warrant number (text input — may be auto-generated)
- Warrant name (text input)
- Limited appointment (toggle)
- Appointment only (toggle)
- PDF upload (optional)

**Validation:**
- Warrant type must be valid for the selected geographic level (e.g., a type with `group = 0` cannot be issued at group level)
- Issue date must not be in the future unless specifically allowed
- Expiry date must be after issue date if provided

---

### 3.3 Edit Warrant

**Page type:** `EditRecord`
**Route:** `/backoffice/ams/warrants/{record}/edit`

Same fields as create. Editing is restricted to: warrant name, expiry date, PDF upload, warrant number. Changing user, type, or geographic scope requires cancelling and re-issuing.

---

### 3.4 Cancel Warrant

**Trigger:** Table row action or ViewRecord header action
**Type:** Confirmation modal with form fields

Modal form:
- Cancellation type (select `AmsWarrantCancellationType`)
- Cancellation notes (optional textarea)

On confirm:
1. Sets `cancellationTypeID` and `cancelationNotes` on the `AmsWarrantInfo` record
2. Sets `active = 0`
3. Fires queued notification to the warranted user

---

### 3.5 Extend Warrant

**Trigger:** ViewRecord header action (only visible if warrant is active and has an expiry date)
**Type:** Modal with form fields

Modal form:
- New expiry date (date picker — must be after current `expireDate`)
- Notes (optional textarea)

On confirm:
1. Creates an `AmsWarrantExtension` record preserving the old expiry date
2. Updates `AmsWarrantInfo.expireDate` to the new date
3. Resets `expireEmailCount = 0` so the notification cycle restarts
4. Fires queued notification to the warranted user

---

### 3.6 Disable Warrant

**Trigger:** Table row action (bulk action available for super admin)
**Type:** Confirmation modal (no additional fields)

On confirm: sets `active = 0` without setting a cancellation type (distinguishes "disabled" from "cancelled").

---

### 3.7 View Warrant Applications

**Resource:** New resource `App\Filament\Admin\Clusters\AMS\Resources\Warrants\WarrantApplicationResource`
**Route:** `/backoffice/ams/warrant-applications`

Table columns: User full name, warrant type, geographic scope, application date (created), status (pending / approved / declined), awarded/declined by, awarded/declined date.

Filters: Status (pending / approved / declined / all), warrant type, geographic level.

---

### 3.8 Approve / Reject Warrant Application

**Trigger:** Table row actions on WarrantApplicationResource list
**Approve action:**
1. Confirmation modal with award date (date picker) and notes
2. Sets `awardDate`, `awardedBy = auth()->id()` on `AmsWarrantApplication`
3. Creates `AmsWarrantInfo` record from the application details
4. Fires queued approval notification to the applicant

**Reject action:**
1. Confirmation modal with decline reason (textarea)
2. Sets `declinedDate`, `declinedBy = auth()->id()`, `active = 0` on `AmsWarrantApplication`
3. Fires queued rejection notification to the applicant

---

### 3.9 Manage Warrant Types (CRUD Lookup)

**Resource:** `App\Filament\Admin\Clusters\AMS\Resources\Lookups\WarrantTypes\WarrantTypeResource` (already built)
**Route:** `/backoffice/ams/warrant-types`
**Page type:** `ManageRecords` (create/edit/delete inline on list page)

Form fields: name, short name, description (textarea), national (toggle), region (toggle), district (toggle), group (toggle), active (toggle).

---

### 3.10 Manage Cancellation Types (CRUD Lookup)

**Resource:** `App\Filament\Admin\Clusters\AMS\Resources\Lookups\WarrantCancellationTypes\WarrantCancellationTypeResource`
**Route:** `/backoffice/ams/warrant-cancellation-types`
**Page type:** `ManageRecords`

Form fields: name, active (toggle).

---

### 3.11 Reports: Warrants Expiring

**Page type:** Custom `Page` (not a resource — read-only report)
**Route:** `/backoffice/ams/reports/warrants-expiring`

Displays a table of `AmsWarrantInfo` records where `expireDate` is within a configurable window (30 / 60 / 90 days from today) and `active = 1`.

Table columns: User name, warrant type, geographic scope, expiry date, days until expiry, expiry email count.
Filters: Days window (30 / 60 / 90), geographic level, region, district.
Export: Excel download of filtered results.

---

### 3.12 Reports: Warrants by Type / Level / Region

**Page type:** Custom `Page`
**Route:** `/backoffice/ams/reports/warrants`

Filterable summary table:
- Filter by warrant type
- Filter by geographic level
- Filter by region / district
- Filter by active / inactive

Grouped results showing count of active warrants per type per level. Link through to filtered WarrantResource list.

---

## 4. Member Panel Requirements

### 4.1 View Own Warrants

**Page:** Tab within `ViewProfile` or dedicated page `App\Filament\Member\Pages\MyWarrants`
**Route:** `/member/{tenant}/my-warrants`

Displays all `AmsWarrantInfo` records where `userID = auth()->id()` ordered by `issueDate` descending.

Columns: Warrant type name, warrant number, geographic scope, issue date, expiry date (with status badge: Active / Expired / Expiring Soon), PDF download link.

Filters: Active / expired / all.

---

### 4.2 View Warrant Details

**Page:** ViewRecord within the member panel's warrant resource (read-only)
**Route:** `/member/{tenant}/my-warrants/{record}`

Shows full warrant infolist (same fields as admin ViewRecord). No edit actions. No cancel/extend actions.

Access control: User can only view their own warrants. Attempting to view another user's warrant ID returns `403 Forbidden`.

---

### 4.3 Apply for a Warrant

**Page:** Create page within the member panel's warrant resource
**Route:** `/member/{tenant}/my-warrants/apply`

Allows the authenticated user to submit an `AmsWarrantApplication` for themselves.

Form fields:
- Warrant type (select `AmsWarrantType`, filtered to types valid for the user's current tenant geographic level)
- Geographic scope (pre-populated from the user's current tenant — region/district/group)
- Notes / motivation (textarea)

On submit:
1. Creates `AmsWarrantApplication` with `userID = auth()->id()` and geographic scope from tenant context
2. Fires notification email to the appropriate approver (determined by level)
3. Shows success notification: "Your warrant application has been submitted and is pending review."

---

## 5. Cron / Queue Jobs

### `App\Jobs\Warrants\SendWarrantExpiryNotificationsJob`

**Schedule:** Daily (registered in `routes/console.php` or `bootstrap/app.php`)
**Logic:**
1. Query `AmsWarrantInfo` where `active = 1` and `expireDate` is not null and falls within the next 90 days
2. For each warrant, check `expireEmailCount` to determine which notification tier to send (first email at 90 days, second at 60, third at 30, fourth on expiry day)
3. Dispatch a queued `WarrantExpiryNotification` mailable to the warranted user
4. Increment `expireEmailCount` on the record

**Notification tiers:**

| `expireEmailCount` | Days before expiry | Email subject |
|--------------------|-------------------|--------------|
| 0 | ~90 | Your warrant expires in approximately 90 days |
| 1 | ~60 | Your warrant expires in approximately 60 days |
| 2 | ~30 | Your warrant expires in approximately 30 days |
| 3 | 0 (expiry day) | Your warrant has expired today |

### `App\Jobs\Warrants\SendMonthlyWarrantExpiryReportJob`

**Schedule:** First day of each month
**Logic:**
1. Compile a report of all warrants expiring in the next 90 days, grouped by region
2. For each region, email the regional commissioner(s) the report for their region
3. Send a consolidated national report to national admins (identified by `national_support_role_ids` in `GeneralSettings`)

---

## 6. Tests Required

All tests must extend `Tests\Support\SdCoreTestCase`.

---

### `Tests\Feature\Filament\WarrantManagementTest`

**Super admin access — happy paths:**

| Method | Asserts |
|--------|---------|
| `super_admin_can_view_warrant_list` | `WarrantResource::getUrl('index')` → `assertOk()` |
| `super_admin_can_view_warrant_detail` | `WarrantResource::getUrl('view', ['record' => $warrant])` → `assertOk()` |
| `super_admin_can_access_create_warrant_page` | `WarrantResource::getUrl('create')` → `assertOk()` |
| `super_admin_can_create_warrant` | Form fill + submit; assert `AmsWarrantInfo` record created in DB |
| `super_admin_can_cancel_warrant` | Cancel action; assert `active = 0` and `cancellationTypeID` set |
| `super_admin_can_extend_warrant` | Extend action; assert `AmsWarrantExtension` created; `expireDate` updated; `expireEmailCount = 0` |
| `super_admin_can_disable_warrant` | Disable action; assert `active = 0` and no `cancellationTypeID` set |
| `super_admin_can_view_warrant_applications` | `WarrantApplicationResource::getUrl('index')` → `assertOk()` |
| `super_admin_can_approve_warrant_application` | Approve action; assert `awardDate` set; `AmsWarrantInfo` record created |
| `super_admin_can_reject_warrant_application` | Reject action; assert `declinedDate` set; `active = 0` on application |

**Forbidden access — regular user:**

| Method | Asserts |
|--------|---------|
| `regular_user_is_forbidden_from_warrant_list` | `->get(WarrantResource::getUrl('index'))->assertForbidden()` |
| `regular_user_is_forbidden_from_create_warrant` | `->get(WarrantResource::getUrl('create'))->assertForbidden()` |
| `regular_user_is_forbidden_from_warrant_applications` | `assertForbidden()` |
| `guest_is_redirected_from_warrant_list` | `->get(WarrantResource::getUrl('index'))->assertRedirect()` |

---

### `Tests\Feature\Filament\MemberPanelWarrantTest`

| Method | Asserts |
|--------|---------|
| `user_can_view_own_warrants_in_member_panel` | My warrants page returns `assertOk()` with user's warrants listed |
| `user_cannot_view_another_users_warrant` | Attempt to access warrant with `userID != auth()->id()` returns `assertForbidden()` |
| `user_can_submit_warrant_application` | `AmsWarrantApplication` created with correct `userID` and geographic scope from tenant |
| `warrant_application_form_only_shows_types_valid_for_level` | Group-level tenant; form only shows types with `group = 1` |

---

### `Tests\Feature\Jobs\WarrantExpiryNotificationTest`

| Method | Asserts |
|--------|---------|
| `job_sends_first_notification_for_warrant_expiring_in_90_days` | Warrant with `expireDate = today + 90`, `expireEmailCount = 0`; job fires; mail sent; `expireEmailCount = 1` |
| `job_sends_second_notification_for_warrant_expiring_in_60_days` | Warrant with `expireDate = today + 60`, `expireEmailCount = 1`; job fires; mail sent; `expireEmailCount = 2` |
| `job_does_not_send_notification_for_inactive_warrant` | Warrant with `active = 0`; job fires; no mail sent |
| `job_does_not_send_notification_when_no_expiry_date` | Warrant with `expireDate = null`; job fires; no mail sent |
| `job_does_not_resend_after_all_tiers_complete` | Warrant with `expireEmailCount = 4`; job fires; no mail sent |

---

### `Tests\Feature\Filament\WarrantValidationTest`

| Method | Asserts |
|--------|---------|
| `create_warrant_fails_when_type_does_not_match_group_level` | `AmsWarrantType` with `group = 0` submitted for group-level warrant; assert validation error |
| `create_warrant_fails_when_expiry_is_before_issue_date` | `expireDate < issueDate`; assert validation error on `expireDate` |
| `create_warrant_fails_when_user_not_provided` | Missing `userID`; assert validation error |
| `extend_warrant_fails_when_new_date_is_before_current_expiry` | New expiry date earlier than current; assert validation error |
| `cancel_warrant_fails_without_cancellation_type` | Missing `cancellationTypeID`; assert validation error |

---

### `Tests\Feature\Filament\WarrantLookupTest`

These extend the existing `AmsClusterTest` pattern using `#[DataProvider]`.

| Method | Asserts |
|--------|---------|
| `super_admin_can_access_warrant_types_lookup` | `WarrantTypeResource::getUrl('index')` → `assertOk()` |
| `super_admin_can_create_warrant_type` | `ManageWarrantTypes` form create; assert `AmsWarrantType` created |
| `super_admin_can_access_cancellation_types_lookup` | `WarrantCancellationTypeResource::getUrl('index')` → `assertOk()` |
| `super_admin_can_create_cancellation_type` | Form create; assert `AmsWarrantCancellationType` created |
| `regular_user_is_forbidden_from_warrant_type_management` | `assertForbidden()` |

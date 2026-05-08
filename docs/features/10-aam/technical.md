# Feature Spec: Adult Application for Membership (AAM)

> Module: AAM — Adult Application for Membership
> Panel(s): Admin (backoffice), Member (public-facing form)
> Status: WIP (~40%)
> Phase: 2 — Adult Lifecycle

---

## Overview

The AAM is a new workflow with no equivalent in the legacy system. It allows prospective adult members to apply online without requiring an existing account. Applications are routed to the appropriate level (group, district, regional, or national) based on email configuration stored in `FormSettings`. Once reviewed, approved applicants can be converted into `SystemUser` records and assigned an initial role.

---

## Key Models

| Model | Table | Purpose |
|---|---|---|
| `AamRequest` | _(see migration)_ | Application record submitted by a prospective adult member |

### AamRequest Fields (from migrations)

| Field | Type | Purpose |
|---|---|---|
| `id` | bigint | Primary key |
| `status` | string/enum | Current application status (pending, under_review, approved, rejected) |
| `level` | string/enum | Application level (group, district, regional, national) |
| `first_name` | string | Applicant first name |
| `last_name` | string | Applicant last name |
| `email` | string | Applicant email address |
| `phone` | string (nullable) | Applicant phone number |
| `id_number` | string (nullable) | SA ID number or passport |
| `date_of_birth` | date (nullable) | Date of birth |
| `gender` | string (nullable) | Gender |
| `address` | text (nullable) | Physical address |
| `group_id` | FK (nullable) | Desired/applicable group |
| `district_id` | FK (nullable) | Applicable district |
| `region_id` | FK (nullable) | Applicable region |
| `notes` | text (nullable) | Applicant-supplied notes |
| `review_notes` | text (nullable) | Admin review notes |
| `reviewed_by` | FK (nullable) | Admin who reviewed |
| `reviewed_at` | timestamp (nullable) | Review timestamp |
| `converted_to_user_id` | FK (nullable) | SystemUser created from this application |
| `created_at` | timestamp | Submission timestamp |
| `updated_at` | timestamp | Last updated |

---

## Key Settings

**Class:** `app/Settings/FormSettings.php`

| Setting | Type | Purpose |
|---|---|---|
| `group_email` | string | Notification email for group-level applications |
| `district_email` | string | Notification email for district-level applications |
| `regional_email` | string | Notification email for regional-level applications |
| `national_email` | string | Notification email for national-level applications |
| `national_support_role_ids` | array | Role IDs that receive national support notification emails |
| `next_in_line_roles` | array | Fallback role IDs used when primary routing email is unset |

---

## Email Routing Logic

When an `AamRequest` is submitted, the application level is determined from the form inputs. The notification email is resolved as follows:

1. Check `FormSettings` for the email corresponding to the application level (`group_email`, `district_email`, `regional_email`, `national_email`).
2. If the resolved email is empty, fall back to users who hold a role in `next_in_line_roles`.
3. For national-level applications, additionally notify all users with roles in `national_support_role_ids`.
4. The applicant receives a confirmation email with an application reference and a status-check link.

---

## Current Status

- Application form exists under the Forms cluster (`app/Filament/Admin/Clusters/Forms/`)
- `ApplicationAdultMembershipRequestResource` scaffolded with list, view pages
- Email routing by level is configured in `ManageFormSettings`
- Applicant-to-`SystemUser` conversion not yet implemented
- Application status tracking (email link for applicant) not yet implemented

---

## Filament Cluster

**Location:** `app/Filament/Admin/Clusters/Forms/`

**Resource:** `app/Filament/Admin/Clusters/Forms/Resources/ApplicationAdultMembershipRequests/ApplicationAdultMembershipRequestResource.php`

---

## Backoffice Panel (Admin) Requirements

### 1. Application List

- **Type:** `ListRecords` page within `ApplicationAdultMembershipRequestResource`
- **Class:** `app/Filament/Admin/Clusters/Forms/Resources/ApplicationAdultMembershipRequests/Pages/ListApplicationAdultMembershipRequests.php`
- **Table columns:** Applicant full name, email, level, status, group/district/region (where applicable), submitted at
- **Filters:** Status (pending/under_review/approved/rejected), level, region, district, submitted date range
- **Search:** Full name, email address
- **Actions:** View (row action); Bulk approve, Bulk reject, Bulk convert to user (bulk actions)

### 2. View Application

- **Type:** `ViewRecord` page within `ApplicationAdultMembershipRequestResource`
- **Class:** `app/Filament/Admin/Clusters/Forms/Resources/ApplicationAdultMembershipRequests/Pages/ViewApplicationAdultMembershipRequest.php`
- **Infolist sections:**
  - Applicant personal details (name, email, phone, DOB, gender, ID/passport)
  - Application details (level, group/district/region, submitted at, notes)
  - Review details (status, reviewed by, reviewed at, review notes)
  - Conversion status (converted to user link if applicable)
- **Header actions:** Review Application, Re-send notification email, Convert to User (if approved)

### 3. Review Application

- **Type:** Custom action on `ViewApplicationAdultMembershipRequest`
- **Class:** `app/Filament/Admin/Clusters/Forms/Resources/ApplicationAdultMembershipRequests/Actions/ReviewApplicationAction.php`
- **Modal fields:**
  - Decision (Approve / Reject / Request More Info)
  - Review notes (required for reject; optional for approve)
- **On approve:** Sets `status` to `approved`; sets `reviewed_by` and `reviewed_at`; sends approval notification to applicant
- **On reject:** Sets `status` to `rejected`; records reason; sends rejection email to applicant with reason
- **On request more info:** Sets `status` to `under_review`; sends email to applicant with reviewer's question

### 4. Convert Approved Applicant to SystemUser

- **Type:** Custom action on `ViewApplicationAdultMembershipRequest` and bulk action on `ListApplicationAdultMembershipRequests`
- **Class:** `app/Filament/Admin/Clusters/Forms/Resources/ApplicationAdultMembershipRequests/Actions/ConvertToUserAction.php`
- **Precondition:** Application must have `status = approved` and must not already have a `converted_to_user_id`
- **Individual modal fields:**
  - Confirm applicant details (pre-filled from `AamRequest`, editable)
  - Initial role assignment (select from available roles)
  - Group/section assignment
  - Send welcome email (toggle)
- **On save:**
  - Creates a `SystemUser` record with details from the `AamRequest`
  - Sets `AamRequest.converted_to_user_id` to the new user's ID
  - Optionally sends a welcome/login email to the new user
- **Bulk conversion:** Uses default initial role; individual editing is not available in bulk mode — a confirmation modal summarises the records to be converted

### 5. Re-send Notification Email

- **Type:** Header action on `ViewApplicationAdultMembershipRequest`
- **Class:** `app/Filament/Admin/Clusters/Forms/Resources/ApplicationAdultMembershipRequests/Actions/ResendNotificationAction.php`
- **Behaviour:** Re-queues the application notification email to the configured routing address for the application's level. Also re-sends the applicant's confirmation email.
- **Confirmation modal:** Summarises the recipient(s) before sending

### 6. Configure Email Routing

- **Type:** Settings page (already exists)
- **Class:** `app/Filament/Admin/Clusters/Settings/Pages/ManageFormSettings.php`
- **Fields:** `group_email`, `district_email`, `regional_email`, `national_email`, `national_support_role_ids`, `next_in_line_roles`
- **Validation:** Email fields must be valid email addresses or empty; role ID arrays must reference existing roles

---

## Member Panel Requirements

### 1. Public-Facing Application Form

- **Type:** Publicly accessible Livewire page or Filament page (no authentication required)
- **Class:** `app/Filament/Member/Pages/ApplyAdultMembership.php` (or equivalent)
- **Partially built:** Form exists; routing and submission handling partially implemented
- **Fields:**
  - Personal details: first name, last name, email, phone, date of birth, gender, ID/passport number, address
  - Application details: desired level, group (searchable select), district (searchable select), region (searchable select), notes
- **Validation:** Required fields enforced; email must be unique among existing `AamRequest` records with non-rejected status (duplicate prevention); ID/passport format validation
- **On submit:**
  - Creates an `AamRequest` record with `status = pending`
  - Sends confirmation email to applicant (includes reference number and status-check link)
  - Sends notification email to the configured routing address for the application's level
  - Redirects to a confirmation page

### 2. Application Status Tracking

- **Type:** Publicly accessible page, accessed via a signed URL sent in the confirmation email
- **Class:** `app/Filament/Member/Pages/CheckApplicationStatus.php` (or equivalent)
- **Access control:** Signed URL (Laravel `URL::signedRoute()`); no login required
- **Displays:** Applicant name, application reference, current status, submitted at, review notes (if the application was rejected or requested more info)
- **Does not display:** Other applicants' data; internal review notes not intended for the applicant

---

## Tests Required

| Test | File | Type |
|---|---|---|
| Application form submits successfully with all valid required fields | `tests/Feature/Filament/Member/Aam/AamFormTest.php` | Feature |
| Application form fails validation when required fields are missing | `tests/Feature/Filament/Member/Aam/AamFormTest.php` | Feature |
| Application form prevents duplicate submission from the same email | `tests/Feature/Filament/Member/Aam/AamFormTest.php` | Feature |
| Successful submission routes notification to the correct level email | `tests/Feature/Filament/Member/Aam/AamEmailRoutingTest.php` | Feature |
| Missing level email falls back to next_in_line_roles users | `tests/Feature/Filament/Member/Aam/AamEmailRoutingTest.php` | Feature |
| National application additionally notifies national_support_role_ids users | `tests/Feature/Filament/Member/Aam/AamEmailRoutingTest.php` | Feature |
| Admin can view and filter AAM application list | `tests/Feature/Filament/Admin/Aam/ApplicationListTest.php` | Feature |
| Admin can approve an application | `tests/Feature/Filament/Admin/Aam/ReviewApplicationTest.php` | Feature |
| Admin can reject an application with a required reason | `tests/Feature/Filament/Admin/Aam/ReviewApplicationTest.php` | Feature |
| Approved application can be converted to a SystemUser | `tests/Feature/Filament/Admin/Aam/ConvertToUserTest.php` | Feature |
| Converting an application sets converted_to_user_id on the AamRequest | `tests/Feature/Filament/Admin/Aam/ConvertToUserTest.php` | Feature |
| Already-converted application cannot be converted again | `tests/Feature/Filament/Admin/Aam/ConvertToUserTest.php` | Feature |
| Unapproved application cannot be converted to a user | `tests/Feature/Filament/Admin/Aam/ConvertToUserTest.php` | Feature |
| AAM form settings page loads correctly | `tests/Feature/Filament/Admin/Settings/ManageFormSettingsTest.php` | Feature |
| Status tracking page shows correct status via signed URL | `tests/Feature/Filament/Member/Aam/StatusTrackingTest.php` | Feature |
| Status tracking page returns 403 for invalid or expired signed URL | `tests/Feature/Filament/Member/Aam/StatusTrackingTest.php` | Feature |

---

## Notes & Considerations

- **Duplicate prevention:** A prospective applicant should not be able to submit a second application while a non-rejected one for the same email is already on record. Rejected applications do not block re-submission — this allows applicants to correct issues and reapply.
- **ID/passport uniqueness:** If an ID number is provided, warn the admin during conversion if an existing `SystemUser` shares the same ID number. Do not hard-block the conversion — a duplicate may be a data correction scenario — but always surface the warning visibly.
- **Signed URL expiry:** The status-check signed URL should have a long validity (e.g. 90 days) since applicants may check back infrequently. Expiry can be configurable via `GeneralSettings`.
- **Queued emails:** All outbound emails triggered by AAM actions must be dispatched via queued jobs, never synchronously in the request cycle.
- **Audit trail:** All status changes on an `AamRequest` should be logged with the acting user, timestamp, and previous/new status. Consider using an `AamRequestStatusChange` model or a generic audit log.

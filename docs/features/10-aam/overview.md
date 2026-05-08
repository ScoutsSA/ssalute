# Feature: Adult Application for Membership (AAM)

> Module: AAM — Adult Application for Membership
> Panel(s): Admin (backoffice), Member (public facing form)
> Status: Planned — Needs Human Review
> Phase: 2 — Adult Lifecycle

---

## Overview

The AAM is a new workflow with no equivalent in the legacy system. It allows prospective adult members to apply for membership online without requiring an existing account. Applications are routed to the appropriate organisational level (group, district, regional, or national) based on configurable email settings. Once reviewed, approved applicants can be converted into full system users and assigned an initial role.

---

## Backoffice (Admin) Requirements

### Application List

- Administrators can view all submitted applications with the applicant's name, email, application level, status, associated area, and submission date.
- The list is filterable by status (pending, under review, approved, rejected), application level, region, district, and submitted date range.
- Searchable by applicant name and email address.
- Bulk actions are available for approving, rejecting, and converting multiple applications at once.

### View Application

- Full view of the applicant's personal details (name, email, phone, date of birth, gender, ID or passport number).
- Application details including the level, associated group/district/region, submission date, and applicant notes.
- Review details showing current status, who reviewed it, when, and any review notes.
- Conversion status indicating whether the applicant has been converted into a system user.

### Review Application

- Administrators can approve, reject, or request more information from the applicant.
- Rejection requires a reason; approval notes are optional.
- On approval, the applicant receives an approval notification email.
- On rejection, the applicant receives an email with the reason for rejection.
- On requesting more information, the applicant receives an email with the reviewer's question, and the application is placed under review.

### Convert Approved Applicant to User

- Approved applicants can be converted into full system users.
- Only approved applications that have not already been converted are eligible.
- During individual conversion, the administrator can confirm and edit the applicant's details, assign an initial role, assign a group/section, and optionally send a welcome email.
- Bulk conversion uses a default initial role and displays a confirmation summary before proceeding.

### Re-send Notification Email

- Administrators can re-send the notification email to the configured routing address for the application's level, and also re-send the applicant's confirmation email.
- A confirmation summary of the recipients is shown before sending.

### Configure Email Routing

- Administrators can configure the notification email addresses for each application level (group, district, regional, national).
- Fallback roles and national support roles can be configured for cases where a level email is not set.
- Email fields must be valid email addresses or empty.

---

## Member Panel (Public Facing) Requirements

### Application Form

- A publicly accessible form (no login required) for prospective adult members to apply.
- Collects personal details: first name, last name, email, phone, date of birth, gender, ID or passport number, and address.
- Collects application details: desired level, group, district, region, and optional notes.
- Required fields are enforced. The applicant's email must not already have a pending, under review, or approved application on record (to prevent duplicates).
- On submission, the applicant receives a confirmation email with a reference number and a link to check their application status. A notification email is also sent to the appropriate administrator(s) based on the application level.

### Application Status Tracking

- Applicants can check the status of their application via a secure link sent in the confirmation email. No login is required.
- The page displays the applicant's name, application reference, current status, submission date, and any review notes relevant to the applicant (e.g. reason for rejection or request for more information).
- The applicant cannot see other applicants' data or internal review notes.

---

## Email Routing Logic

1. When an application is submitted, the system checks for a configured notification email matching the application level (group, district, regional, or national).
2. If no email is configured for that level, the notification falls back to users who hold designated fallback roles.
3. For national level applications, additional notifications are sent to users holding national support roles.
4. The applicant always receives a confirmation email with a reference number and status check link.

---

## Business Rules and Constraints

- A prospective applicant cannot submit a second application while a non rejected application for the same email already exists. Rejected applications do not block resubmission, allowing applicants to correct issues and reapply.
- If an applicant provides an ID number that matches an existing user in the system, a warning is shown to the administrator during conversion. The conversion is not blocked (it may be a data correction scenario), but the warning must be clearly visible.
- The status check link sent to applicants should remain valid for an extended period (e.g. 90 days), since applicants may check back infrequently. The link expiry duration is configurable.
- All emails triggered by AAM actions must be sent asynchronously in the background, never during the web request.
- All status changes on an application must be logged with the acting user, timestamp, and previous and new status values.

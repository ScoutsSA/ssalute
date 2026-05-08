# Feature: Warrants

> Module: 02 — Warrants
> Status: Planned — Needs Human Review
> Depends on: Adult Member System (01), Area Management (11), Role Management

---

## Overview

A warrant is the formal appointment document that authorises an adult to hold a specific role within Scouts South Africa. Every warranted role requires a valid, active warrant before the adult is considered fully appointed. Warrants are managed at five geographic levels: national, regional, district, group, and section.

Each warrant has an issue date and an optional expiry date. The system sends automated expiry reminders at 90, 60, and 30 days before expiry, and again on the expiry day itself. Warrants can be cancelled, extended, or disabled independently of the member's active role status.

---

## Backoffice (Admin) Requirements

### Warrant Management

- Administrators can browse, search, view, create, edit, cancel, extend, and disable warrants across all geographic levels.
- The warrant list displays the warrant number, member name, warrant type, geographic scope, issue date, expiry date (with colour coded status indicators for expired, expiring soon, and valid), and active status.
- Filtering is available by active/inactive status, warrant type, geographic level, region, district, group, and expiry window (30, 60, or 90 days).
- The warrant detail view shows full warrant information, the warranted person, geographic scope, cancellation details (if applicable), extension history, and a downloadable PDF if available.

### Creating Warrants

- Administrators can create a new warrant by selecting the member, warrant type, geographic level and scope (with cascading region/district/group selection), issue date, optional expiry date, warrant number, name, and optional PDF upload.
- Warrants can be flagged as "limited appointment" or "appointment only."
- The warrant type must be valid for the selected geographic level. The issue date must not be in the future, and the expiry date (if provided) must be after the issue date.

### Editing Warrants

- Editing is restricted to the warrant name, expiry date, PDF attachment, and warrant number. To change the member, type, or geographic scope, the warrant must be cancelled and re-issued.

### Cancelling Warrants

- Administrators can cancel a warrant by selecting a cancellation reason and providing optional notes. The warrant is deactivated and the member receives a notification.

### Extending Warrants

- Active warrants with an expiry date can be extended. The administrator provides a new expiry date (which must be after the current one) and optional notes. The old expiry date is preserved for audit purposes, and the expiry notification cycle resets.

### Disabling Warrants

- Administrators can disable a warrant without providing a cancellation reason. This is distinct from cancellation and is tracked separately. Super administrators can disable warrants in bulk.

### Warrant Applications

- Administrators can view all pending, approved, and declined warrant applications, filtered by status, type, and geographic level.
- Applications can be approved (which creates an active warrant from the application details and notifies the applicant) or rejected (which records the decline reason and notifies the applicant).

### Warrant Type and Cancellation Type Lookups

- Administrators can manage warrant type definitions, specifying which geographic levels each type is valid for.
- Administrators can manage cancellation type definitions used when cancelling warrants.

### Reports

- An expiring warrants report shows all active warrants due to expire within a configurable window (30, 60, or 90 days), with export to Excel.
- A summary report shows warrant counts grouped by type and geographic level, with drill-through to the full warrant list.

---

## Member Panel Requirements

### View Own Warrants

- Members can view all their own warrants, ordered by issue date, showing the warrant type, number, geographic scope, dates, status (active, expired, or expiring soon), and a PDF download link.
- Members can filter between active, expired, and all warrants.
- Members can view full details of any of their own warrants in read-only mode. They cannot edit, cancel, or extend warrants.
- Attempting to view another member's warrant is denied.

### Apply for a Warrant

- Members can submit a warrant application for themselves. The available warrant types are filtered to those valid for the member's current geographic level.
- The geographic scope is pre-populated from the member's current role context.
- On submission, the appropriate approver is notified, and the member sees a confirmation that their application is pending review.

---

## Automated Processes

### Daily Expiry Notifications

- The system sends automated email reminders to members whose warrants are approaching expiry. Four tiers of notification are sent: approximately 90 days before expiry, approximately 60 days before, approximately 30 days before, and on the expiry day itself.
- Inactive warrants and warrants without an expiry date are excluded. Once all four notifications have been sent, no further emails are dispatched for that warrant.
- Extending a warrant resets the notification cycle.

### Monthly Expiry Report

- On the first day of each month, the system compiles a report of all warrants expiring in the next 90 days, grouped by region. Each regional commissioner receives a report for their region, and a consolidated national report is sent to national administrators.

---

## Business Rules and Constraints

- Every warranted role requires a valid, active warrant for the adult to be considered fully appointed.
- Warrants are scoped to a single geographic level (national, regional, district, group, or section).
- A warrant type defines which geographic levels it is valid for. A warrant cannot be issued at a level the type does not support.
- Cancellation and disabling are tracked separately. Cancellation requires a categorised reason; disabling does not.
- Warrant extensions preserve the original expiry date for audit purposes.
- The expiry date must always be after the issue date.
- Members can only view their own warrants in the member panel.
- Warrant applications follow an approval workflow: members submit, administrators approve or reject.

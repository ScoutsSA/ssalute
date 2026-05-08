# Feature: Reports & Census

> Module: Reports & Census
> Panel(s): Admin (backoffice), Member
> Status: Planned — Needs Human Review
> Phase: 9 — Reporting & Census

---

## Overview

Reporting is a critical function at all levels of the organisation. Reports are typically run by district, regional, and national administrators. The annual census is a structured data collection process where each group submits membership numbers that roll up through district, region, and national levels, producing the official membership statistics for the year.

---

## Report Categories

### Adult Reports

- List of currently active adult members, filterable by region, district, and group.
- List of inactive adult members, filterable by region, district, group, and date range.
- Adults whose warrants expire within a configurable threshold (30, 60, or 90 days), filterable by region and district.
- Adults grouped or filtered by completed or outstanding training requirements.
- Adults with valid, expired, or missing police clearance.
- Adults whose membership ended within a date range, filterable by reason type.

### Youth Reports

- Currently active youth by section, group, district, and region.
- Inactive youth records within a date range.
- Youth advancement status by group and level.
- Badge records issued within a date range.
- Star award records by group, section, and date range.
- Youth flagged as orphaned or vulnerable.

### Group Reports

- Groups below configurable low membership thresholds (groups in crisis).
- Property items recorded per group.
- High level financial summary per group by financial year.

### Financial Reports

- Outstanding (unpaid) invoices by group, district, or region.
- Payment history per group, filterable by date range and payment type.
- Revenue and costs associated with training events.

### Admin Reports

- Successful and failed login attempts.
- Role changes and assignments.
- Application error log entries.
- Requests resulting in 404 responses.

### Compliance Reports

- Members with valid, expired, or absent police clearance.
- Criminal check completion per member.
- Status of Form 29 submissions per member.
- Members with incomplete emergency contact records.

### Census Reports

- Census submission status showing which groups have or have not submitted for the current year.
- Aggregate member counts rolled up through district, region, and national levels.
- Year on year comparison of census figures across consecutive years.

---

## Backoffice (Admin) Requirements

### Reports Dashboard

- Categorised view of all available reports, organised by Adult, Youth, Group, Financial, Admin, Compliance, and Census categories.
- Each report shows its name, description, and a way to run it.
- Visible to super admins, national admins, regional admins, and district admins (scoped to their area).

### Running Reports

- Each report provides parameter controls appropriate to the report type (date ranges, region/district/group selectors, status filters, etc.).
- Running a report generates a preview of the results on screen.
- Reports can be exported to Excel (xlsx) or PDF format.
- Large exports are processed in the background with a notification when the file is ready.
- PDF exports are branded with the organisation name and logo, and include the report title, parameters used, and generation timestamp.

### Census Management

- National administrators can open and close the annual census submission window by setting the census year, open date, and close date.
- When the census window opens, all group leaders are notified to submit their data.
- When the census window closes, a summary notification is sent to national administrators.
- A submission status view shows which groups have submitted and which have not, with the ability to send reminder emails to groups that have not yet submitted.
- A summary rollup view shows total groups, total submissions, total members by section, and breakdowns by region and district, with the ability to drill down from region to district level.
- Census documents (PDF/Excel) can be generated in bulk for each group, along with a national summary document.

### Form 29 Management

- Track Form 29 submissions per member, including form status, submission date, and expiry date.
- Administrators can mark forms as received, upload scanned copies, record expiry dates, and send reminders.
- Filterable by status (pending, received, expired), region, district, and group.

### Police Clearance Tracking

- Track police clearance status per member, including issue date, expiry date, and whether a document is on file.
- Administrators can upload clearance documents, update expiry dates, and manually mark clearances as valid or expired.
- Automated reminders are sent to members and their group leaders when clearance is approaching expiry, at configurable thresholds (30, 60, or 90 days).

---

## Member Panel Requirements

### Group Leader Reports

- Group leaders can run reports scoped exclusively to their own group. No cross group data is ever accessible.
- Available reports include active and inactive adults, active and inactive youth, badge awards, and attendance summaries.
- The same parameter controls (date range, section filter) are available, but region, district, and group selectors are hidden or fixed to the leader's own group.

### District and Regional Scoped Reports

- District administrators can view reports scoped to their district.
- Regional administrators can view reports scoped to their region.
- Both can drill down to the group level within their scope.

### Annual Census Submission

- Group leaders can submit their census data only while the census window is open.
- The submission captures section by section member counts (Meerkats, Cubs, Scouts, Rovers), with an optional supporting document upload.
- All section counts must be zero or greater, and the total count must be greater than zero.
- On submission, a confirmation email is sent to the submitter.

### Census Submission Status

- Group leaders can view their group's submission status for the current census year, including when it was submitted and by whom.
- Resubmission is allowed while the census window is open, with a confirmation prompt before overwriting previous figures.

---

## Business Rules and Constraints

- All reports must enforce role based scoping at the data level, not just the user interface. A district administrator must never be able to retrieve data outside their district, even by manipulating request parameters.
- Reports that aggregate across many groups (especially national level rollups) should be processed in the background and cached or stored, rather than running heavy queries on page load.
- The census window open and close dates must be configurable (not hardcoded). All census notifications (open, reminder, close) should be processed in the background.
- Census document uploads must use private storage. Raw storage URLs must never be exposed directly.
- Report numbers must be assigned sequentially and atomically to avoid duplicates under concurrent usage.
- POPIA compliance: reports containing personal data (ID numbers, contact details, sensitive flags such as orphaned or vulnerable status) must only be accessible to roles explicitly authorised for that data. Export of such reports must be logged.

# Feature Spec: Reports & Census

> Module: Reports & Census
> Panel(s): Admin (backoffice), Member
> Status: PLANNED
> Phase: 9 — Reporting & Census

---

## Overview

Reporting is a critical function at all levels of the organisation. Reports are typically run by district, regional, and national administrators. The annual census is a structured data collection process where each group submits numbers which roll up through district → region → national, producing the official membership statistics for the year.

---

## Key Models

| Model | Table | Purpose |
|---|---|---|
| `GroupDistrictReport` | `group_district_reports` | District-level report record for a group |
| `GroupDistrictReportsCub` | `group_district_reports_cubs` | Cub section data within a district report |
| `GroupDistrictReportsScout` | `group_district_reports_scouts` | Scout section data within a district report |
| `GroupDistrictReportsCubsAttendance` | `group_district_reports_cubs_attendance` | Cub attendance entries linked to a district report |
| `GroupDistrictReportsScoutsAttendance` | `group_district_reports_scouts_attendance` | Scout attendance entries linked to a district report |
| `CensusDocument` | `census_documents` | Census document uploads per group per year |
| `ReportsNumber` | `reports_numbers` | Report number sequencing |

---

## Report Categories

### Adult Reports

| Report | Description | Parameters |
|---|---|---|
| Active adults | List of currently active adult members | Region, district, group |
| Inactive adults | List of inactive adult members | Region, district, group, date range |
| Expiring warrants | Adults whose warrants expire within a configurable threshold | 30 / 60 / 90 days, region, district |
| Adults by training status | Adults grouped or filtered by completed/outstanding training requirements | Training type, region, district, group |
| Police clearance status | Adults with valid, expired, or missing police clearance | Region, district, group, status |
| Resigned / retired / terminated | Adults whose membership ended within a date range | Date range, reason type, region, district |

### Youth Reports

| Report | Description | Parameters |
|---|---|---|
| Active youth | Currently active youth by section | Section, group, district, region |
| Inactive youth | Inactive youth records | Section, group, district, region, date range |
| Advancement progress | Youth advancement status by group and level | Group, section, level |
| Badge awards | Badge records issued within a date range | Group, badge type, date range |
| Star awards | Star award records | Group, section, date range |
| Orphaned / vulnerable youth | Youth flagged as orphaned or vulnerable | Group, district, region |

### Group Reports

| Report | Description | Parameters |
|---|---|---|
| Groups in crisis | Groups below configurable low-membership thresholds | Region, district, threshold value |
| Group property | Property items recorded per group | Group, district, region |
| Group financial summary | High-level financial summary per group | Financial year, region, district |

### Financial Reports

| Report | Description | Parameters |
|---|---|---|
| Outstanding invoices | Unpaid invoices by group, district, or region | Region, district, group, overdue threshold |
| Payment history | Payment records per group | Group, date range, payment type |
| Training financial | Revenue and costs associated with training events | Training type, date range, region |

### Admin Reports

| Report | Description | Parameters |
|---|---|---|
| Login activity | Successful and failed login attempts | Date range, user, outcome |
| Role activity | Role changes and assignments | Date range, role, user |
| System errors | Application error log entries | Date range, severity |
| 404 page logs | Requests resulting in 404 responses | Date range, path |

### Compliance Reports

| Report | Description | Parameters |
|---|---|---|
| Police clearance | Members with valid, expired, or absent clearance | Region, district, group, expiry threshold |
| Criminal check status | Criminal check completion per member | Region, district, group |
| Form 29 tracking | Status of Form 29 submissions per member | Group, district, status |
| Emergency contacts completeness | Members with incomplete emergency contact records | Group, district, region |

### Census Reports

| Report | Description | Parameters |
|---|---|---|
| Census submission status | Which groups have or have not submitted for the current census year | Region, district, year |
| Census summary rollup | Aggregate member counts rolled up through district → region → national | Year, region, district |
| Year-on-year comparison | Census figures compared across consecutive years | Years (multi-select), region, district |

---

## Filament Cluster

**Location:** `app/Filament/Admin/Clusters/Reports/`

The Reports cluster lives under the Admin panel and groups all reporting resources, census management, and export functionality.

---

## Backoffice Panel (Admin) Requirements

### 1. Reports Dashboard

- **Type:** Custom page
- **Class:** `app/Filament/Admin/Clusters/Reports/Pages/ReportsDashboard.php`
- **Layout:** Categorised card grid (Adult, Youth, Group, Financial, Admin, Compliance, Census)
- **Each card:** Report name, description, a "Run Report" button leading to the report's parameter page
- **Permissions:** Visible to super admin, national admin, regional admin, district admin (scoped appropriately)

### 2. Run Report Page

- **Type:** Custom page per report category, or a shared parameter-driven page
- **Class:** `app/Filament/Admin/Clusters/Reports/Pages/RunReport.php`
- **Fields:** Depends on report — at minimum a date range picker; optionally region/district/group selects, status filters
- **On submit:** Generates a preview table in the page; optionally dispatches a queued export job
- **Actions:** Export to Excel (xlsx), Export to PDF

### 3. Export to Excel

- **Type:** Filament action (table action or header action)
- **Implementation:** Use a dedicated export class (e.g. via `maatwebsite/excel` or equivalent)
- **Behaviour:** Queues an export job for large datasets; for small result sets, streams the file immediately
- **Notification:** Filament notification when the file is ready, with a download link

### 4. Export to PDF

- **Type:** Filament action (table action or header action)
- **Implementation:** Uses a Blade view rendered to PDF (e.g. via `barryvdh/laravel-dompdf` or equivalent)
- **Layout:** Branded with organisation name and logo from `GeneralSettings`; includes report title, parameter summary, and generation timestamp

### 5. Census Management

#### 5a. Open / Close Census Window

- **Type:** Settings action or dedicated census management page
- **Class:** `app/Filament/Admin/Clusters/Reports/Pages/ManageCensus.php`
- **Fields:** Census year, open date, close date, reminder email toggle
- **On open:** Sets a census window record; notifies all group leaders to submit
- **On close:** Marks window as closed; sends summary notification to national admin

#### 5b. Census Submission Status

- **Type:** Table within `ManageCensus` or a `ListRecords` resource
- **Columns:** Group name, district, region, submitted (yes/no), submitted at, submitted by, document uploaded
- **Filters:** Region, district, submitted status
- **Actions:** View submission, send reminder email to non-submitted groups (bulk action)

#### 5c. Census Summary Rollup

- **Type:** Stats overview section on `ManageCensus` or a dedicated report view
- **Displays:** Total groups, total submitted, total members by section, breakdown by region and district
- **Drill-down:** Clicking a region row expands district totals

#### 5d. Generate Census Documents

- **Type:** Action on `ManageCensus`
- **Behaviour:** Generates `CensusDocument` records and associated PDF/Excel files for each group; dispatches a queued job for bulk generation
- **Output:** Downloadable per-group census documents; national summary document

### 6. Form 29 Management

- **Type:** Resource or relation manager
- **Class:** `app/Filament/Admin/Clusters/Reports/Resources/Form29Resource.php`
- **Columns:** Member name, group, district, form status, submission date, expiry date
- **Actions:** Mark as received, upload scan, record expiry date, send reminder
- **Filters:** Status (pending/received/expired), region, district, group

### 7. Police Clearance Tracking

- **Type:** Resource or relation manager
- **Class:** `app/Filament/Admin/Clusters/Reports/Resources/PoliceClearanceResource.php`
- **Columns:** Member name, group, clearance status, issue date, expiry date, document on file
- **Actions:** Upload clearance document, update expiry date, manually mark as valid/expired
- **Automated notifications:** Job runs on a configurable schedule to notify members and their group leaders when clearance is approaching expiry (30/60/90 day thresholds from `GeneralSettings`)

---

## Member Panel Requirements

### 1. Group Leader — Reports for Own Group

- **Scope:** All reports scoped to the authenticated user's group only; no cross-group data is ever returned
- Available reports: Active/inactive adults, active/inactive youth, badge awards, attendance summary
- Same parameter controls (date range, section filter) but region/district/group selectors are hidden or fixed

### 2. District / Regional — Scoped Area Reports

- District admin sees reports scoped to their district
- Regional admin sees reports scoped to their region
- Drillable to group level from within their scope

### 3. Annual Census Submission

- **Type:** Custom page in the Member panel
- **Class:** `app/Filament/Member/Pages/SubmitCensus.php`
- **Availability:** Only accessible when a census window is open (checked against census window record)
- **Fields:** Section-by-section member counts (Meerkats, Cubs, Scouts, Rovers); optional supporting document upload
- **On submit:** Creates or updates a `CensusDocument` record; marks submission as complete; sends confirmation email to the submitter
- **Validation:** All section counts must be non-negative integers; total count must be greater than zero

### 4. View Census Submission Status (Own Group)

- **Type:** Status panel on `SubmitCensus` page or a read-only view
- **Displays:** Submission status for the current census year; submitted at, submitted by; previously submitted figures if applicable
- **Edit:** Resubmission allowed while the census window is open, with a confirmation prompt

---

## Tests Required

| Test | File | Type |
|---|---|---|
| Super admin can access the reports dashboard | `tests/Feature/Filament/Admin/Reports/ReportsDashboardTest.php` | Feature |
| Super admin can run an adult report with filters | `tests/Feature/Filament/Admin/Reports/AdultReportsTest.php` | Feature |
| Warrant expiry report returns only members within the threshold window | `tests/Feature/Filament/Admin/Reports/AdultReportsTest.php` | Feature |
| Group leader can only view reports scoped to their own group | `tests/Feature/Filament/Member/Reports/GroupReportsTest.php` | Feature |
| Group leader cannot access another group's report data | `tests/Feature/Filament/Member/Reports/GroupReportsTest.php` | Feature |
| Census window can be opened and closed by national admin | `tests/Feature/Filament/Admin/Reports/CensusManagementTest.php` | Feature |
| Group leader can submit census data while window is open | `tests/Feature/Filament/Member/Census/CensusSubmissionTest.php` | Feature |
| Group leader cannot submit census data when window is closed | `tests/Feature/Filament/Member/Census/CensusSubmissionTest.php` | Feature |
| Census submission creates a CensusDocument record | `tests/Feature/Filament/Member/Census/CensusSubmissionTest.php` | Feature |
| Census submission status shows correct state for own group | `tests/Feature/Filament/Member/Census/CensusSubmissionTest.php` | Feature |
| Census rollup report aggregates district totals correctly | `tests/Feature/Filament/Admin/Reports/CensusRollupTest.php` | Feature |
| Excel export generates a valid xlsx file for a report | `tests/Feature/Filament/Admin/Reports/ExportTest.php` | Feature |
| PDF export generates a valid PDF file for a report | `tests/Feature/Filament/Admin/Reports/ExportTest.php` | Feature |
| Police clearance expiry notification job queues reminders for approaching expiries | `tests/Feature/Reports/PoliceClearanceNotificationTest.php` | Feature |

---

## Notes & Considerations

- **Scoping:** All reports must enforce role-based scoping at the query layer, not just in the UI. A district admin must never be able to retrieve data outside their district even by manipulating request parameters.
- **Performance:** Reports that aggregate across many groups (especially national-level rollups) should be dispatched as queued jobs and results cached or stored. Do not run heavy aggregation queries synchronously on page load.
- **Census timing:** The census window open/close dates should be stored as a configurable record (not hardcoded). Notifications (open, reminder, close) should all be dispatched via queued jobs.
- **Document storage:** `CensusDocument` file uploads should use Laravel's storage system with private disk access; never expose raw storage URLs directly.
- **Report number sequencing:** `ReportsNumber` provides sequential report identifiers — ensure this is incremented atomically (database-level locking or a dedicated sequence mechanism) to avoid duplicates under concurrent usage.
- **POPIA compliance:** Reports containing personal data (ID numbers, contact details, sensitive flags like orphaned/vulnerable status) must only be accessible to roles explicitly authorised for that data. Export of such reports must be logged.

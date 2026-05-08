# Feature Spec: Training

> Module: Training
> Panel(s): Admin (backoffice — regional level), Member (adult users)
> Status: PLANNED
> Phase: 5 — Training

---

## Overview

Training is organised by region. Course definitions are managed at the system level (`AmsTrainingCourse`). Each year, a course definition is instantiated as an annual offering (`AmsTrainingCoursesAnnual`) with specific session dates (`AmsTrainingCoursesAnnualDate`). Adults book onto annual course instances and attend individual dates. Historical training records from the legacy system are stored in `AmsTrainingPast`.

---

## Key Models

| Model | Table | Purpose |
|---|---|---|
| `AmsTrainingCourse` | `ams_training_courses` | System-level course definitions |
| `AmsTrainingCoursesType` | `ams_training_courses_types` | Course type/classification definitions |
| `AmsTrainingCoursesAnnual` | `ams_training_courses_annual` | Specific year/instance of a course offering |
| `AmsTrainingCoursesAnnualDate` | `ams_training_courses_annual_dates` | Individual session dates within an annual offering |
| `AmsTrainingCoursesAnnualBooking` | `ams_training_courses_annual_bookings` | User booking record for an annual course |
| `AmsTrainingCoursesAnnualAttendance` | `ams_training_courses_annual_attendance` | Attendance record per booking per session date |
| `AmsTrainingCoursesAnnualLecturer` | `ams_training_courses_annual_lecturers` | Lecturer assignments for an annual offering |
| `AmsTrainingCoursesAnnualWarrantsAvailable` | `ams_training_courses_annual_warrants_available` | Warrant opportunities linked to this course offering |
| `AmsTrainingCoursesAnnualBookingsNote` | `ams_training_courses_annual_bookings_notes` | Notes attached to a booking record |
| `AmsTrainingCoursesAnnualBookingsTracking` | `ams_training_courses_annual_bookings_tracking` | Status change tracking log for a booking |
| `AmsTrainingLocation` | `ams_training_locations` | Venue/location definitions for training |
| `AmsTrainingPast` | `ams_training_past` | Historical/legacy training records imported from scouts-digital |
| `AmsTrainingPastType` | `ams_training_past_types` | Type definitions for legacy training records |

---

## Filament Cluster

**Location:** `app/Filament/Admin/Clusters/Training/`

The Training cluster lives under the Admin panel, scoped to users with regional admin or higher roles. All admin training pages are within this cluster.

---

## Backoffice Panel (Admin — Regional Level) Requirements

### 1. Manage Training Courses (System-Level Definitions)

- **Class:** `app/Filament/Admin/Clusters/Training/Resources/TrainingCourseResource.php`
- **Scope:** Super admin and national training officers; regional admins can view but not edit system-level definitions
- **Table columns:** Course name, type (from `AmsTrainingCoursesType`), duration (days/hours), description, active flag
- **Filters:** Course type, active status
- **Actions:** Create, Edit, Deactivate (active flag toggle), View
- **Form fields:** Course name, course type, description, expected duration, prerequisite courses (self-referential relationship), active flag

### 2. Manage Annual Course Instances

- **Class:** `app/Filament/Admin/Clusters/Training/Resources/AnnualCourseResource.php`
- **Scope:** Regional admins scoped to their own region; super admins see all
- **Table columns:** Course name, year, region, location, start date, end date, capacity, bookings count, status (open/closed/cancelled)
- **Filters:** Year, region, course type, status
- **Search:** Course name, location name
- **Actions:** View, Edit, Add session dates, Manage bookings, Cancel course (with confirmation)
- **Form fields:** Course definition (linked to `AmsTrainingCourse`), year, region, location (linked to `AmsTrainingLocation`), capacity, open for bookings flag, start and end date (derived from session dates), notes

### 3. Add / Edit Course Session Dates

- **Type:** Relation manager on the annual course Edit/View page
- **Class:** `app/Filament/Admin/Clusters/Training/Resources/AnnualCourseResource/RelationManagers/SessionDatesRelationManager.php`
- **Table columns:** Date, start time, end time, venue/room (optional), notes
- **Actions:** Add date, Edit date, Delete date (only if no attendance recorded against it)
- **Validation:** Dates must fall within the annual course's overall date range; no duplicate dates

### 4. Assign Lecturers to Courses

- **Type:** Relation manager on the annual course Edit/View page
- **Class:** `app/Filament/Admin/Clusters/Training/Resources/AnnualCourseResource/RelationManagers/LecturersRelationManager.php`
- **Table columns:** Lecturer name (linked to `SystemUser`), role/subject, session dates assigned
- **Actions:**
  - Assign lecturer (search existing users, set role/subject, select applicable session dates)
  - Remove lecturer (with confirmation)
- **Notification:** Assigned lecturer receives a notification with course details

### 5. Manage Training Locations

- **Class:** `app/Filament/Admin/Clusters/Training/Resources/TrainingLocationResource.php`
- **Scope:** Regional admins (own region) and super admins
- **Table columns:** Location name, address, region, capacity, active flag
- **Actions:** Create, Edit, Deactivate, View
- **Form fields:** Location name, physical address, region, GPS coordinates (optional), max capacity, notes, active flag

### 6. View Bookings for a Course

- **Type:** Relation manager or dedicated page on the annual course view
- **Class:** `app/Filament/Admin/Clusters/Training/Resources/AnnualCourseResource/Pages/CourseBookings.php`
- **Table columns:** Participant name, role, group, booking date, status (pending / confirmed / waitlisted / cancelled), payment status (if applicable), notes count
- **Filters:** Status, region, group
- **Search:** Participant name, membership number
- **Actions:** View booking detail, Update booking status, Add booking note, View booking tracking history

### 7. Update Booking Status

- **Type:** Action on the bookings table (row action and bulk action)
- **Statuses:** Pending, Confirmed, Waitlisted, Cancelled
- **Behaviour:**
  - Status change creates a `AmsTrainingCoursesAnnualBookingsTracking` entry recording the old status, new status, changed by, and timestamp
  - Participant receives a notification email on status change
  - Cancellation requires a reason (stored on the booking record and tracking entry)
- **Waitlist promotion:** When a confirmed booking is cancelled and the course is at capacity, the system prompts the admin to promote the next waitlisted booking

### 8. Record Attendance Per Session

- **Class:** `app/Filament/Admin/Clusters/Training/Resources/AnnualCourseResource/Pages/RecordAttendance.php`
- **Layout:** Date selector (from `AmsTrainingCoursesAnnualDate`), then a checklist of confirmed bookings
- **Per participant:** Present / Absent / Excused; optional note
- **On save:** Creates or updates `AmsTrainingCoursesAnnualAttendance` records
- **Display:** Attendance summary per session date shown on the annual course view page

### 9. Mark Course Completion (Certificate Eligibility)

- **Type:** Action on the annual course page, available once all session dates have passed
- **Behaviour:**
  - Calculates attendance percentage per participant
  - Marks participants who meet the attendance threshold as eligible for a certificate (configurable threshold, e.g., 80%, via `GeneralSettings` or a training-specific settings class)
  - Generates a list of eligible participants for the admin to review and confirm
  - On confirmation: sets a `completed_at` flag on the booking records; triggers a notification to each eligible participant
- **Class:** `app/Filament/Admin/Clusters/Training/Resources/AnnualCourseResource/Actions/MarkCourseCompletionAction.php`

### 10. View / Manage Training Financial Report

- **Class:** `app/Filament/Admin/Clusters/Training/Pages/TrainingFinancialReport.php`
- **Inputs:** Annual course selector (or date range filter)
- **Data displayed:**
  - Income: bookings × course fee (where applicable)
  - Costs: lecturer fees, venue hire, materials (manually entered line items)
  - Net surplus/deficit
- **Actions:** Add/edit cost line items; export report as CSV

### 11. Link Warrant Opportunities to Courses

- **Type:** Relation manager on the annual course Edit/View page
- **Class:** `app/Filament/Admin/Clusters/Training/Resources/AnnualCourseResource/RelationManagers/WarrantsRelationManager.php`
- **Table columns:** Warrant type name, qualifying criteria description
- **Actions:** Link existing warrant type to this course (creates `AmsTrainingCoursesAnnualWarrantsAvailable`), unlink
- **Purpose:** Indicates that completing this course makes a participant eligible to apply for certain warrants

---

## Member Panel (Adult User) Requirements

All member panel training pages are accessible to any user with an active adult role.

### 1. View Upcoming Training Courses

- **Class:** `app/Filament/Member/Resources/TrainingResource/Pages/ListUpcomingCourses.php`
- **Scope:** Annual course instances that are open for booking, filtered by the user's region by default (with an option to view other regions)
- **Display:** Course name, type, location, dates, capacity available, booking status (not booked / booked / waitlisted)
- **Filters:** Region, course type, date range
- **Search:** Course name

### 2. Book onto a Course

- **Type:** Action on the upcoming courses list and the course detail view
- **Class:** `app/Filament/Member/Resources/TrainingResource/Actions/BookCourseAction.php`
- **Behaviour:**
  - Checks capacity: if full, offers waitlist placement (with user confirmation)
  - Creates `AmsTrainingCoursesAnnualBooking` with status `pending` (or `waitlisted` if full)
  - Sends confirmation notification to the user
  - Sends notification to the regional training administrator
- **Validation:**
  - User does not already have an active booking for this course instance
  - Course is still open for bookings (`open_for_bookings` flag on `AmsTrainingCoursesAnnual`)
  - Course dates have not passed

### 3. View Own Bookings (Active and Historical)

- **Class:** `app/Filament/Member/Resources/TrainingResource/Pages/MyBookings.php`
- **Tabs:** Active bookings (upcoming/in-progress), Historical bookings (completed/cancelled)
- **Table columns:** Course name, dates, location, booking status, attendance (for completed), certificate status (eligible / not eligible / pending)
- **Row actions:** View booking detail, Cancel booking (active only), Upload POP

### 4. Upload Proof of Participation (POP)

- **Type:** Action on the booking detail view or `MyBookings` table
- **Class:** `app/Filament/Member/Resources/TrainingResource/Actions/UploadPopAction.php`
- **Fields:** File upload (PDF or image), description/notes, date of the training event referenced
- **On save:** Stores file via Laravel storage; attaches to the booking record; notifies the training administrator that a POP has been uploaded for review
- **Use case:** Primarily for historical/external courses not in the system that the user attended independently, or for courses recorded via `AmsTrainingPast`

### 5. View Own Training History (Including Legacy Records)

- **Class:** `app/Filament/Member/Resources/TrainingResource/Pages/MyTrainingHistory.php`
- **Sources combined:**
  - Completed bookings from `AmsTrainingCoursesAnnualBooking` (current system)
  - Legacy records from `AmsTrainingPast` (imported from scouts-digital)
- **Display:** Course/training name, type, date completed, source (current system / legacy import), certificate status, POP link (if uploaded)
- **Note:** Legacy records are read-only; they cannot be edited through the member panel

### 6. Cancel Booking

- **Type:** Action on the booking detail view and `MyBookings` table
- **Class:** `app/Filament/Member/Resources/TrainingResource/Actions/CancelBookingAction.php`
- **Behaviour:**
  - Confirmation modal with a required cancellation reason
  - Creates a `AmsTrainingCoursesAnnualBookingsTracking` entry
  - Updates booking status to `cancelled`
  - Sends notification to the regional training administrator
  - If course is at capacity with a waitlist: triggers an automatic check to promote the next waitlisted participant (queued job)
- **Validation:** Cannot cancel a booking for a course that has already started (show a message directing the user to contact the training administrator instead)

---

## Tests Required

| Test | File | Type |
|---|---|---|
| Super admin can access training management pages | `tests/Feature/Filament/Admin/Training/TrainingClusterTest.php` | Feature |
| Super admin can create and edit a training course definition | `tests/Feature/Filament/Admin/Training/TrainingCourseTest.php` | Feature |
| Regional admin can manage annual course instances for their region | `tests/Feature/Filament/Admin/Training/AnnualCourseTest.php` | Feature |
| Regional admin cannot manage annual courses for another region | `tests/Feature/Filament/Admin/Training/AnnualCourseTest.php` | Feature |
| Adult user can view upcoming courses in the member panel | `tests/Feature/Filament/Member/Training/UpcomingCoursesTest.php` | Feature |
| Adult user can book onto an available course | `tests/Feature/Filament/Member/Training/BookingTest.php` | Feature |
| Booking is placed on waitlist when course is at capacity | `tests/Feature/Filament/Member/Training/BookingTest.php` | Feature |
| User cannot book a course they are already booked on | `tests/Feature/Filament/Member/Training/BookingTest.php` | Feature |
| User cannot book a course that has already started | `tests/Feature/Filament/Member/Training/BookingTest.php` | Feature |
| Attendance can be recorded per session by admin | `tests/Feature/Filament/Admin/Training/AttendanceTest.php` | Feature |
| Attendance recording creates AmsTrainingCoursesAnnualAttendance records | `tests/Feature/Filament/Admin/Training/AttendanceTest.php` | Feature |
| Mark course completion flags eligible participants correctly | `tests/Feature/Filament/Admin/Training/CourseCompletionTest.php` | Feature |
| User can cancel own booking (status change and tracking record created) | `tests/Feature/Filament/Member/Training/CancelBookingTest.php` | Feature |
| Cancelling a booking from a full course triggers waitlist promotion | `tests/Feature/Filament/Member/Training/CancelBookingTest.php` | Feature |
| Own training history includes both current bookings and legacy records | `tests/Feature/Filament/Member/Training/TrainingHistoryTest.php` | Feature |

---

## Notes & Considerations

- **Capacity enforcement:** Capacity is a soft cap by default (admins can override). The booking action should clearly communicate to the user when a course is full and place them on the waitlist.
- **Waitlist promotion:** Automate via a queued job (`PromoteWaitlistedBookingJob`) triggered on cancellation. The job should check current capacity, promote the next waitlisted booking in order of booking date, update the status, and send the notification — without requiring manual admin intervention.
- **Course fees / financial:** The financial report is an admin-only feature. The user-facing booking flow does not handle payment processing in phase 5; that is deferred to the Financial module (phase 6). The financial report for now tracks manually entered cost items against estimated income only.
- **Legacy training records (`AmsTrainingPast`):** These records are read-only in the system. Do not allow editing or deleting them from either panel. They serve as a historical reference and appear in the user's training history view alongside current records.
- **Certificate generation:** Phase 5 covers marking certificate eligibility. Actual PDF certificate generation is a nice-to-have and may be deferred. The notification to eligible participants should clearly state that they are eligible and explain the next steps to receive their certificate.
- **Warrant linkage:** The `AmsTrainingCoursesAnnualWarrantsAvailable` linkage is informational at this stage — it indicates that completing this course makes the participant eligible to apply for a warrant. The warrant application workflow itself is handled separately in the Adult Lifecycle module.
- **Regional scoping:** All admin training management is scoped to the user's region via their active role's region assignment. Cross-region access requires a national training officer or super admin role.

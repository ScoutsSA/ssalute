# Feature: Training

> Module: Training
> Panel(s): Admin (backoffice, regional level), Member (adult users)
> Status: Planned — Needs Human Review
> Phase: 5

---

## What This Feature Does

Training is organised by region. Administrators define course templates at the system level, then create annual instances of those courses with specific session dates. Adult members book onto course instances and attend individual sessions. The system tracks attendance, determines certificate eligibility, and maintains a full training history for each member (including legacy records imported from the previous system).

---

## Admin Backoffice Requirements

### Course Definitions

- Create and manage reusable course templates including name, type, duration, description, and prerequisite courses.
- Super admins and national training officers can create and edit course definitions. Regional admins can view them but not modify them.
- Courses can be activated or deactivated.

### Annual Course Instances

- Create a specific annual offering of a course, assigned to a region and location, with a defined capacity.
- Open or close a course for bookings.
- Cancel a course (with confirmation).
- Regional admins manage only courses within their own region. Super admins can manage all regions.

### Session Dates

- Add individual session dates (with times and optional venue details) to an annual course.
- Edit or remove session dates, provided no attendance has been recorded for that date.
- Dates must fall within the overall course date range and cannot be duplicated.

### Lecturer Assignments

- Assign lecturers to an annual course, specifying their role or subject and which session dates they will cover.
- Remove lecturer assignments (with confirmation).
- Assigned lecturers receive a notification with course details.

### Training Locations

- Create and manage venue/location records including name, address, region, capacity, and GPS coordinates.
- Locations can be activated or deactivated.
- Regional admins manage locations within their own region.

### Booking Management

- View all bookings for a course, filterable by status, region, and group.
- Search by participant name or membership number.
- View booking details, add notes, and view the full status change history for a booking.

### Booking Status Updates

- Change a booking's status (pending, confirmed, waitlisted, cancelled).
- All status changes are logged with the previous status, new status, who made the change, and when.
- Participants are notified by email when their booking status changes.
- Cancellation requires a reason.
- When a confirmed booking is cancelled and the course is at capacity, the admin is prompted to promote the next person on the waitlist.

### Attendance Recording

- For each session date, mark confirmed participants as present, absent, or excused (with an optional note).
- View an attendance summary per session date on the course page.

### Course Completion and Certificate Eligibility

- Once all session dates have passed, an admin can mark the course as complete.
- The system calculates each participant's attendance percentage and flags those who meet the configurable threshold (e.g. 80%) as eligible for a certificate.
- The admin reviews and confirms the eligible list.
- Confirmed eligible participants are notified.

### Training Financial Report

- View a financial summary for a course showing estimated income (based on bookings and course fees) and manually entered costs (lecturer fees, venue hire, materials).
- Shows net surplus or deficit.
- Export the report as CSV.

### Warrant Opportunities

- Link warrant types to an annual course to indicate that completing this course makes participants eligible to apply for certain warrants.
- This linkage is informational only. The warrant application workflow is handled separately.

---

## Member Panel Requirements

All member panel training pages are accessible to any user with an active adult role.

### Browse Upcoming Courses

- View annual course instances that are open for booking, filtered by the user's region by default (with the option to browse other regions).
- See course name, type, location, dates, available capacity, and personal booking status.
- Filter by region, course type, and date range.

### Book onto a Course

- Book onto an available course. If the course is at capacity, the user is offered a place on the waitlist (with confirmation).
- A confirmation notification is sent to the user and to the regional training administrator.
- Users cannot book onto a course they are already booked on, a course that is closed for bookings, or a course whose dates have already passed.

### View Own Bookings

- View active bookings (upcoming or in progress) and historical bookings (completed or cancelled) in separate tabs.
- See course name, dates, location, booking status, attendance record (for completed courses), and certificate status.
- From the bookings list, view booking details, cancel a booking, or upload proof of participation.

### Upload Proof of Participation

- Upload a file (PDF or image) with a description and date as proof of participation in a training event.
- Primarily used for external or historical courses not managed in the current system.
- The training administrator is notified when a proof of participation upload is submitted for review.

### View Training History

- View a combined training history that includes both current system records and legacy records imported from the previous system.
- For each entry, see the course or training name, type, completion date, source (current system or legacy import), certificate status, and proof of participation link if uploaded.
- Legacy records are read only.

### Cancel a Booking

- Cancel an active booking with a required cancellation reason (confirmation required).
- The regional training administrator is notified.
- If the course is full and has a waitlist, the next waitlisted participant is automatically promoted.
- Bookings for courses that have already started cannot be cancelled. The user is directed to contact the training administrator instead.

---

## Business Rules and Constraints

1. **Regional scoping.** All admin training management is scoped to the admin's region. Cross region access requires a national training officer or super admin role.
2. **Capacity is a soft cap.** Admins can override capacity limits. When a course is full, the booking system automatically offers waitlist placement to members.
3. **Waitlist promotion is automatic.** When a confirmed booking is cancelled from a full course, the next waitlisted participant (by booking date) is automatically promoted and notified without manual admin intervention.
4. **Legacy records are read only.** Historical training records imported from the previous system cannot be edited or deleted from either panel.
5. **Financial report is admin only.** The member booking flow does not handle payment processing in this phase. Payment processing is deferred to the Financial Management module.
6. **Certificate eligibility only.** This feature covers marking participants as eligible for a certificate. Actual PDF certificate generation may be deferred. Eligible participants are notified with clear next steps.
7. **Warrant linkage is informational.** Linking warrant types to a course indicates eligibility to apply for a warrant. The warrant application workflow is handled by the Adult Lifecycle module.

# Feature: Events & Competitions

> Module: Events & Competitions
> Panel(s): Admin (backoffice), Member
> Status: Planned — Needs Human Review
> Phase: 7

---

## What This Feature Does

Events are organised at group, district, regional, or national level. Each event has a booking system that allows groups to register and manage attending members. Some events include formal competition tracks with scoring, leaderboards, GPS tracking, quiz questions, and judge management. Event booking financials (invoices, payments, credit notes) are managed separately from the group account financial system.

---

## Admin Backoffice Requirements

### Event Management

- Create and edit events with a name, type (camp, hike, competition, etc.), organiser level (group, district, regional, or national), dates, description, capacity, location (including GPS coordinates), and active/archived status.
- Attach an event to a specific group, district, region, or mark it as national.
- Set registration open and close dates.

### Group Registrations

- View all groups registered for an event.
- Manually add or remove groups.
- View each group's registration status (pending, confirmed, cancelled).

### Booking Management

- View all individual bookings for an event, filterable by group, booking status, and payment status.
- View full booking details including the member, patrol assignment, accommodation, transport, volunteer role, and notes.
- Edit or cancel individual bookings.

### Booking Invoices and Payments

- Generate invoices for groups or individuals based on bookings.
- View all invoices for an event.
- Mark invoices as paid by linking them to a payment record.
- Issue credit notes for cancellations or adjustments.
- View uploaded proof of payment files.

### Competition Configuration

- Enable competition mode for an event.
- Create and edit scoring sheets with column headings and defined scoring areas/categories.
- Configure GPS tracking parameters.
- Set up quiz questions for the competition.

### Live Scoring and Leaderboard

- View scores per group or participant in real time.
- Display a live leaderboard with rankings per scoring area and overall.
- Mark participants as "Did Not Participate" to exclude them from rankings.
- View GPS location logs for tracked participants.

### Judge Management

- Assign judges to a competition, specifying their type and areas of responsibility.
- View, remove, or reassign judge assignments.

### Score Disputes and Adjudications

- View submitted score disputes with the original score, disputed score, and reason.
- Accept or reject adjudications. Accepted adjustments update the leaderboard automatically.
- Notify the relevant judge and group leader of the outcome.

### Competition Financial Summary

- View an aggregate financial summary for the competition showing outstanding versus received totals.
- Export to CSV.

### Data Export

- Export the attendees list (name, group, role, accommodation, transport) as CSV or PDF.
- Export final competition scores and leaderboard as CSV or PDF.
- Export the financial summary as CSV.

---

## Member Panel Requirements

These features are available to group leaders and group admins, scoped to their own group.

### Browse Upcoming Events

- View events that are open for registration.
- Filter by organiser level (group, district, regional, national) and event type.
- View event details including description, dates, location, and remaining capacity.

### Register Group for an Event

- Submit a registration for the group. Both the group leader and the event organiser receive a confirmation notification.
- View the pending or confirmed registration status.

### Manage Group Bookings

- Add members from the group's active membership to the event booking.
- Assign members to patrols.
- Select accommodation and transport options.
- Assign volunteer roles.
- Add notes per booking.
- Remove members from the booking before registration closes.

### Upload Proof of Payment

- Upload proof of payment (image or PDF) against an outstanding booking invoice.
- View the upload status and confirmation from admin.

### View Event Leaderboard

- View the live competition leaderboard during the event (when competition mode is enabled).
- View the final leaderboard after the event closes.
- Filter by scoring area or overall ranking.

### Submit Post Event Survey

- Complete and submit a post event survey after the event concludes.
- View confirmation of submission.

---

## Business Rules and Constraints

1. **Event booking financials are separate.** Invoices, payments, and credit notes for event bookings are managed independently from the group account financial system.
2. **Group scoping.** Group leaders can only manage bookings and registrations for their own group. Attempting to access another group's bookings is denied.
3. **Registration window.** Events have defined registration open and close dates. Members can only be added to or removed from bookings while registration is open.
4. **Competition scoring is real time.** Scores and leaderboard rankings update in real time as scores are recorded.
5. **Did Not Participate exclusions.** Marking a participant as "Did Not Participate" excludes them from competition rankings.
6. **Score adjudication updates the leaderboard.** When a score dispute is accepted, the corrected score flows back into the leaderboard automatically.
7. **Organiser levels.** Events can be scoped to a group, district, region, or the entire national organisation, which determines visibility and who can register.

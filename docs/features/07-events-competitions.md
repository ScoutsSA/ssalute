# Feature Spec: Events & Competitions

## Overview

Events are organised at group, district, regional, or national level. Each event has a booking system allowing groups to register attending members. Some events include formal competition tracks with scoring, leaderboards, GPS tracking, and judge management. Booking financials (invoices, payments, credit notes) are managed independently from group account financials.

---

## Key Models

### Core Events

| Model | Table | Purpose |
|---|---|---|
| `GroupEvent` | `group_events` | Event record — type, dates, organiser level, capacity |
| `GroupEventsAttending` | `group_events_attending` | Groups registered/attending an event |
| `SystemGroupEventType` | `system_group_event_types` | Event type reference (camp, hike, competition, etc.) |

### Booking System

| Model | Table | Purpose |
|---|---|---|
| `EventUserBooking` | `event_user_booking` | Individual user booking for an event |
| `EventUserBookingInvoice` | _(see model)_ | Invoice for a user's booking |
| `EventUserBookingPayment` | _(see model)_ | Payment against a booking invoice |
| `EventUserBookingCreditNote` | _(see model)_ | Credit note against a booking |
| `EventUserBookingAccomodation` | _(see model)_ | Accommodation selection per booking |
| `EventUserBookingTransport` | _(see model)_ | Transport selection per booking |
| `EventUserBookingPatrol` | _(see model)_ | Patrol assignment for a booking |
| `EventUserBookingPatrolAllocation` | _(see model)_ | Specific allocation within a patrol |
| `EventUserBookingRole` | _(see model)_ | Volunteer role assignment for a booking |
| `EventUserBookingNote` | _(see model)_ | Free-text notes on a booking |
| `EventUserBookingOtherOption` | _(see model)_ | Miscellaneous booking options |
| `EventUserBookingPop` | _(see model)_ | Proof of payment upload |

### Competitions

| Model | Table | Purpose |
|---|---|---|
| `EventCompetitionsGp` | _(see model)_ | GPS tracking configuration per competition |
| `EventCompetitionsGroupsAttending` | _(see model)_ | Groups participating in the competition |
| `EventCompetitionsGroupsParticipating` | _(see model)_ | Active participation records |
| `EventCompetitionsScoring` | _(see model)_ | Score records per group/participant |
| `EventCompetitionsScoringSheet` | _(see model)_ | Scoring sheet templates |
| `EventCompetitionsScoringSheetsHeading` | _(see model)_ | Column/heading definitions on a scoring sheet |
| `EventCompetitionsScoringArea` | _(see model)_ | Defined scoring areas/categories |
| `EventCompetitionsScoringDnp` | _(see model)_ | Did Not Participate records |
| `EventCompetitionScoreAdjudication` | _(see model)_ | Score dispute/adjudication records |
| `EventCompetitionsQuestion` | _(see model)_ | Quiz questions for a competition |
| `EventCompetitionsAnswer` | _(see model)_ | Submitted quiz answers |
| `EventCompetitionsJudge` | _(see model)_ | Judge assignments per competition |
| `EventCompetitionsJudgesType` | _(see model)_ | Judge type definitions |
| `EventCompetitionsLocationLogging` | _(see model)_ | Real-time GPS location logs |
| `EventCompetitionsSurveyResponse` | _(see model)_ | Post-event survey responses |
| `EventCompetitionsFinancesInvoice` | _(see model)_ | Competition-specific invoice |
| `EventCompetitionsFinancesPayment` | _(see model)_ | Competition-specific payment |

---

## Backoffice Panel (Admin)

### Resource Location

Dedicated `Events` cluster under `app/Filament/Admin/Clusters/Events/`.

### 1. Create / Edit Events

- Fields: name, `SystemGroupEventType`, organiser level (group/district/regional/national), organiser group/region, start date, end date, description, capacity, location (text + GPS coordinates), active/archived.
- Attach event to a specific group, district, region, or mark as national.
- Set registration open/close dates.

### 2. Manage Groups Attending

- List groups registered via `GroupEventsAttending`.
- Add or remove groups manually.
- View registration status per group (pending, confirmed, cancelled).

### 3. View All Bookings

- List all `EventUserBooking` records for an event.
- Filter by group, booking status, payment status.
- View booking detail: member, patrol assignment, accommodation, transport, role, notes.
- Edit or cancel individual bookings.

### 4. Manage Booking Invoices

- Generate invoices for groups or individuals from bookings.
- List `EventUserBookingInvoice` records per event.
- Mark invoices as paid (link to `EventUserBookingPayment`).
- Issue credit notes (`EventUserBookingCreditNote`) for cancellations or adjustments.
- View proof of payment uploads (`EventUserBookingPop`).

### 5. Competition Configuration

- Enable competition mode for an event.
- Create/edit scoring sheets (`EventCompetitionsScoringSheet`) with headings (`EventCompetitionsScoringSheetsHeading`).
- Define scoring areas (`EventCompetitionsScoringArea`).
- Configure GPS tracking parameters (`EventCompetitionsGp`).
- Set up quiz questions (`EventCompetitionsQuestion`).

### 6. Competition Scores & Leaderboard

- View scores per group/participant in real time.
- Live leaderboard with rankings per scoring area and overall.
- Mark participants as Did Not Participate (`EventCompetitionsScoringDnp`).
- View GPS location logs (`EventCompetitionsLocationLogging`).

### 7. Manage Judges

- Assign judges (`EventCompetitionsJudge`) to a competition, specifying type (`EventCompetitionsJudgesType`).
- View judge assignments and areas of responsibility.
- Remove or reassign judges.

### 8. Score Disputes & Adjudications

- List submitted disputes via `EventCompetitionScoreAdjudication`.
- Review dispute details (original score, disputed score, reason).
- Accept or reject adjudication; updated score flows back to leaderboard.
- Notify relevant judge and group leader of outcome.

### 9. Competition Financial Summary

- Aggregate view of `EventCompetitionsFinancesInvoice` and `EventCompetitionsFinancesPayment` for the competition.
- Outstanding vs received totals.
- Export to CSV.

### 10. Export Event Data

- Export attendees list (CSV/PDF): name, group, role, accommodation, transport.
- Export final competition scores and leaderboard (CSV/PDF).
- Export financial summary (CSV).

---

## General Panel (Group Leader / Group Admin)

### Resource Location

`app/Filament/General/` — Events section scoped to the authenticated user's group.

### 1. Browse Upcoming Events

- List `GroupEvent` records that are open for registration.
- Filter by organiser level (group, district, regional, national) and event type.
- View event detail (description, dates, location, capacity remaining).

### 2. Register Group for an Event

- Submit registration via `GroupEventsAttending`.
- Confirmation notification sent to group leader and event organiser.
- View pending/confirmed registration status.

### 3. Manage Own Group's Booking

- Add members to the booking from own group's active members.
- Assign members to patrols (`EventUserBookingPatrolAllocation`).
- Select accommodation options (`EventUserBookingAccomodation`).
- Select transport options (`EventUserBookingTransport`).
- Assign volunteer roles (`EventUserBookingRole`).
- Add notes per booking (`EventUserBookingNote`).
- Remove members from booking before registration closes.

### 4. Upload Proof of Payment

- Upload proof of payment (`EventUserBookingPop`) against an outstanding booking invoice.
- View upload status and confirmation from admin.

### 5. View Event Leaderboard

- View live competition leaderboard during the event (if competition mode is enabled).
- View final leaderboard after event closes.
- Filter by scoring area or overall ranking.

### 6. Submit Post-Event Survey

- Complete and submit `EventCompetitionsSurveyResponse` after event concludes.
- View confirmation of submission.

---

## Tests Required

### Feature Tests (`tests/Feature/Events/`)

1. **Super admin can manage events**
   - Assert admin can create, edit, and delete a `GroupEvent`.
   - Assert admin can view all bookings for an event.

2. **Group leader can register their group for events**
   - Assert group leader can submit a `GroupEventsAttending` registration.
   - Assert group leader can add members to the booking.

3. **Group leader cannot manage another group's booking**
   - Assert group leader receives 403/404 when attempting to view or edit another group's `EventUserBooking`.

4. **Competition scoring workflow**
   - Assert scores can be recorded against a scoring sheet.
   - Assert leaderboard reflects updated scores after a score is saved.
   - Assert DNP records exclude the group from rankings correctly.

5. **Booking financial workflow (invoice → payment → receipt)**
   - Assert a booking invoice is generated with correct line items.
   - Assert recording a payment marks the invoice as paid.
   - Assert proof of payment upload links correctly to the booking.

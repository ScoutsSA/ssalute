# 002. Legacy zero-dates cast silently to year minus one across 28 columns

**Found:** 2026-08-19, while auditing the strict-cast surface for `001`

## Finding

520 columns across 212 models are cast to `date`/`datetime`. **28 of them hold MySQL zero-dates
(`0000-00-00`), on roughly 36,000 rows.**

These do **not** throw. Measured against `system_users` #5, whose `dob` is `0000-00-00`:

```
raw dob : "0000-00-00"
cast dob: "-0001-11-30 00:00:00"
```

Carbon silently produces 30 November, 2 BC. So this is not `001`'s failure mode. `001` was a loud
crash on 55 rows; this is a **quiet wrong value on ~36,000**, which is the harder kind to notice and
the reason it is worth a ticket rather than a shrug.

## Where it is

| Column | Rows |
| --- | --- |
| `badges_scouts.modified` | 17,765 |
| `advancement_scouts.modified` | 16,675 |
| `advancement_cubs.advancementDate` | 1,239 |
| `advancement_scouts.advancementDate` | 228 |
| `system_users.dob` | 71 |
| `jamboree_application.startDate` / `endDate` | 38 each |
| `system_users.modified` | 36 |
| `group_accounts.created` | 35 |
| `badges_scouts.badgeDate` | 33 |
| `badges_cubs.badgeDate` | 20 |
| `group_council.created` | 11 |
| `system_council_types.created` | 7 |
| `ams_training_locations.modified` | 6 |
| `system_users.dateDeactivated` | 3 |
| `system_users.startDate` | 2 |
| 8 more columns | 1 each |

Two populations with very different stakes:

- **Audit metadata** (`modified`, `created`), roughly 34,500 rows, 95% of the total. A wrong `modified`
  is cosmetic; nothing branches on it.
- **Semantic dates**: `system_users.dob` (71), `advancement_cubs.advancementDate` (1,239),
  `badges_*.badgeDate` (54), `group_attendance.programDate`, `group_equipment.purchaseDate`.
  **`dob` is the one that matters**: a birth date of −0001-11-30 makes a member roughly 2,027 years
  old, and age decides section banding and youth/adult treatment.

## Why this is not simply "set them to NULL"

**17 of the 28 columns are NOT NULL**, so the obvious repair is unavailable on the majority of them:

```
advancement_scouts.advancementDate, ams_training_courses_annual_attendance.dayDate,
badges_cubs.badgeDate, badges_meerkats.badgeDate, badges_scouts.badgeDate,
event_user_booking_roles.created, group_accounts.created, group_attendance.programDate,
group_council.created, group_equipment.purchaseDate, group_events.startDate, group_events.endDate,
group_events.created, jamboree_application.startDate, jamboree_application.endDate,
system_council_types.created, system_users.created
```

sd-core is shared with the legacy Scouts Digital app, so a null-out has to stay safe for the legacy
code that reads these columns. That has been checked against the legacy app's actual behaviour, so this
is a question with an answer rather than a blocker. It is answered in the next section.

## How the legacy app treats the zero date

Exactly one screen in the legacy app compares against the zero-date literal: the member profile page. It
normalises the value to null before rendering, and then suppresses the date line whenever the value is
null.

**The one place that cares already normalises the zero date away.** Nulling `system_users.dob` in the
database therefore produces identical rendered output: the value arrives as null, the zero-date
comparison is false, and the existing null guard suppresses the line exactly as it does today. Nothing
selects on `dob = '0000-00-00'`, and no query runs `DATEDIFF`/`YEAR()`/`TIMESTAMPDIFF` against `dob`.

The legacy date formatter used on that screen is empty-guarded, so it is null-safe too. The one other
`dob` computation, an admin birthday report, converts the value with `strtotime()` inside a range
comparison. Today a zero date makes that row match a nonsense window; with null it simply falls outside
every window. That is a fix, not a regression.

### Where the zero dates come from

The legacy helper that derives a date of birth from an ID number yields an empty string when the ID
number is not 13 characters, and that empty string is bound straight into `dob` by eight adult and youth
add/edit paths. Under a non-strict `sql_mode` MySQL coerces `''` to `0000-00-00`, which is how the 71
rows got there. The local server runs `STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE`, so writes like
that now error rather than silently coerce, but **that is the local snapshot's mode and has not been
confirmed against production**. Worth checking before assuming the population is closed.

## Options

1. **Report only.** Extend `EnsureLegacyValuesAreCanonical` with a third pass that counts zero-dates
   per column and raises them for attention. No writes, no risk, and it makes the population visible
   on a schedule instead of on an audit. This is the recommended first step.
2. **Read-side tolerance.** Map zero-dates to `null` at the cast so `-0001-11-30` never reaches a
   screen or a calculation. Correct, but it means a custom cast applied across 520 declarations,
   invasive, and it would hide a defect the reports should be surfacing.
3. **Null the 11 nullable columns.** Cheapest real repair, and the legacy-safety check above now
   supports it for `dob` specifically. `system_users.dob` is nullable, so the 71 rows that matter
   most are repairable today. The remaining nullable columns still want the same check
   against legacy behaviour before they are included.
4. **Nothing for the audit-metadata columns.** ~34,500 of the ~36,000 rows are `modified`/`created`.
   Deciding to leave those alone permanently is a legitimate and cheap outcome; it shrinks the
   problem to ~1,500 rows and makes the rest tractable.

## Recommendation

The original open question ("is anything in legacy comparing against `'0000-00-00'`?") is answered
above: one call site, and it already treats the zero-date as `NULL`. So this is now **option 1 plus
option 3 scoped to `system_users.dob`**: report the whole population on a schedule, and null the 71
`dob` rows, which are the ones that distort age banding.

Two things still need an operator, and neither blocks the `dob` work:

- Confirm production's `sql_mode` sets `NO_ZERO_DATE`. If it does not, the legacy ID-number
  derivation will keep writing new zero-dates and the repair needs to be recurring rather than one-off.
- Decide on option 4 for the ~34,500 `modified`/`created` rows. Leaving them is defensible.

## Out of scope

- `001`'s whitespace work, which shipped and is unrelated except in how it was found.
- Any change to how new dates are written. Ssalute writes real dates or NULL already; this is
  entirely historical legacy data.

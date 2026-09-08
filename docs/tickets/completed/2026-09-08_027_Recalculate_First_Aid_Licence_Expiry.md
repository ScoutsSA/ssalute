# Recalculate First Aid Licence Expiry Dates

**Priority when actioned:** p3

## Synopsis

First aid licences captured in Scouts Digital carried a five year expiry. The ticket assumed first aid certificates are valid for three years and asked for every historic first aid row to be shortened onto the exact `issueDate + expiryYears` rule, with a full audit trail.

## Resolution

Abandoned on 2026-09-08. The user decided that first aid courses stay five year courses and that no historic licence data is to be changed.

A one off migration and its test suite were written and committed locally on 2026-09-07 (`fix(data): recalculate first aid licence expiry dates`), but that commit was never pushed or deployed. It was dropped from local history on 2026-09-08, so no migration, test or code from this ticket exists in the repository. Nothing shipped by ticket 026 changes: `ams_charge_types.expiryYears` remains the single source of the validity period, defaulting to 5, and a licence still expires exactly `issueDate + expiryYears`.

## Verification

- `git log` on master shows no commit for this ticket and `database/migrations` holds no first aid recalculation migration, checked 2026-09-08.
- The migration was never run on production. It was run once against the local 2026-09-07 sync copy, which changed 341 rows in that disposable copy and left a `migrations` row for a file that no longer exists; the next `rouxt:sync` replaces the copy.
- Not verified from this repository: the production value of `expiryYears` for licence types 14, 15 and 16. The 2026-09-07 completion record stated production already carried 3 for those types. If so, they need to be set back to 5 in BackOffice > LookupTables > Licence Types, otherwise every first aid licence captured from now on gets a three year expiry.

## Risk assessment

- Nothing in code. The only live risk is the production lookup value above, which is a data setting outside this repository.

## Decisions

- First aid licences remain five years (user, 2026-09-08). No historic data correction of any kind.
- The ticket is closed as abandoned rather than deferred, because the premise (three year validity) is withdrawn, not postponed.

## Original ticket

# Recalculate First Aid Licence Expiry Dates

Module: 01-adult-member-system
Gate: ticket 026 deployed and the three first aid licence types (ids 14, 15 and 16) set to a validity of 3 years in production
Panel: console

## Goal

First aid licences captured in Scouts Digital between September 2022 and the deployment of ticket 026 were given a five year expiry. First aid certificates are valid for three years, so those rows overstate validity by two years and members appear qualified when they are not. Shorten them.

## Requirements

- A one off correction, or an `app:system-fixes` fixer (activate the `adding-a-data-fix` skill), that sets `expireDate` to `issueDate + expiryYears` on active licences of types 14, 15 and 16 whose stored expiry is later than that. Scope by "later than", not "different from": under the exact rule every historic row differs by a day or a month end rounding, and only the over long ones are wrong.
- Identify the rows with:

  ```sql
  SELECT i.id, i.chargeTypeID, i.issueDate, i.expireDate,
         DATE_ADD(i.issueDate, INTERVAL t.expiryYears YEAR) AS correctExpiry
  FROM ams_charge_info i
  JOIN ams_charge_types t ON t.id = i.chargeTypeID
  WHERE i.active = 1
    AND t.id IN (14, 15, 16)
    AND i.expireDate > DATE_ADD(i.issueDate, INTERVAL t.expiryYears YEAR);
  ```

- Record the before and after values in the audit log so the change can be traced per licence.

## Notes

- As of the 2026-09-07 sync there were roughly two hundred active first aid rows with a five year expiry. Re-derive with the query above, do not trust this line.
- Youth first aid rows (three years rounded to month end) also match the query by up to thirty days. Decide before running whether to include them.
- Some rows will expire immediately and the nightly `cron/dailyTasks.php` in Scouts Digital deactivates expired licences the next morning. Warn the office before running this.

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

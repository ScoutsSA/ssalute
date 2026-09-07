# Configurable Licence Expiry Duration Per Licence Type

**Priority when actioned:** p6

## Synopsis

First aid certificates are valid for three years, but Scouts Digital hardcoded every adult activity licence (a charge in the legacy schema) at five years. Make the validity period a property of the licence type, editable in the Ssalute BackOffice, and have both systems derive the expiry date from it.

## Resolution

Ssalute (this repository):

- Migration `2026_09_07_111347_add_expiry_years_to_ams_charge_types_table` adds `ams_charge_types.expiryYears`, unsigned integer, default 5, guarded by `Schema::hasColumn`. The database level default matters because Scouts Digital reads the same table.
- `App\Models\AmsLicenceType` casts the column and gains `expiryDateFor()`, the single implementation of the rule: expiry equals issue date plus the type's years, exactly. Plain year arithmetic is used so a 29 February issue date rolls to 1 March, matching PHP `DateTime::modify` in the legacy code.
- LookupTables > Licence Types (`LicenceTypeResource`) gets a required "Validity (years)" field (1 to 50, default 5) and a sortable, toggleable table column.
- The AMS licence form (`LicenceForm`) makes the licence type and issue date live and fills the expiry date from them. The expiry stays editable and carries helper text saying so. The licence type select now shows `Name (#id)` as the BackOffice rules require.
- `docs/features/01-adult-member-system/technical.md` documents the two licence models and the rule. `docs/features/03-youth-management/technical.md` no longer describes `group_youth_charges` as complaint records (it is a dormant table with one 2018 row; youth licences live in `ams_charge_info`).

Scouts Digital (legacy repository, commit a23d6a9 on master):

- `includes/functions.php`: `getChargeTypeExpiryYears()` reads the column and falls back to 5 when the row or column is missing or the value is below 1, in both PDO error modes the app uses. `calculateChargeExpiryDate()` validates the date and applies the exact rule.
- `ams-charge-add.php` (adults) and `group-youth-charges.php` (youth) call the helper on POST and show a read only Expiry Date field that updates through `ajax/ams-charges-get-expiry-date.php` as soon as a type and date are chosen. The youth page previously used three years rounded to month end.

## Verification

- `php artisan test --compact` on 2026-09-07: 709 passed, 3 skipped. Re-derive, do not trust this line.
- New tests: `tests/Unit/Models/AmsLicenceTypeTest` (exact rule, no day shaved, leap day), four licence type tests in `SettingsReferenceDataTest` (create with a validity, default of 5, edit, minimum of 1), three in `AmsClusterCrudTest` (fill on create, refill when the type changes, expiry still editable). Mutating `expiryDateFor()` to subtract a day made four of them fail, so they observe the change.
- `php artisan migrate` ran against the 2026-09-07 synced copy and added the column.
- The legacy helpers were exercised from a scratch script against the synced database in both `ERRMODE_EXCEPTION` and `ERRMODE_SILENT`, including an unknown type, a type id of 0, invalid dates and a simulated missing column. All returned the expected value. `php -l` passes on every touched legacy file.
- Not verified: the legacy pages in a browser (the legacy app cannot be served from this container), and the BackOffice screens in a browser. The Livewire tests cover the form behaviour; the visual layout of the new legacy field is reasoned from the surrounding Metronic markup only. Hand the legacy checklist in the plan to whoever deploys it: pick a type and date and watch the field fill, switch types, clear the type, submit and compare the stored date, and confirm the nightly `cron/dailyTasks.php` does not deactivate the new row.

## Risk assessment

- Behaviour change on capture. Adult licences now expire one day later than before (the minus one day is gone) and youth licences move from three years at month end to the type's exact years. With every type still at the default of 5, youth licences of every type other than those set to 3 get longer. Types 14, 15 and 16 (First Aid Level 1, 2 and 3) must be set to 3 in the BackOffice at deploy time, and the office should decide the value for the other eighteen types deliberately.
- Deploy order. Ssalute's migration should go first. If legacy deploys first, the helper falls back to 5, which is the old behaviour minus a day.
- Legacy tables have no foreign keys. A licence with a `chargeTypeID` that no longer exists gets the fallback of 5.
- `ams-charge-add.php` and `group-youth-charges.php` use CRLF line endings; the edits were normalised to match. The repository root `functions.php` is a stale duplicate of `includes/functions.php` and was deliberately left alone.
- Historic rows are untouched. Licences captured with the old rule keep their stored expiry until ticket 027 runs.

## Decisions

- One exact rule everywhere, no minus one day and no month end rounding, for adults and youth alike (user decision during planning).
- The Ssalute form fills the expiry but leaves it editable, so an office user can record a certificate whose real expiry differs.
- Correcting existing first aid rows is split into ticket 027 (p3), which also flags that youth month end rows would be caught by a naive "later than" query.
- Legacy changes committed directly on the legacy repository's master, path scoped, per the user's instruction.

## Original ticket

# Configurable Licence Expiry Duration Per Licence Type

Module: 01-adult-member-system
Background: Scouts Digital `ams-charge-add.php` and `group-youth-charges.php`, the two pages that capture activity licences (called charges in the legacy schema)
Panel: backoffice

## Goal

Make the validity period of an activity licence a property of the licence type instead of a hardcoded number in the legacy code, so that first aid certificates (valid for three years) stop being recorded with a five year expiry.

## Requirements

- Add an integer `expiryYears` column to `ams_charge_types`, default 5, editable in the BackOffice LookupTables > Licence Types resource.
- Ssalute's AMS licence form fills the expiry date from the issue date plus the type's validity when either is chosen. The value stays editable.
- Scouts Digital reads the type's validity when an adult or youth licence is captured, and shows the computed expiry on the add page as soon as a type and date are selected.
- The rule is the same everywhere: expiry equals issue date plus the type's years, exactly. No "minus one day" and no month end rounding.

## Notes

- Scouts Digital currently hardcodes adult licences at award date plus five years minus one day. The code comment dates the change to 1 January 2022 but the data shows it landed on 16 September 2022 (rows created before that carry three years minus one day). Youth licences are hardcoded at three years rounded to month end.
- Correcting licences already captured with the wrong expiry is out of scope and tracked separately.

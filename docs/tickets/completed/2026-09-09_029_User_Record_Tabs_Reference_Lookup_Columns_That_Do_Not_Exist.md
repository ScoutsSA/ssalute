# User Record Tabs Reference Lookup Columns That Do Not Exist

**Priority when actioned:** p3

## Synopsis

The AMS record tabs on the BackOffice user page (awards, documents, past service, training history, warrants) rendered blank for every lookup label and crashed when their create or edit form opened, because all of them read a `typeName` column that none of the legacy `ams_*` type tables has. The AMS cluster's Training and Warrants resources carried the same mistake. The ticket asked for every reference to point at the real column, for the related record to show as `Name (#id)` per the BackOffice identifier rule, for a licences tab on the BackOffice user page (the only AMS record type without one), and for tests that make a wrong column name go red.

Filed and worked on 2026-09-09 from the 2026-09-08 production log entry (`Unknown column 'ams_training_past_types.typeName'`) and the user's report of blank tabs.

## Resolution

- The five relation managers under `app/Filament/Admin/Resources/Users/RelationManagers/` now read `name` (award, document, past service, training past, warrant and warrant cancellation types) or `reason` (award headings). Table columns and infolist entries render `Name (#id)` through a `state()` closure and fall back to a `-` placeholder when the lookup row is missing, which happens on real data (8,426 training rows had no type as of the 2026-09-07 sync copy, re-derive before relying on it). The selects keep `->relationship()` on the real title column, so search works, and label the options `Name (#id)` through `getOptionLabelFromRecordUsing()`. The award type select fills in the award heading from the type's `headingID` when picked, since the two are paired in the legacy data.
- `app/Filament/Admin/Resources/Users/RelationManagers/Concerns/FillsOwnerScopeOnCreate.php` (new). The legacy record tables declare the home area columns, `active` and `createdby` as `NOT NULL` with no default, and the forms never asked for them, so a create from any of these tabs would have failed even with the column names fixed. The concern copies `assoc_to_region`, `assoc_to_district` and `assoc_to_group` from the owning member, sets the default country, `active` to 1 unless the form said otherwise, and `createdby` to the acting admin. Every create action on the six tabs goes through it. Fields the tables require (`awardHeadingID`, `awardDate`, past service dates, `completionDate`, `warrantNr`, warrant dates, the document file) are now `required()` on the forms.
- `app/Filament/Admin/Resources/Users/RelationManagers/UserLicencesRelationManager.php` (new), registered on `UserResource` after warrants. Table with type, number, issue and expiry dates, active flag and document link; view, create, edit and delete actions; the create and edit form fills the expiry date from the licence type the same way the AMS licence form does, through `LicenceForm::fillExpiryDate()`, which was made public for the purpose.
- `app/Filament/Admin/Clusters/AMS/Resources/Training/{Tables/TrainingTable,Schemas/TrainingInfolist}.php` and `.../Warrants/{Tables/WarrantsTable,Schemas/WarrantInfolist}.php`: `trainingType.typeName` and `role.typeName` replaced with `name` and the `Name (#id)` format.
- Factories for `Award`, `Document`, `PastService`, `PastTraining` and `AmsLicenceInfo` (new), with `inactive()`, `expired()` and `validated()` states where they make sense.
- `docs/features/01-adult-member-system/technical.md`: documented the surfaces for licences, the real lookup column names, and the owner scope convention under `AmsLicenceInfo`.
- `tests/Feature/Filament/UserRecordRelationManagersTest.php` (new), see Verification.

## Verification

Run on 2026-09-09 against the MySQL test database, which loads the real legacy schema dump so the `NOT NULL` constraints and the lookup column names are the production ones.

- `tests/Feature/Filament/UserRecordRelationManagersTest.php`, 15 tests, green:
  - each tab (awards, documents, past service, training, warrants, licences) renders a real lookup row as `Name (#id)`;
  - every relationship select on the six create forms lists and searches its lookup as `Name (#id)` (both the preloaded options and a `getSearchResults()` call, because Filament does not touch the title column when a label closure is set and only the search path does);
  - the warrant infolist resolves the cancellation type;
  - picking an award type fills in its heading;
  - a record can be created from the awards, past service, training, warrants and licences tabs and lands with the member's home area, `active = 1` and the acting admin as `createdby`;
  - the licences tab is registered on the user resource, shows the expiry date, and the expiry date can be edited.
- Mutation checks, each restored afterwards: putting `typeName` back on the training type select reds the select test with the original `Unknown column` error; removing the `Name (#id)` state closure on the awards table reds the awards tab test; dropping the owner scope from the concern reds the five create tests.
- Related suites green: `UserRoleAttachmentsRelationManagerTest`, `AmsClusterCrudTest`, `AmsClusterTest`, `UsersResourceTest`, `MemberPanelTest`, `ProfileTest`, `Unit/Models/AmsLicenceTypeTest` (69 tests).
- Full suite green on 2026-09-09: 731 passed, 3 skipped. Re-derive with `php artisan test --compact`, do not trust this line.
- `vendor/bin/duster fix --dirty` run.
- Not verified: the document create form end to end. The file upload is `required()` and the test only exercises the select; a real upload was not driven through Livewire.
- Not verified: on production. Nothing here has been deployed.
- Not reproduced: the user's report that the Member panel licences tab does not show the expiry date. The Member relation manager has had an `expireDate` column since 2026-04-10 and a Livewire render in a throwaway test printed `Feb 10, 2030` in the Expires column against a factory licence. Left open, see Decisions.

## Risk assessment

- The create path now writes six legacy tables the BackOffice never wrote before. The home area is copied from the member's current `assoc_to_*` values, which is what Scouts Digital does at capture time, but a record captured after a member moves will carry the new area, as it would in the legacy system.
- `MightHaveCreatedBy` and `MightHaveModifiedBy` never fire for these models: they check `$fillable` and the models use `$guarded = []`. `createdby` is set by the concern, `modifiedby` is set by nothing, so an edit from these tabs leaves `modifiedby` null (the `modified` timestamp is still stamped). This is true of every model in the app and is not addressed here.
- The AMS Awards resource form (`AwardForm`) still lets the heading be left empty on a `NOT NULL` column. Not touched, it is outside the user page tabs.
- `PastService` rows created here carry the table default `toBeFixed = 1`. The legacy meaning of that flag was not checked.
- The Member panel tabs were not changed. They already used the real column names.

## Decisions

- The create fix (owner scope concern, required fields) was folded in rather than split, because the tests that observe the select fix create records through the forms, and without it those forms could not be exercised at all.
- Relationship selects keep `->relationship()` rather than switching to a static `->options()` list the way the AMS cluster forms do, so the search box works on the title column and the `exists` validation stays on the relation.
- `LicenceForm::fillExpiryDate()` was made public and reused rather than duplicated, so the expiry rule stays in one place next to `AmsLicenceType::expiryDateFor()`.
- The Member panel expiry date report is not closed by this ticket. The code renders it and the synced data has no zero or null expiry dates (as of the 2026-09-07 copy, all 1,731 `ams_charge_info` rows have both dates, re-derive before relying on it). It needs the exact page and environment the user saw before it can be reproduced. No follow-up ticket filed until then.

## Original ticket

# User Record Tabs Reference Lookup Columns That Do Not Exist

Module: 02-adult-management
Panel: backoffice

## Problem

On the BackOffice user page the AMS record tabs render blank for every lookup label: training history shows no training type, awards show neither the award type nor the heading, documents show no document type, past service shows no service type, and warrants show no warrant type. The create and edit forms on the same tabs crash when they open, because the type select builds its options from the same missing column.

Every tab reads `typeName` from its lookup relation, but none of the legacy `ams_*` type tables have that column. The real columns are `name` (award types, document types, past service types, training past types, warrant types, warrant cancellation types) and `reason` (award headings).

Seen in production on 2026-09-08 15:34: opening the training history create form on a user threw `SQLSTATE[42S22] Unknown column 'ams_training_past_types.typeName' in 'field list'` from the Filament select. The other four tabs have the same shape and fail the same way when their form is opened.

The AMS cluster's Training resource (`trainingType.typeName`) and Warrants resource (`role.typeName`, `system_user_types` uses `name`) carry the same mistake in their table and infolist.

There is no licences tab on the BackOffice user page at all. Licences (`ams_charge_info`) only appear under AMS > Licences, so an admin looking at a member cannot see a licence's expiry date or edit it without leaving the record. The Member panel has a read only licences tab.

## Where

- `app/Filament/Admin/Resources/Users/RelationManagers/UserAwardsRelationManager.php`
- `app/Filament/Admin/Resources/Users/RelationManagers/UserDocumentsRelationManager.php`
- `app/Filament/Admin/Resources/Users/RelationManagers/UserPastServiceRelationManager.php`
- `app/Filament/Admin/Resources/Users/RelationManagers/UserTrainingHistoryRelationManager.php`
- `app/Filament/Admin/Resources/Users/RelationManagers/UserWarrantsRelationManager.php`
- `app/Filament/Admin/Clusters/AMS/Resources/Training/{Tables/TrainingTable,Schemas/TrainingInfolist}.php`
- `app/Filament/Admin/Clusters/AMS/Resources/Warrants/{Tables/WarrantsTable,Schemas/WarrantInfolist}.php`

## Scope

- Point every select, table column and infolist entry at the column that exists, and show the related record as `Name (#id)` per the BackOffice identifier rule.
- Add a licences tab to the BackOffice user page with the same view, create, edit and delete actions as the warrants tab, showing issue and expiry dates and filling the expiry date from the licence type validity the way the AMS licence form does.
- Feature tests that render each tab with a real lookup row and open or submit each create form, so a wrong column name goes red.

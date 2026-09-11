# Area Full CRUD With Referential Delete Guard

**Priority when actioned:** p6

## Synopsis

Make regions, districts and groups fully administrable in the BackOffice: create, delete and edit every column, refuse a delete while any row in any table references the record, show every table that can block a delete as a relation manager tab, and add the uniqueness rules from the feature spec. Fix the two latent bugs that made create fail (audit stamping traits never fired, `regions.countryID` missing).

## Resolution

- **Reference map.** `app/Services/Areas/AreaReferenceMap.php` holds every column that references an area. The convention derived maps (`REGION` 81 tables, `DISTRICT` 68, `GROUP` 105) were generated from `database/schema/sd-core-schema.sql`; the `*_EXTRA` maps hold the hand curated columns whose names do not follow the convention (`fromGroup`, `roverGroupID`, `actionRegionID`, `heldInDistrict` and so on). `MODELS` maps tables to models; the five `commerce_*` tables have no model.
- **Guard.** `app/Services/Areas/AreaDeletionGuard.php` (singleton, memoised per record) counts references per table on the `sd-core` query builder, `OR`ing a table's columns. `app/Models/Concerns/PreventsDeletionWhenReferenced.php` throws `App\Exceptions\AreaStillReferencedException` from `deleting` on `Region`, `District` and `Group`. `app/Filament/Admin/Clusters/Area/Actions/DeleteAreaAction.php` runs the guard in `before()`, notifies with the blocking tables and counts, and cancels. Used on the edit and view pages and as a row action on the three tables.
- **Linked record tabs.** `app/Providers/AreaRelationshipsServiceProvider.php` registers a `hasMany` per table and column via `resolveRelationUsing()`. `RelationManagers/Linked/LinkedRecordsRelationManager.php` is the read only base (hidden when empty, count badge, generic columns, link to the admin resource). 125 generated subclasses live under `RelationManagers/Linked/`; `LinkedRelationManagers` names them and lists them per resource, skipping the bespoke pairs. `Schemas/LinkedRecordsSection.php` lists the blocking tables on the view page.
- **Forms.** Every column is on the forms, grouped in collapsible sections; audit columns are read only on edit via `Schemas/AreaFormComponents.php`. Uniqueness: region `name` and `short`, district `name` within region, group `groupRegNr` when provided. The group district select and the district super district select are limited to the chosen region. Legacy `NOT NULL DEFAULT 0` account and super district columns show empty and store 0.
- **Tables and pages.** Create buttons on the region and district lists, View/Edit/Delete row actions everywhere, the duplicate `id` column removed, group filters filled in, extra toggleable columns added.
- **Create path.** `MightHaveCreatedBy` and `MightHaveModifiedBy` now check `hasCast()` instead of `$fillable`. `Region` casts `countryID`.
- **Factories.** `RegionFactory`, `DistrictFactory`, `GroupFactory`, `GroupAccountFactory`.
- **Docs.** `docs/features/11-area-management/overview.md` and `technical.md` rewritten to match.

## Verification

- `php artisan test --compact` on 2026-09-11: 830 passed, 3 skipped. Re-derive with the command, do not trust this line. Baseline before this work on the same day was 797 passed, 3 skipped.
- New tests: `tests/Unit/Services/AreaReferenceMapTest.php`, `tests/Feature/Services/AreaDeletionGuardTest.php`, `tests/Feature/Models/AuditColumnStampingTest.php`, `tests/Feature/Filament/Area/{RegionCrudTest,DistrictCrudTest,GroupCrudTest,LinkedRecordsRelationManagersTest}.php`.
- Mutations run and reverted, each went red: trait condition back to `$fillable` (district create test), one entry removed from `AreaReferenceMap::REGION` (drift test), `DeleteAreaAction` swapped for `DeleteAction` on `EditRegion` (refused delete test), one generated relation manager file deleted (coverage test), guard limited to three tables (guard tests).
- `vendor/bin/duster fix --dirty` run.
- Not verified: the pages in a browser. No local server was running in the container. The query cost of the guard on production sized data is reasoned about, not measured.

## Risk assessment

- **Log tables block deletes.** `error_logging`, `admin_good_logons`, `system_user_logging`, `notifications` and `notifications_archive` carry area ids, so any area that was ever used cannot be deleted. That was the requested behaviour ("any other linked data") and the notification names the tables, but an admin expecting to delete a retired group will need to clear those rows first.
- **Audit stamping now reaches 179 models.** Any model casting `modifiedby` gets it stamped on every authenticated save, including saves triggered from the BackOffice by system fixes and services. Audit rows will show it. Explicit values are kept, unauthenticated paths are untouched. The full suite passed, but production writes from paths the suite does not cover could differ.
- **Query cost.** About 80 to 115 `COUNT` queries run on every view or edit page load of an area and on every delete click, memoised per request. Most columns are indexed; a few (for example `group_financial_invoices.assocToRegion`, `error_logging.regionID`) are not. A `UNION ALL` single round trip is the fallback if it proves slow.
- **Generated classes.** 125 near identical relation manager classes and the two constant maps must be regenerated when the schema dump changes. The drift and coverage tests fail loudly when they are stale, so the risk is friction rather than silent breakage.
- **Legacy writes.** The legacy system still writes to these tables without any of these rules, so duplicate names and dangling references can still appear from outside this codebase.
- **Filament internals.** `LinkedRecordsRelationManager` relies on `canViewForRecord`, `getBadge` and `resolveRelationUsing`, all public API, but a Filament upgrade that changes when `canViewForRecord` is called would change the page load cost.

## Decisions

- Two tier reference map (generated plus hand curated) so the drift test can prove the generated part and assert the existence of the curated part.
- No exclusions from the guard, per the user's decision, even for log tables.
- The model listener throws rather than returning false so non Filament paths get the reason.
- No bulk delete on the area tables. The single mistaken record is the realistic case and the model listener guards any future bulk path anyway.
- One relation manager per referencing table, plus one per extra column, generated rather than hand written, because Filament resolves a relation manager's title, badge and visibility statically per class.
- Bespoke managers (districts, groups, roles, sections, committee) stay as they are and are always visible; generated ones hide when empty.
- Legacy `NOT NULL DEFAULT 0` selects are coerced at the form level (ticket 010 covers the model level treatment).
- Group table gains filters and hidden columns but not the social and banking columns, which stay on the view page.
- Not built and recorded in the feature docs: a dedicated active toggle with warrant and youth warnings, a super district resource, a cascading district filter on the group list. None were in the request.
- Dynamic relationships are registered for every pair, including bespoke ones, so the guard, the tabs and any service share the same names.

## Original ticket

# Area Full CRUD With Referential Delete Guard

Module: 11-area-management
Panel: backoffice

Filed at p6 because nothing is blocked on it, but the BackOffice cannot currently administer the area hierarchy at all, which the office expects it to do once the legacy system is switched off.

## Problem

The Area cluster (`app/Filament/Admin/Clusters/Area`) is scaffolded but not usable. Regions and districts have no Create button, only View row actions, forms that expose a subset of columns, and an unguarded Delete on the Edit page. Groups can be created but the district select is not narrowed by region and many columns are missing. The feature spec already says a region with districts and a district with groups must not be deletable and that names must be unique, but none of it is implemented.

Two latent bugs make create fail today. `MightHaveCreatedBy` and `MightHaveModifiedBy` check `$model->fillable`, which is empty on every model (they all use `$guarded = []`), so `createdby` is never stamped and the legacy `NOT NULL` column rejects the insert under strict mode. `regions.countryID` (`NOT NULL`, no default) is neither cast nor on the form.

## Scope

- Create, delete and fully edit regions, districts and groups in the BackOffice. Every table column is editable; `id`, `created`, `createdby`, `modified`, `modifiedby`, `groupLastUpdated` and `groupLastUpdatedBy` are read only on edit.
- A region, district or group cannot be deleted while any row in any table references it. The reference list is derived from `database/schema/sd-core-schema.sql` and a test proves the list matches the dump. The admin sees which tables block the delete.
- Every table that can block a delete is visible as a read only relation manager tab on the area's View and Edit pages, hidden when empty, with a count badge.
- Uniqueness rules from the spec: region name and short code unique, district name unique within its region, group registration number unique when provided.
- Cascade the district select by region on the group form.
- Fix the audit column stamping traits so `createdby` and `modifiedby` are set when a user is authenticated.
- Factories for Region, District and Group. Feature tests for every path above.
- Correct `docs/features/11-area-management` in the same commit.

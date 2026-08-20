# Data Fixes appears twice in the BackOffice navigation

Module: none (cross cutting admin surface)
Panel: backoffice

Split out of ticket 001, which shipped the Data Fixes cluster without resolving this.

## Problem

Two separate navigation entries in the BackOffice panel are both labelled "Data Fixes":

- `App\Filament\Admin\Clusters\Settings\Pages\ManageDataFixesSettings`, the per fix enable and notify toggles, which lives in the Settings cluster.
- `App\Filament\Admin\Clusters\DataFixes\DataFixesCluster`, the four findings pages that ticket 001 added.

An admin cannot tell from the nav which one they want, and the two are genuinely related: the toggles decide whether a fix runs at all, and the pages show what it found.

## Goal

One obvious place to go. The likely shape is moving the settings page into the `DataFixes` cluster as a "Settings" page alongside the four findings pages, leaving the Settings cluster to the settings that are not about data fixes.

## Constraints

- `ManageDataFixesSettings` uses the `AuditsSettings` concern so changes are recorded in the audit log. Moving the page must not drop that.
- The `adding-a-setting` skill documents where settings pages live. If this ticket changes that convention, it fixes the skill in the same commit.
- The BackOffice panel is restricted to super users via `SystemUser::isSuperAdmin()`. Whatever moves must stay inside that restriction.
- `tests/Feature/Filament/DataFixesClusterTest.php` and the settings tests both assert on page URLs. Both must stay green.

## Why p6

Nothing is broken and no data is at risk. It is a usability wrinkle on a surface only a handful of super users see, so it waits behind anything with a correctness or safeguarding cost.

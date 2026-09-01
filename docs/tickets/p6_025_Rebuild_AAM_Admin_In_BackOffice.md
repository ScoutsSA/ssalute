# Rebuild AAM Admin In BackOffice

Module: 10-aam
Panel: backoffice

## Goal

The BackOffice Forms cluster (a single raw resource over `forms_aam_requests`) was deleted on 2026-09-01 at the product owner's request rather than kept half-built. Decide what the AAM admin experience should be and build it properly, or confirm the deletion as final and clean up what remains.

## Background

- The operational AAM flow is untouched and lives outside Filament: `routes/form-routes.php` serves the public application form (`aam.form`), the view page (`aam.view`) and the approver action page (`aam.action`) through slugged links, backed by `App\Livewire\Forms\Aam\*` and `App\Models\Forms\ApplicationAdultMembershipRequest` (status enum `AamStatuses`).
- What was deleted: `app/Filament/Admin/Clusters/Forms` (the cluster and its `ApplicationAdultMembershipRequests` resource). The dashboard attention widget's Pending AAM Requests row went with it, and `EnsureLegacyValuesAreCanonical` no longer links `forms_aam_requests` findings to an edit page (they now render without a link, which that fix supports by design).

## Requirements

- Decide the shape of AAM administration in the BackOffice: a proper queue with approve/decline actions and visibility of the emailed action links, or nothing beyond the existing slugged action pages.
- If rebuilt: restore a Pending AAM Requests row in the dashboard `AttentionWidget::queues()` and re-add a `forms_aam_requests` entry to `EnsureLegacyValuesAreCanonical::RESOURCES` so findings link somewhere actionable again.
- If confirmed deleted: remove the now-orphaned admin-only leftovers (check `FormSettings` in the Settings cluster and any AAM admin notification paths) and record the decision in `docs/features/10-aam`.

## Notes

- The AAM module spec is `docs/features/10-aam` (module status WIP ~40%).

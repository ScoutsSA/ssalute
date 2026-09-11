# Area Forced Delete With Explicit Consequences

**Priority when actioned:** p6

## Synopsis

Ticket 031 made a referenced region, district or group undeletable. The user asked for an informed alternative: show clearly what references the record, let an admin force the delete when they are sure, and be very clear about what happens to the related records.

## Resolution

- `DeleteAreaAction` no longer cancels. With no blockers it is a plain confirmation. With blockers the modal shows `Delete Name (#id)`, the total rows and tables, a badge per table with its row count, a "What a forced delete does" section, an acknowledgement checkbox and a field that must match the record name. The submit reads "Force delete". After a forced delete a persistent warning notification repeats what was left behind.
- Policy: a forced delete removes only the area row. Referencing rows are not deleted and not nullified; they keep the old id and show as missing wherever they appear. Reasons: 0 means "no scope" on role attachments, so nullifying would silently widen a role; cascading would delete member data across roughly a hundred tables. Moving or deleting the rows first, using the tabs, avoids orphans.
- `PreventsDeletionWhenReferenced::forceDeleteWhileReferenced()` is the only bypass of the model level stop; plain `delete()` still throws.
- Docs in `docs/features/11-area-management` updated.

## Verification

- `php artisan test --compact` on 2026-09-11: 837 passed, 3 skipped. Re-derive with the command, do not trust this line.
- Tests updated in `tests/Feature/Filament/Area/{RegionCrudTest,DistrictCrudTest,GroupCrudTest}.php` and `tests/Feature/Services/AreaDeletionGuardTest.php`: refused without acknowledgement, wrong name refused, modal heading, description, badges, consequences text and submit label, forced delete leaves districts, users and role attachments pointing at the old id, plain confirmation when unreferenced.
- Modal content is asserted against the mounted action and schema objects, not rendered HTML, because Filament does not render the modal in Livewire tests and rendering the checkbox outside a request fails.
- Not verified in a browser (no local server in the container).

## Risk assessment

- A forced delete creates orphaned rows by design. Area scoped queries will not find them and role attachments scoped to the deleted area no longer grant access to a real area. The modal says so, but the data consequence is real and irreversible.
- The consequences text is HTML built in PHP with the record name escaped. A future change that interpolates unescaped data there would be an XSS vector.
- The acknowledgement and name check are form validation on the action; a direct `forceDeleteWhileReferenced()` call from code has no such gate.

## Decisions

- Leave related rows untouched rather than nullify or cascade, for the reasons above. A "reassign related rows to another area" flow would be the safe complement and is not built.
- Type the record name rather than a plain checkbox alone, because the notification cannot be undone.
- The guard's memo is cleared before every modal open so the counts reflect the current state, at the cost of the extra queries.

## Original ticket

Show the admin what they are about to delete instead of refusing outright. Let them force it through if they are sure, and be very clear about what happens to the related records: are they deleted, nullified, or left as they are.

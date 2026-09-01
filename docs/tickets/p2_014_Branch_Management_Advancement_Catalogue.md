# Branch Management: Advancement Catalogue

Module: 04-advancements-badges
Background: wiki/SD-Migration/Legacy-Navigation-Inventory, system administrator nav
Panel: backoffice

## Goal

Add the Advancement area to the Branch Management structure delivered by ticket 013: manage each branch's advancement scheme (the levels and the parts and tasks beneath them) with the same add, edit, deactivate, reorder and pleasant viewing treatment as badges.

## Requirements

- Advancement per branch inside Branch Management, alongside Badges.
- The catalogue spans several model families per branch: SystemAdvancement{Branch}Level plus the Second and Third tiers, Challenge tables for some branches, and the Scout Entsha tables. Start with an inventory of these models and record which are managed here and what each tier means functionally.
- Levels, and the parts and tasks beneath them: list, view, add, edit, deactivate, reorder, following ticket 013's rules (soft deactivation only, ordering via reorderable tables, awarded advancement records untouched by catalogue edits).
- The LookupTables cluster currently exposes the four advancement level tables as bare lookup editors (the Advancement Levels group). Decide whether those editors are absorbed into Branch Management or removed, so there are not two competing edit paths, and record the decision.

## Notes

- Depends on ticket 013 for the Branch Management structure.
- The legacy admin screens for the advancement catalogue were partly non-functional, so treat this as a design task informed by the data model, not a port of legacy screens.

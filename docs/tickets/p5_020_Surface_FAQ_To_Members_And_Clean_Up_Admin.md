# Surface FAQ To Members And Clean Up Admin

Module: 12-content-community
Background: wiki/SD-Migration/Legacy-Navigation-Inventory, leftNav FAQ section
Panel: member and backoffice

## Goal

The FAQ is coming across to Ssalute. The BackOffice can already create and manage FAQ entries and categories through the LookupTables cluster (FaqEntries and FaqCategories, models SystemFaq and SystemFaqCat), which works but is not great, and nothing surfaces the content to users at all. This ticket is mostly about surfacing the FAQ in the Member panel, and secondarily about moving the admin management out of the bare lookup editors and cleaning it up.

## Requirements

- Member panel: a browsable FAQ. Legacy shows an always-visible "Questions Answered" area with all questions plus per-category views, and filters categories by who the user is (group admin, district, region, national, parent, scout, rover). Confirm how audience targeting is stored on the categories or entries and honour it.
- BackOffice: move FAQ management out of the LookupTables cluster into a proper content area, with entries managed in context of their categories, ordering if the data supports it, and soft disable rather than delete. Remove or redirect the old lookup editors so there is one edit path.
- Respect the Member panel feature-flag convention: decide whether FAQ visibility gets a FeatureSettings toggle (adding-a-setting skill) and record the decision.

## Notes

- Audience filtering is scope-sensitive: an FAQ aimed at admins must not imply access a member does not have, but it is help content, so over-showing is a UX problem rather than a safeguarding one.

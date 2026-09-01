# Scouting Network Moderation

Module: 12-content-community
Background: wiki/SD-Migration/Legacy-Navigation-Inventory, Admin Actions under the system administrator nav
Panel: backoffice

## Goal

The Scouting Network is the professional directory: members list their businesses and professional services for other members to find, and the system administrator approves or declines each listing with a recorded reason. It is useful and worth keeping, but it is not part of the core focus right now, hence the band. This ticket brings the moderation and management side to the BackOffice.

## Requirements

- A pending queue of submitted listings: approve in place, or decline with a required reason.
- A manage view over all listings (pending, approved, declined) with the usual filters, plus a pending-count signal for admins.
- Models to build on: DirectoryProfessional, DirectoryProfessionalReview, DirectoryProfessionalLike and DirectorySkill. Inventory what each holds during implementation (reviews of listings may need their own moderation tier, as Info Sharing has).
- Legacy gates the whole feature behind a global on/off flag. Decide whether Ssalute needs an equivalent feature toggle (a FeatureSettings entry via the adding-a-setting skill) and record the decision.

## Notes

- Same approve or decline-with-reason shape as Scouter Endorsements (ticket 016) and Info Sharing (ticket 017). Reuse whatever shared moderation pattern those establish.
- The member-facing side (browsing the directory, managing one's own listing) is Member panel work and is not in scope here; note follow-up needs when this is worked.

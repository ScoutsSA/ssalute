# Info Sharing: Decide Direction And Moderation

Module: 12-content-community
Background: wiki/SD-Migration/Legacy-Navigation-Inventory, Admin Actions under the system administrator nav
Panel: backoffice

## Goal

Legacy Info Sharing lets members share resources into categorised lists, with two-tier moderation by the system administrator: the shared item itself is approved or declined with a reason, and member reviews of an item go through their own separate approval. Whether and in what form Info Sharing carries into Ssalute has not been decided. This ticket is the placeholder for that decision, and for the moderation build if it survives.

## Requirements

- First decide the direction with the product owner: keep Info Sharing as is, reshape it, or drop it. Record the decision here before any build starts.
- If kept: a BackOffice moderation surface covering both tiers, pending items (approve in place, decline with a required reason) and pending reviews of items, with a manage view and pending-count signals, following the same shape as Scouter Endorsements (ticket 016).
- Existing pieces to build on: the InfoSharingReview model, and the InfoSharingTypes lookup editor already in the LookupTables cluster.

## Notes

- Sibling of ticket 016 (Scouter Endorsements). If a shared moderation pattern emerges there, reuse it.

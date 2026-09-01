# Scouter Endorsements Moderation

Module: 01-adult-member-system
Background: wiki/SD-Migration/Legacy-Navigation-Inventory, Admin Actions under the system administrator nav
Panel: backoffice

## Goal

The legacy system administrator moderates scouter endorsements: a queue of peer endorsements awaiting approval, approved in place or declined with a recorded reason, plus a manage view over existing endorsements. Bring this to the BackOffice, positioned under adult support rather than as a generic admin tool, since endorsements are part of the adult member picture.

## Requirements

- A pending queue: endorsements awaiting moderation (models ScouterReview and ScouterReviewsLike), approve in place, or decline with a required reason.
- A manage view over all endorsements (pending, approved, declined) with the usual filters.
- A pending-count signal for admins, for example a navigation badge on the resource (the legacy dashboard surfaced pending approval counts to the system administrator).
- Legacy members see their own endorsements (My Endorsements). Confirm what the Member panel shows today and keep moderation outcomes consistent with it.

## Notes

- Legacy has three sibling moderation queues (info sharing and its reviews, projects, scouting network listings) that follow the same approve or decline-with-reason shape. They are out of scope here, but if a shared moderation pattern falls out of this build cheaply, note it for those follow-ups.

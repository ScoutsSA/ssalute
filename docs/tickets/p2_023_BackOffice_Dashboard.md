# BackOffice Dashboard

Background: wiki/SD-Migration/Legacy-Navigation-Inventory, dashboards nav (Admin Dashboard)
Panel: backoffice

## Goal

The BackOffice dashboard is currently the stock Filament page with only the account, Filament info and beta warning widgets. The legacy admin dashboard gives the system administrator platform KPI tiles (invested youth, invested adults, active warrants, total invested, parents and helpers, total administered, users active in the last hours) plus pending-action notices. Rebuild that idea here, modernised: KPIs, recent activity tables, and a place that highlights anything in the BackOffice needing attention.

## Requirements

- KPI stat widgets, taking the legacy tile set as the starting list: invested youth, invested adults, active warrants, parents and helpers, overall totals, and recently active users. Review the list with the product owner during the build, the legacy set is a guide, not a spec.
- Recent activity tables: most recent logins, most recent record updates (the audit log already captures changes), and similar. Each row links through to the record or its BackOffice page.
- An attention area: outstanding data-fix findings per fix with counts, linking to the DataFixes worklist pages, plus other actionable queues as they exist (for example pending AAM requests). Built to take future queues, such as the moderation tickets 016, 017 and 019, without redesign.
- Performance: the legacy dashboard recomputed every count with live queries on each page load, and the data-fix findings are also computed live. Cache or throttle expensive widgets so the dashboard stays fast, and keep the findings read path free of writes and logging as the DataFixes convention requires.
- Widgets should degrade gracefully when a source is empty or its feature is disabled.

## Notes

- The legacy admin dashboard is also the only entry point to its bounce and PWA reports. Those are separate decisions (bad email remediation is still an open candidate ticket) and are not part of this dashboard build.
- Login and activity widgets share the data question in ticket 021: make sure Ssalute sessions are recorded, not just legacy ones.

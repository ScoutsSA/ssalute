# Remove Roadmap After Scouts Digital Deprecation

Module: 12-content-community
Gate: Scouts Digital fully deprecated and no longer reading or writing roadmap data
Panel: backoffice

## Goal

The in-app roadmap (the "little roadmap" changelog shown to users) is not migrating to Ssalute. Once Scouts Digital is fully deprecated, remove the feature and its data.

## Requirements

- Remove the RoadmapItems lookup resource from the LookupTables cluster.
- Remove the SystemRoadmapLittle model and drop the system_roadmap_little table with a roll-forward migration. Committed migrations that touched the table historically stay as they are.
- Sweep for any other roadmap related tables, models, settings or references at removal time and take them out in the same pass.

## Notes

- Until the gate passes the legacy app still uses this data, so nothing may be dropped early.

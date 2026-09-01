# Remove Projects After Scouts Digital Deprecation

Module: 12-content-community
Gate: Scouts Digital fully deprecated and no longer reading or writing projects data
Panel: backoffice

## Goal

The community Projects feature (member-submitted project listings with admin approval) is not migrating to Ssalute. Its member-facing nav was already switched off in legacy, leaving only the moderation queue behind. Once Scouts Digital is fully deprecated, remove the feature and its data.

## Requirements

- Remove the ProjectAudiences lookup resource from the LookupTables cluster.
- Remove the Project, ProjectsFor and ProjectsSupported models and drop their tables with a roll-forward migration. Committed migrations that touched them historically stay as they are.
- Sweep for any other projects related tables, models, settings or references at removal time and take them out in the same pass.

## Notes

- Until the gate passes the legacy app still uses this data, so nothing may be dropped early.
- Sibling of ticket 015 (roadmap removal); the two can likely be worked together when the gate passes.

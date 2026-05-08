# Feature: Advancements & Badges

> Module: Advancements & Badges
> Panel(s): Admin (backoffice), Member
> Status: Planned — Needs Human Review
> Phase: 4 — Advancements

---

## Overview

Scouts South Africa uses a structured advancement program for each section. Youth progress through defined levels within their section by completing tasks and challenges to earn each level. Badges are separate achievements (activity, interest, or challenge badges) that can be awarded independently. Star Awards are service-based awards administered at group or regional level.

The four sections each have their own advancement structure:

| Section | Typical Age Range |
|---|---|
| Meerkats | 5 to 8 years |
| Cubs | 8 to 11 years |
| Scouts | 11 to 17 years |
| Rovers | 18 to 26 years |

---

## Backoffice (Admin) Requirements

### Advancement Management

- Administrators can view all youth advancement records across the organisation, organised by section.
- The advancement list shows each youth's name, group, current level, task completion progress (as a count and percentage), and last updated date.
- Filtering is available by level, group, region, completion status (in progress or completed), and date range.
- Search covers youth name, membership number, and group name.
- Administrators can view advancement details, edit advancement records, and add supporting evidence.

### Badge Management

- Administrators can view all badge awards across all sections, with filtering by section, badge type, group, and date range.
- Search covers youth name and badge name.
- Administrators can view badge details and revoke badges (with confirmation and a reason).

### Advancement Level and Task Definitions

- Administrators can manage the level definitions for each section, including level name, description, linked tasks, and ordering.
- Administrators can manage the task and challenge definitions associated with each level within each section.

### Badge Definitions

- Administrators can create, edit, view, and deactivate badge definitions across all sections and tiers (first tier and second tier).
- Each badge definition includes a name, section, tier, description, requirements, and active status.

### Star Awards

- Administrators can view all star awards, filtered by award type, approval status (pending or approved), group, and date range.
- Administrators can approve pending star awards, recording the approver and approval date.
- Administrators can add new star awards directly.
- Group-level star award summaries are available.

### Reports

- Advancement reports include: count of youth at each level per section grouped by group, list of youth at a selected level (filterable by region and group), and advancements completed within a date window. All reports support CSV export.
- Badge reports include: count of badges awarded per badge type grouped by group, and list of youth who hold a specific badge (filterable by group and region). All reports support CSV export.

---

## Member Panel Requirements

All member panel advancement pages are scoped to the leader's own group. Youth from other groups are never accessible.

### View Advancement Progress

- Leaders can view advancement progress for youth in their own group, filtered to their active section role.
- The display shows each youth's current level, task completion progress (as a visual progress indicator), and last activity date.

### Mark Tasks as Complete

- Leaders can mark advancement tasks as complete for youth in their group, recording the completion date and an optional note for each task.
- When all tasks for a level are completed, the system flags the record as level-complete and prompts the leader to confirm and set an official completion date.
- Only leaders assigned to the youth's group may mark tasks.

### Add Supporting Evidence

- Leaders can attach three types of evidence to advancement records: photos (with captions), documents (PDF or image, with descriptions), and free-text notes.
- Evidence can be linked to specific tasks within the advancement.
- Evidence can optionally be linked to an event or program meeting for context.

### Award Badges

- Leaders can award badges to youth in their group by selecting the badge definition (filtered by section and tier), setting the award date, and adding optional notes.
- The youth must be in the correct section for the selected badge. Awarding a badge from a different section is rejected.

### Star Awards

- Leaders can view all star awards for their group's youth and see each award's approval status.
- Leaders can submit new star awards, which are set to pending status for administrator or regional approval.
- Leaders cannot approve star awards themselves.

### Print Advancement Record

- Leaders can generate a printable advancement record for a youth member, showing the youth's name, section, current level, completed tasks with dates, badges held, and star awards. This is used at investiture ceremonies and official Scouting events.

---

## Business Rules and Constraints

- Each section has a distinct advancement structure (challenges, tasks, levels). The system respects these differences rather than forcing a single generic model.
- Level completions support setting an official award date that may differ from the date the last task was marked, accommodating group ceremonies and formal investitures.
- Historical advancement records migrated from the legacy system are flagged for traceability.
- Some star award types are based on accumulated service hours. The system accommodates a service hours field for those types.
- Badge awards are validated against the youth's current section. A badge from a different section cannot be awarded.
- Star awards follow an approval workflow: leaders submit, administrators or regional leaders approve.
- The printable advancement record is a key deliverable for leaders and must prioritise readability and correct section branding.

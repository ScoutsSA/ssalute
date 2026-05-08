# Feature Spec: Advancements & Badges

> Module: Advancements & Badges
> Panel(s): Admin (backoffice), Member
> Status: PLANNED (Lookup pages scaffolded under Advancements cluster)
> Phase: 4 — Advancements

---

## Overview

Scouts South Africa uses a structured advancement program for each section. Youth progress through defined levels within their section, completing tasks and challenges to earn each level. Badges are separate achievements (activity, interest, or challenge badges). Star Awards are service-based awards administered at group or regional level.

The Advancements cluster already exists in the admin panel with lookup/definition pages scaffolded. This spec covers the full operational layer: recording individual youth advancements, awarding badges, and managing star awards.

---

## Key Models

### Meerkat Advancements & Badges

| Model | Table | Purpose |
|---|---|---|
| `AdvancementMeerkat` | `advancement_meerkats` | Individual youth advancement record (Meerkat section) |
| `SystemAdvancementMeerkatsLevel` | `system_advancement_meerkats_levels` | Level definitions for Meerkats |
| `SystemAdvancementMeerkatsChallenge` | `system_advancement_meerkats_challenges` | Challenge definitions for Meerkats |
| `BadgesMeerkat` | `badges_meerkats` | Individual badge award record (Meerkat section) |
| `SystemBadgeMeerkatsFirst` | `system_badge_meerkats_first` | First-tier badge definitions (Meerkats) |
| `SystemBadgeMeerkatsSecond` | `system_badge_meerkats_second` | Second-tier badge definitions (Meerkats) |

### Cub Advancements & Badges

| Model | Table | Purpose |
|---|---|---|
| `AdvancementCub` | `advancement_cubs` | Individual youth advancement record (Cub section) |
| `SystemAdvancementCubsLevel` | `system_advancement_cubs_levels` | Level definitions for Cubs |
| `SystemCubsTask` | `system_cubs_tasks` | Task definitions for Cubs |
| `BadgesCub` | `badges_cubs` | Individual badge award record (Cub section) |
| `SystemBadgeCubsFirst` | `system_badge_cubs_first` | First-tier badge definitions (Cubs) |
| `SystemBadgeCubsSecond` | `system_badge_cubs_second` | Second-tier badge definitions (Cubs) |

### Scout Advancements & Badges

| Model | Table | Purpose |
|---|---|---|
| `AdvancementScout` | `advancement_scouts` | Individual youth advancement record (Scout section) |
| `SystemAdvancementScoutsLevel` | `system_advancement_scouts_levels` | Level definitions for Scouts |
| `SystemAdvancementScoutsSecond` | `system_advancement_scouts_second` | Second advancement stream definitions |
| `SystemAdvancementScoutsSecondEntshaBadge` | `system_advancement_scouts_second_entsha_badges` | Entsha badge definitions within Scout second stream |
| `SystemAdvancementScoutsSecondEntshaTheme` | `system_advancement_scouts_second_entsha_themes` | Entsha theme definitions within Scout second stream |
| `SystemScoutTask` | `system_scout_tasks` | Task definitions for Scouts |
| `BadgesScout` | `badges_scouts` | Individual badge award record (Scout section) |
| `SystemBadgeScoutsFirst` | `system_badge_scouts_first` | First-tier badge definitions (Scouts) |
| `SystemBadgeScoutsSecond` | `system_badge_scouts_second` | Second-tier badge definitions (Scouts) |

### Rover Advancements & Badges

| Model | Table | Purpose |
|---|---|---|
| `AdvancementRover` | `advancement_rovers` | Individual youth advancement record (Rover section) |
| `SystemAdvancementRoversLevel` | `system_advancement_rovers_levels` | Level definitions for Rovers |
| `SystemAdvancementRoversChallenge` | `system_advancement_rovers_challenges` | Challenge definitions for Rovers |
| `SystemRoverTask` | `system_rover_tasks` | Task definitions for Rovers |
| `BadgesRover` | `badges_rovers` | Individual badge award record (Rover section) |
| `SystemBadgeRoversFirst` | `system_badge_rovers_first` | First-tier badge definitions (Rovers) |
| `SystemBadgeRoversSecond` | `system_badge_rovers_second` | Second-tier badge definitions (Rovers) |

### Supporting Evidence

| Model | Table | Purpose |
|---|---|---|
| `AdvancementPhoto` | `advancement_photos` | Photo evidence attached to an advancement record |
| `AdvancementDocument` | `advancement_documents` | Document evidence attached to an advancement record |
| `AdvancementNote` | `advancement_notes` | Free-text note attached to an advancement record |

### Context Links

| Model | Table | Purpose |
|---|---|---|
| `GroupAdvancementsInEvent` | `group_advancements_in_events` | Links advancement activity to an event |
| `GroupAdvancementsInProgram` | `group_advancements_in_programs` | Links advancement activity to a program meeting |

### Star Awards

| Model | Table | Purpose |
|---|---|---|
| `StarAward` | `star_awards` | Individual star award record for a youth |
| `SystemStarAwardType` | `system_star_award_types` | Star award type definitions |
| `GroupStarAward` | `group_star_awards` | Group-level star award tracking record |

---

## Filament Cluster

**Location:** `app/Filament/Admin/Clusters/Advancements/`

The Advancements cluster already exists. Lookup/definition pages are scaffolded. New resources for operational records (individual advancements, badges, star awards) are added within this cluster.

---

## Backoffice Panel (Admin) Requirements

### 1. All Advancements — Per Section

One resource per section, or a unified resource with section-based tab navigation.

- **Classes (per section pattern):**
  - `app/Filament/Admin/Clusters/Advancements/Resources/MeerkatAdvancementResource.php`
  - `app/Filament/Admin/Clusters/Advancements/Resources/CubAdvancementResource.php`
  - `app/Filament/Admin/Clusters/Advancements/Resources/ScoutAdvancementResource.php`
  - `app/Filament/Admin/Clusters/Advancements/Resources/RoverAdvancementResource.php`
- **Table columns:** Youth name, group, current level, tasks completed (count), tasks total (count), percentage complete, last updated
- **Filters:** Level, group, region, completion status (in progress / completed), date range (last updated)
- **Search:** Youth name, membership number, group name
- **Row actions:** View advancement detail, Edit advancement, Add evidence

### 2. All Badges Awarded

- **Class:** `app/Filament/Admin/Clusters/Advancements/Resources/BadgeAwardResource.php`
- **Scope:** Cross-section, with a section filter to narrow down
- **Table columns:** Youth name, group, section, badge name, tier (first/second), award date, awarded by
- **Filters:** Section, badge type, group, date range
- **Search:** Youth name, badge name
- **Row actions:** View badge detail, Revoke badge (with confirmation and reason)

### 3. Manage Advancement Level Definitions

Already scaffolded as lookup pages in the Advancements cluster. Each section has its own levels management page.

- Verify existing pages cover: level name, description, tasks linked to that level, ordering.
- Add task management sub-pages (CRUD for `SystemCubsTask`, `SystemScoutTask`, `SystemRoverTask`, `SystemAdvancementMeerkatsChallenge`, `SystemAdvancementRoversChallenge`).

### 4. Manage Badge Definitions

- **Class:** `app/Filament/Admin/Clusters/Advancements/Resources/BadgeDefinitionResource.php`
- **Scope:** System-level CRUD for all badge definition tables (first-tier and second-tier per section)
- **Fields:** Badge name, section, tier, description, requirements, active flag
- **Actions:** Create, Edit, Deactivate (soft-delete or active flag toggle), View

### 5. Star Awards Management

- **Class:** `app/Filament/Admin/Clusters/Advancements/Resources/StarAwardResource.php`
- **Table columns:** Youth name, group, award type, service hours (if applicable), status (pending / approved), award date, approved by
- **Filters:** Award type, status, group, date range
- **Actions:**
  - View star award detail
  - Approve pending award (sets status to approved, records approver and date)
  - Add star award (modal: youth, award type, service description, date)
  - View group-level star award summary (`GroupStarAward`)

### 6. Advancement Reports

- **Class:** `app/Filament/Admin/Clusters/Advancements/Pages/AdvancementReports.php`
- **Report types:**
  - By group: count of youth at each level per section
  - By level: list of youth at a selected level (filterable by region/group)
  - By date range: advancements completed within a date window
- **Export:** CSV download for all report types

### 7. Badge Reports

- **Class:** `app/Filament/Admin/Clusters/Advancements/Pages/BadgeReports.php`
- **Report types:**
  - By group: count of badges awarded per badge type
  - By badge type: list of youth who hold a specific badge (filterable by group/region)
- **Export:** CSV download

---

## Member Panel Requirements

All member panel advancement pages are scoped to the leader's own group. Youth from other groups are never accessible.

### 1. View Youth Advancement Progress (By Section)

- **Class:** `app/Filament/Member/Resources/AdvancementResource/Pages/ListAdvancements.php`
- **Scope:** Own group only, filtered to the leader's active section role
- **Display:** Youth list with current level, progress bar (tasks completed / total), last activity date
- **Actions:** View individual advancement, Open edit/record page

### 2. Mark Advancement Tasks as Complete

- **Class:** `app/Filament/Member/Resources/AdvancementResource/Pages/RecordAdvancement.php`
- **Form:** Checklist of tasks for the youth's current level; each task can be marked complete with a date and optional note
- **On save:** Updates the relevant advancement record (`AdvancementMeerkat`, `AdvancementCub`, etc.)
- **Level completion:** When all tasks for a level are marked complete, the system automatically flags the record as level-complete and prompts the leader to confirm and set an official completion date
- **Authorization:** Only leaders assigned to the youth's group may mark tasks

### 3. Add Supporting Evidence

- **Type:** Relation managers on the advancement view/edit page
- **Evidence types:**
  - Photo: upload image, add caption, link to specific task(s) — creates `AdvancementPhoto`
  - Document: upload file (PDF/image), add description, link to task(s) — creates `AdvancementDocument`
  - Note: free-text note with date, optionally linked to task(s) — creates `AdvancementNote`
- **Context links:** Optionally link evidence to an event (`GroupAdvancementsInEvent`) or program meeting (`GroupAdvancementsInProgram`)

### 4. Award Badge to Youth

- **Class:** Custom action on youth advancement view or dedicated badge page
- **Fields:** Youth (pre-filled if accessed from youth record), badge definition (dropdown filtered by section and tier), award date, awarded by (defaults to current user), notes
- **On save:** Creates the relevant badge award record (`BadgesMeerkat`, `BadgesCub`, etc.)
- **Validation:** Youth must be in the correct section for the badge definition selected

### 5. View and Add Star Awards

- **Class:** `app/Filament/Member/Resources/StarAwardResource/Pages/ListStarAwards.php`
- **Scope:** Own group only
- **Leaders can:** View all star awards for their group's youth; submit a new star award (sets status to pending for admin approval); view approval status
- **Leaders cannot:** Approve star awards (admin/regional only)

### 6. Print Advancement Record

- **Type:** Custom action on the youth advancement view page
- **Output:** Generates a printable view (Blade view rendered to browser print dialog or downloadable PDF) showing the youth's name, section, current level, completed tasks with dates, badges held, and star awards
- **Class:** `app/Filament/Member/Resources/AdvancementResource/Actions/PrintAdvancementAction.php`

---

## Tests Required

| Test | File | Type |
|---|---|---|
| Super admin can access advancement admin resources | `tests/Feature/Filament/Admin/Advancements/AdvancementsClusterTest.php` | Feature |
| Super admin can view advancements per section | `tests/Feature/Filament/Admin/Advancements/AdvancementsClusterTest.php` | Feature |
| Super admin can manage badge definitions | `tests/Feature/Filament/Admin/Advancements/BadgeDefinitionTest.php` | Feature |
| Super admin can approve a star award | `tests/Feature/Filament/Admin/Advancements/StarAwardTest.php` | Feature |
| Advancement level lookup pages load correctly | `tests/Feature/Filament/Admin/Advancements/AdvancementsClusterTest.php` | Feature |
| Group leader can view their group's advancements in the member panel | `tests/Feature/Filament/Member/Advancements/AdvancementAccessTest.php` | Feature |
| Group leader can mark advancement tasks as complete | `tests/Feature/Filament/Member/Advancements/AdvancementAccessTest.php` | Feature |
| Group leader cannot view or edit another group's advancements | `tests/Feature/Filament/Member/Advancements/AdvancementAccessTest.php` | Feature |
| Badge award is created for the correct section only | `tests/Feature/Filament/Member/Advancements/BadgeAwardTest.php` | Feature |
| Badge award for wrong section is rejected | `tests/Feature/Filament/Member/Advancements/BadgeAwardTest.php` | Feature |
| Star award submit sets status to pending | `tests/Feature/Filament/Member/Advancements/StarAwardTest.php` | Feature |
| Star award approval by admin changes status and records approver | `tests/Feature/Filament/Admin/Advancements/StarAwardTest.php` | Feature |
| Supporting evidence (photo, document, note) can be added to an advancement | `tests/Feature/Filament/Member/Advancements/AdvancementEvidenceTest.php` | Feature |

---

## Notes & Considerations

- **Section-specific schemas:** Each section has a meaningfully different advancement structure (challenges vs. tasks vs. levels). Avoid forcing a single generic schema — use the section-specific models as intended but extract shared UI patterns into reusable Filament components where practical.
- **Level-completion ceremony:** In practice, level completions are often awarded at group ceremonies. The system should support setting an official award date that may differ from the date the last task was marked.
- **Legacy data:** Historical advancement records from scouts-digital will be migrated. The `AdvancementPhoto`, `AdvancementDocument`, and `AdvancementNote` models should support an `imported_from_legacy` flag for traceability.
- **Star awards and service hours:** Some `SystemStarAwardType` entries are based on accumulated service hours. The schema should accommodate a `service_hours` field on `StarAward` for those types.
- **Print record:** The printable advancement record is a key deliverable for leaders — it is used at investiture ceremonies and official Scouting events. Prioritise readability and correct section branding in the print layout.

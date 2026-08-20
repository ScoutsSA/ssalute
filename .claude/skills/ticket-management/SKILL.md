---
name: ticket-management
description: Manage Ssalute work tickets in docs/tickets. Activate when the user asks to create, list, pick up, work on, complete, split or re-prioritise a ticket, asks what to work on next, or mentions a ticket by number (e.g. "ticket 004"). Covers the pX priority prefix, numbering, how tickets relate to docs/BRD.md, docs/features and docs/wiki, the branch and commit rules, the definition of done, and archiving into docs/tickets/completed.
license: MIT
metadata:
  author: John Roux
---

# Ticket Management (Ssalute)

## Overview

Tickets are lightweight markdown work items in `docs/tickets/`. One file per piece of work, or one folder when the work is big enough to split into pieces that ship separately (see Epics). When a ticket is finished it moves into a `completed/` folder with a completion date prefix and a written record of how it was resolved.

**This is the live work queue.** Ssalute is a migration of a legacy raw PHP system (Scouts Digital) onto Laravel 12 and Filament v5, so the repository is full of documents that describe the legacy behaviour or a plan from a particular week. None of them sequence current work. Mine them for detail and reasoning, then decide the order here.

## Directory layout

```
docs/tickets/
    p2_003_Event_For_Enums_Do_Not_Match_Data.md    open tickets, pX-prioritised, XXX-numbered
    p6_011_Census_Snapshot_Rebuild.md
    p8_012_Youth_Roster_V2/                        an EPIC: same naming, but a folder
        README.md                                  the epic body itself
        p6_015_Roster_Import_Model.md              child tickets, own bands, global numbers
        p3_017_Section_Transfer_Audit.md
        completed/
            2026-08-14_013_Roster_Read_Model.md
    completed/
        2026-08-20_001_Legacy_Race_Values_Fatal.md no pX prefix; priority is recorded inside
        2026-08-22_009_Warrant_Expiry_Notices/     a completed epic keeps its shape
```

The tree above is illustrative, and its numbers are not reserved. Derive the next number from what actually exists under `docs/tickets/`, never from this example.

## Naming conventions

- Open tickets: `pX_XXX_Short_Title.md`.
  - `pX` is the priority band, `p0` (foundation work the queue waits on) and `p1` (next up) through `p9` (very low). See below.
  - `XXX` is a zero-padded three-digit number (`001`, `002`, ... `042`).
- Numbers are assigned sequentially and never reused, even after a ticket is completed. **There is one number pool for the whole system**, shared by flat tickets, epic folders and the child tickets inside them, so a number identifies exactly one piece of work no matter where it sits. To find the next number, take the highest in use anywhere under `docs/tickets/` and increment:

  ```bash
  find docs/tickets \( -name '*.md' -o -type d \) \
    | sed -nE 's#.*/(p[0-9]|[0-9]{4}-[0-9]{2}-[0-9]{2})_([0-9]{3})_.*#\2#p' \
    | sort -n | tail -1
  ```

  **Check for collisions**: two open tickets sharing a number is a bug, renumber the one filed later.
- Titles use underscores, not spaces, and Title_Case words.
- Completed tickets: `YYYY-MM-DD_XXX_Short_Title.md`, or `YYYY-MM-DD_XXX_Short_Title/` for a completed epic, where the date is the day it was completed. **The `pX_` prefix is dropped from the name and recorded inside the file instead** (see Completing a ticket), so the archive sorts by date rather than by a priority that no longer applies.

## Priority bands

The prefix is the queue, and the lowest band in play is what to pick up next. **Do not read that queue with a bare `ls`**: it shows epic folders but not the children inside them, and children carry their own bands. Use the commands under Listing and status.

The bands below are written for what actually hurts on this product. Ssalute holds the membership records of a youth organisation: children's personal data, adult warrants and their vetting state, an area hierarchy (region, district, group) that scopes who may see whom, and a census that determines money. It also runs alongside the legacy system rather than after it, so wrong data is frequently written by something outside this codebase.

| Band | Means |
|---|---|
| `p0` | Foundation work that everything else waits on. Reserved for a deliberately sequenced programme of platform, migration or tooling work, agreed as taking precedence over the ordinary queue. A `p0` is not more urgent than a `p1` outage, it is upstream of the whole backlog. Do not file one casually. |
| `p1` | Safeguarding or privacy is compromised, or production is broken. Youth data is visible to somebody outside its area scope, an adult without a valid warrant has access they should not have, personal data is in a public payload, or a surface members use is down. |
| `p2` | Production health: real user visible degradation, a nightly job failing silently, an unmonitored failure mode, an authorization path that is correct only by accident, credentials or access outliving their need. |
| `p3` | Correctness bugs that reach members or administrators without breaking anything: a wrong census count, a warrant expiry that does not fire, an advancement record that drops out of a report, a legacy value that renders as blank. |
| `p4` | Scheduled cleanups, hygiene and technical debt, including date gated ones whose gate is near. Data integrity work that is not yet hurting anybody lands here. |
| `p5` | Work committed to the Scouts SA office or to a specific region or district. Someone outside the repository is expecting it on a date. |
| `p6` | New features with a clear near term payoff, and cleanups whose gate is further out. |
| `p7` | Worthwhile features that nothing is waiting on. |
| `p8` | Large builds and whole legacy modules still to migrate. Real value, big commitment. The `docs/features/` module directories are the natural candidates. |
| `p9` | Speculative, exploratory, or explicitly low priority. |

Bands are buckets, not a strict total order: several tickets can share a band, and within one, pick by judgement.

**Re-prioritising is just a rename.** `git mv docs/tickets/p7_011_Census_Snapshot_Rebuild.md docs/tickets/p3_011_Census_Snapshot_Rebuild.md`. Do it whenever the reasoning changes (a gate date passes, a bug escalates, a dependency lands) and say why in the commit message. Do not add a priority line to the body of an OPEN ticket; the filename is the single source of truth while it is open, and a second copy will drift.

**A date gated ticket keeps its gate in the body, not in the priority.** The band says how much we care; the gate says when it becomes legal to start. A `p4` ticket that cannot start until a dependency lands is still `p4`. Census work is frequently gated on a census period, which is a real gate and belongs in the body.

## Epics: when a ticket needs a folder

A ticket that is too big to be one file becomes a **folder with the same name a file would have had**. That is the whole mechanism: `p8_012_Youth_Roster_V2/` instead of `p8_012_Youth_Roster_V2.md`, same band, same number, same Title_Case.

**Default to a flat file.** Promote to a folder only when the work genuinely splits into pieces that ship on their own branches and PRs, span multiple sessions, and would otherwise turn one file into a moving target that gets rewritten every session. A whole legacy module still to migrate is the obvious candidate. A merely long ticket is still a file.

Inside the folder:

- **`README.md` is the epic body.** Same freeform markdown as any ticket, same header lines (`Module:`, `Background:`, `Gate:`, `Panel:`). It states the goal of the whole thing and the shape of the split. Do not maintain a child checklist in it; the folder listing is the source of truth for what exists, and a second copy will drift the way a priority line in a body does.
- **Children are ordinary tickets**, `pX_XXX_Short_Title.md`, each with its own priority band and its own number **from the same global pool**. A number therefore identifies exactly one piece of work repository wide, and "ticket 015" is never ambiguous about whether it means a child or a top level ticket.
- **The epic has its own `completed/`.** Children archive into `<epic>/completed/`, not the top level one, so the epic's record stays whole while it is open.
- **One level only.** No epic inside an epic. If a child is large enough to want its own folder then it is not a child: pull it out to the top level as an epic in its own right and cross reference the two by number.

**Bands.** The folder's band is the claim the whole body of work makes on attention. A child may carry a higher band than its parent, which is normal: a `p1` safeguarding bug found while doing `p8` work is still a `p1`. If that keeps happening, the epic itself is under banded and should be renamed. Re-banding an epic is a folder rename, exactly like a file.

**Promoting a flat ticket to an epic**, keeping its number and band:

```bash
mkdir docs/tickets/p8_012_Youth_Roster_V2
git mv docs/tickets/p8_012_Youth_Roster_V2.md docs/tickets/p8_012_Youth_Roster_V2/README.md
```

Nothing about the ticket's identity changes, it grew a folder. Demoting back is the reverse, and is fair game when the split turned out to be unnecessary and only the README ever had content.

**Working a child** is identical to working a flat ticket: its own branch, its own definition of done, its own completion rewrite, archived into `<epic>/completed/`. A child is not "done" because the epic is progressing.

**Completing an epic.** When every child is completed or split out:

1. Rewrite `README.md` into the completion format, same sections as any ticket. `## Resolution` summarises across the children and references them by number rather than restating them, since their own records sit in the folder.
2. Move the whole folder, contents and all:
   ```bash
   git mv docs/tickets/p8_012_Youth_Roster_V2 "docs/tickets/completed/$(date +%F)_012_Youth_Roster_V2"
   ```
   The children's `completed/` folder rides along inside it. Do not flatten the children out into the top level archive, the grouping is the point.

**Abandoning an epic** is a legitimate outcome and uses the same move. Complete the README, list what was dropped and why under `## Decisions`, and for each unstarted child either delete it (git keeps the record) or promote it to a top level ticket if it still has value on its own. Say explicitly which, per child.

## How tickets relate to the other documentation

- **`docs/BRD.md` is the scope of record.** Section 8 lists the modules. A ticket may cite it for what the product is meant to do. Keep module statuses honest when a ticket changes one.
- **`docs/features/NN-module-name/` holds the per module specs and acceptance criteria.** Read the relevant one before starting a ticket in that module, and **fix it in the same commit** when a ticket makes something in it wrong. If it disagrees with the code, the code wins and the document needs the fix.
- **`docs/wiki/` is a git submodule holding the functional wiki of the LEGACY system.** It describes what Scouts Digital does, not what Ssalute does. Cite it for the behaviour being migrated (`Background: wiki/youth-management#transfers`), and quote what you need rather than sending the reader into it. **Never commit inside the submodule as part of closing a ticket.** If `git status` shows `docs/wiki` modified, that is almost always an accident, and it must not ride along in a ticket commit.
- **`CLAUDE.md` carries the hard rules**, including the Laravel Boost guidelines, the Spatie coding standards, the settings and data fix conventions, and the identifier display rules. A ticket never restates them, and a ticket that invalidates one fixes it in the same commit.
- **The domain skills are the implementation route.** A ticket that adds a setting says so and lets `adding-a-setting` carry the mechanics; likewise `adding-a-data-fix`, `configuring-horizon`, `laravel-sync`, `fluxui-development`, `tailwindcss-development`, `spatie-laravel-php-standards`. Name the skill in the ticket rather than duplicating its checklist.

**Do not copy volatile numbers into a ticket body as bare fact.** Suite counts, row counts measured against a synced database, and findings counts all move. If a ticket needs one, date it and say how to re-derive it:

> As of 2026-08-20 the suite is green at 453 tests. Re-derive with `php artisan test --compact`, do not trust this line.

This matters more here than in most repositories, because a local database comes from `rouxt:sync` and is a dated copy of production. A row count is a measurement of one snapshot, not a property of the system.

## Creating a ticket

1. Determine the next number (see above).
2. Choose a priority band. Place it against the tickets already sitting in that band rather than judging it in isolation, and say in one line why it landed there. If unsure between two bands, take the lower priority; a ticket is cheap to promote later.
3. Create `docs/tickets/pX_XXX_Short_Title.md`. If it is large enough to need splitting, create `docs/tickets/pX_XXX_Short_Title/README.md` instead and read the epic rules above. When in doubt, file the flat ticket; promoting it later keeps its number and costs one `git mv`.
4. Content is freeform markdown. A good ticket states the goal, any constraints, and rough scope. Bullet lists of requirements are the norm. No frontmatter is required, and no priority line in the body.
5. Include, when they apply, as single lines near the top:
   - `Module: NN-module-name` for the `docs/features/` directory this belongs to.
   - `Background: wiki/<page> <section>` for the legacy behaviour being migrated. Context only, never sequencing.
   - `Gate: <date or condition>` for when it becomes legal to start.
   - `Panel: member | backoffice | holding zone | console`. This matters here because the three Filament panels have genuinely different rules: the BackOffice panel (`admin`, `/backoffice`) is restricted to super users and shows record IDs alongside names, the Member panel never exposes settings and shows names only, and console work has no panel at all. A ticket that does not say which one invites the wrong approach.

## Working a ticket

- **Picking one up.** Asked for "the next ticket" or "what should I work on", take the lowest `pX`, and within a band prefer the one that unblocks others. Check any date gate in the body before starting; if the gate has not passed, say so and move to the next candidate rather than starting anyway.
- **Epic children compete on their own band**, not their parent's. A `p3` child inside a `p8` epic is a `p3` and outranks a flat `p6`. What you never do is pick up an epic folder itself as a unit of work: read its `README.md`, then work one child.
- Read the whole ticket before starting, then the relevant `docs/features/` spec, then any wiki page it cites for the legacy behaviour.
- **Note the priority you picked it up at**, so the completion record can state it. It is in the filename you just opened.
- If scope changes or decisions are made mid-flight, append them to the ticket file as you go so the completion record is easy to write later. A `## Notes` section at the bottom works well.
- A ticket may be delivered across multiple sessions or PRs. It stays in `docs/tickets/` until the completion criteria below are met.
- **Ticket work is committed work.** Being asked to work a ticket IS the instruction to commit what you deliver. Do not ask "should I commit?", do not end your turn with ticket changes sitting uncommitted, and do not treat any generic "commit only when asked" guidance as applying here; the ticket process asked.

### Branch and merge rules, specific to this repository

The commit permission above is scoped to a feature branch. It is NOT permission to merge or deploy.

- **Work on a branch, never on `master` directly.** Cut it from an up to date `master`, using the prefixes the repository already uses (`feature/`, `cc/`).
- **Merging and deploying are outward facing actions.** Ask before doing either, every time. A completed ticket does NOT mean the change is live.
- **Never mention Claude Code in a PR description, PR comment or issue comment**, and do not add a "Test plan" section to a PR description. Both are standing rules from the user's global instructions.
- Use the `gh` CLI for anything on GitHub.

## Completing a ticket

Close a ticket once the work is finished and a full review is clean (see Definition of done). If any line there is unresolved, the ticket stays open.

**The completion belongs in the work's own final commit or PR, not after it.** Rewrite and `git mv` the ticket BEFORE that commit, so the commit that delivers the work also closes the ticket. Do not hold a ticket open waiting for a merge or a deploy. Those are shipping gates and they are the operator's, not the ticket's.

1. **Work out which `completed/` this ticket archives into.** A flat ticket and a whole epic go to `docs/tickets/completed/`. **A child of an epic goes to `<epic>/completed/`**, not the top level one. Create the directory if it does not exist.
2. If only part of the ticket was delivered, split first: carve the undelivered remainder into a new ticket (next available number), then complete the original, noting the split under `## Decisions`. A child's follow-up normally belongs in the same epic folder, alongside it.
3. Rewrite the ticket file so it records, in this order:
   - `# <Ticket title>` heading.
   - `**Priority when actioned:** pX` on its own line directly under the heading, taken from the `pX_` prefix the ticket carried when the work started. If it was re-prioritised mid-flight, record where it ended up and note the move under `## Decisions`. This is the only place a priority is ever written into a ticket body.
   - `## Synopsis`, a short paragraph on what the ticket asked for.
   - `## Resolution`, how it was actually solved: the approach taken, key files or subsystems touched, the branch name, and relevant commits or PRs if known.
   - `## Verification`, what was actually run and what was only reasoned about. State the suite result, and say plainly which claims are unverified. If verifying needs a production shell, a synced database, a Slack webhook or a super user login, say that instead of implying it was done. A count measured against a `rouxt:sync` copy is dated evidence, so date it.
   - `## Risk assessment`, what could break, which conventions were bent, what is untested or only heuristically verified, what a future upgrade could silently regress. Legacy tables with no foreign keys and columns written by the legacy system belong here.
   - `## Decisions`, decisions made along the way, especially where the outcome differs from the original request (scope cuts, deferred items, alternative approaches chosen and why). Note anything deliberately left out, and reference a follow-up ticket by number if one was created.
   - `## Original ticket`, the original ticket text preserved verbatim.
4. Move it with git so history follows the file, into the `completed/` you identified in step 1:
   ```bash
   # a flat ticket
   git mv "docs/tickets/pX_XXX_Short_Title.md" "docs/tickets/completed/$(date +%F)_XXX_Short_Title.md"

   # a child of an epic: same shape, one directory down
   git mv "docs/tickets/p8_012_Epic/pX_XXX_Short_Title.md" \
          "docs/tickets/p8_012_Epic/completed/$(date +%F)_XXX_Short_Title.md"
   ```
   Use the actual completion date, which is normally today. **Drop the `pX_` prefix**, it has already been recorded inside the file. Completing a whole epic moves the folder instead, see Epics above.
5. **Commit.** Stage the ticket move together with the delivered work and commit it, without asking. A ticket whose completion file only exists in the working tree is NOT closed.

## Definition of done

The ticket is done when every line below is true, checked in this order. If the last one is false, none of the rest count.

- **Suite green.** `php artisan test --compact`. Any red is a real failure, there is no tolerated failure exception. Take the baseline count from a committed ref, never from `git stash`.
- **`vendor/bin/duster fix --dirty` has been run.** Duster wraps Pint and other formatters; never run Pint directly.
- **Behaviour that changed has test coverage**, added in this same piece of work. This is a hard rule in `CLAUDE.md`, not optional follow up. Most tests should be feature tests, written for PHPUnit, created with `php artisan make:test`.
- **The new tests can actually observe the change.** Mutate the code the ticket touched and name a test that goes red. A suite that never exercised the changed path stays green under every mutation of it and reads as proof while proving nothing. If no test reds, say so in the ticket and either add one that observes it or state plainly that correctness rests on reading the diff. Assert the mutation applied: a mutation whose anchor does not match is indistinguishable from one that survived.
- **`docs/features/` corrected in the same commit** wherever the ticket made it wrong, along with `docs/BRD.md` if a module status changed and `CLAUDE.md` if a hard rule changed. Do not commit inside the `docs/wiki` submodule.
- **Diff re-read end to end.**
- **Undelivered scope split into a follow-up ticket.** For a child, that follow-up normally belongs in the same epic folder. For an epic, every child is completed, promoted out or explicitly dropped under `## Decisions`.
- **Priority when actioned recorded in the ticket body.**
- **Ticket rewritten** (Synopsis, Resolution, Verification, Risk assessment, Decisions, Original ticket) and `git mv`'d into the right `completed/`, with the `pX_` prefix dropped. Top level for a flat ticket or a whole epic, `<epic>/completed/` for a child.
- **Everything is COMMITTED and `git status` is clean.** Reporting a ticket as complete while this is false is the process failure this checklist exists to prevent.

Merging, deploying and verifying on production are explicitly NOT on this list. They are the operator's calls and they happen after.

## Listing and status

- "What tickets are open?" means every open ticket, flat and child alike. Present them grouped by band, highest priority first, with each child marked by its epic so the band ordering stays readable:

  ```bash
  # every open ticket. README.md is excluded because inside an epic folder it is
  # the epic body, not a ticket
  find docs/tickets -name '*.md' -not -path '*/completed/*' -not -name 'README.md' | sort

  # the epics themselves
  find docs/tickets -mindepth 1 -maxdepth 1 -type d -not -name completed | sort
  ```
- "What should I work on next?" means the lowest `pX` whose date gate, if any, has passed, counting epic children on their own bands.
- "What was done recently?" means list `docs/tickets/completed/` sorted by date prefix. A completed epic appears there as one dated folder; its children are inside it, dated individually.
- "How is epic NNN going?" means list the epic folder and its `completed/` side by side. Remaining children versus archived ones is the progress report, and it needs no separately maintained status line.
- A split-off follow-up ticket gets its own priority band, which is usually LOWER than its parent: the parent shipped without it, which is evidence it can wait.

## Writing style

The user's global instructions ban dashes as sentence punctuation in documentation, and that includes ticket bodies and completion records. Rephrase with periods, commas, colons or parentheses. Hyphens inside compound words and filenames are fine. Do not use emojis excessively.

# Legacy race values with trailing whitespace fatal every surface that reads a user

**Priority when actioned:** p2

## Synopsis

Opening member #19476 threw `ValueError: "African " is not a valid backing value for enum App\Enums\UserRace`. The stored value was a valid race case with a trailing space, and because `race` was a backed enum cast, every surface that hydrated the model fataled rather than degrading. The ticket started as that one crash and grew, on the operator's direction, into a general treatment of legacy values that do not match their enum: trim what is only whitespace, and raise the rest for an admin to decide.

## Resolution

Delivered on branch `botty-review`, in the commit that carries this file.

**The crash.** `race` moved off the enum cast onto an `Attribute` whose getter calls a new `UserRace::fromLegacyValue()`. Reads became tolerant (whitespace trimmed, blank returns null, unknown returns null instead of throwing) while writes stayed strict and throw `InvalidArgumentException` on an unrecognised value. Leniency was deliberately not applied to every enum: for anything gating authorization or money, a loud failure beats a quiet wrong answer.

**The general fix.** `App\Services\SystemFixes\EnsureLegacyValuesAreCanonical` runs three passes over a declarative column map:

1. **Trim**, unconditional and automatic, over 13 columns on 4 tables. Writes go through the query builder so `modified` is not stamped and no audit row is emitted per record.
2. **Clear**, for columns explicitly flagged `clear: true`. Only `system_users.title` carries it.
3. **Report**, for every other unrecognised enum value, raised as a per record finding rather than guessed at.

**The reporting contract.** `ReportsFindings` (`findings()` plus `findingsUrl()`) lets a fix list what it found without changing anything, so the same list feeds a page, an alert count and a run report. `SystemFixFinding` is record shaped rather than summary shaped, because an admin cannot act on "204 rows", only on a member they can open. All four registered fixes implement it.

**The admin surface.** `App\Filament\Admin\Clusters\DataFixes` with one page per fix, each calling `findings()` live, so a finding somebody has already fixed disappears on refresh. A page may declare a `solveAction()`, and when it does the whole row is that action. Home Location Roles declares one: a modal offering the member's own role locations as radio options, writing the chosen one without touching their roles.

**The notification.** Slack now carries a count and a link instead of a dump of every flagged record, on the operator's instruction that an alert should ping that there is something to do rather than try to be the tool for doing it.

Key files: `app/Enums/UserRace.php`, `app/Models/SystemUser.php`, `app/Services/SystemFixes/` (the fix, `ReportsFindings`, `SystemFixFinding`, and changes to the other three fixes), `app/Console/Commands/RunSystemFixes.php`, `app/Filament/Admin/Clusters/DataFixes/`, `app/Settings/DataFixesSettings.php` and its migration.

## Verification

**Verified by running it.**

- Full suite green on 2026-08-20: 453 passed, 3 skipped, 1,108 assertions, 0 failures. Re-derive with `php artisan test --compact`, do not trust this line.
- `vendor/bin/duster fix --dirty` run and clean.
- 18 mutations applied and all 18 red. The last six covered the review pass (the overflow finding, the exact cap boundary, the remainder arithmetic, and a log line reintroduced into each of the three read paths).
- Run against a `rouxt:sync` copy (`scouterg_2026_07_17`) on 2026-08-19 at 19:24:54. Trimmed 3,640 rows across 8 columns. Two further runs changed nothing, so it is idempotent, and `modified` was not stamped. Member #19476 now stores `African`.
- Findings counts measured on 2026-08-20 against that same copy: Legacy Values 0, Home Location Roles 76, Primary Roles 0, Youth Member Ids 7. These are a measurement of one dated snapshot, not a property of the system.

**Not verified, stated plainly.**

- **No Slack alert has ever been observed arriving in a channel.** The format is asserted with `SlackAlert::fake()` only. The seven real jobs that would have sent were cleared from Horizon at the operator's instruction before any worker ran them. Whether the message renders as intended in Slack is unconfirmed.
- The findings pages were exercised through Livewire tests, not opened in a browser against the synced database.
- The `RECORDS_PER_COLUMN` overflow path is proven by tests only. No real column currently exceeds the cap, so it has never fired against live data.

## Risk assessment

- **The enum tables have no foreign keys and the legacy system still writes to them.** Every column in the map can reacquire a bad value tomorrow. That is why this is a nightly fix rather than a migration, but it also means a clean report is a statement about last night, not a guarantee.
- **`clear: true` destroys data.** On `system_users.title` that was judged acceptable because the field gates nothing and the values were unusable. The flag is per column and opt in for exactly that reason. Adding it to a column that gates authorization, money or reporting would be a serious mistake, and nothing in the code stops somebody doing it.
- **`race` writes are now stricter than they were.** A caller passing an unrecognised race previously stored it; it now throws `InvalidArgumentException`. `SystemUserRaceTest` pins this, but any legacy import path that writes `race` outside the model would bypass the accessor entirely and is untested.
- **The trim pass bypasses Eloquent deliberately.** It does not stamp `modified` and emits no audit rows, so a trim is invisible in the audit log by design. If an auditor later asks who changed a value, the answer is in the application log under `system_fix.legacy_values.trimmed`, not in `audits`.
- **PAD SPACE collation nearly made this ticket wrong twice.** `col <> TRIM(col)` matches nothing and `GROUP BY col` collapses values that differ only by trailing space, which produced a 9,794 row estimate against a real figure of 55. The queries use `LENGTH()` and `CAST(col AS BINARY)` for this reason, and anybody editing them needs to know why.
- **The Slack webhook situation is unresolved and sits outside this ticket.** `LOG_SLACK_WEBHOOK_URL` and `SLACK_ALERT_WEBHOOK` share a URL and fire on every `error` level log, and it is still unconfirmed whether the webhook ending `BPkQkPLNtY` is the operator's private channel or a public one. Until that is answered, the alerting path should be treated as possibly public.

## Decisions

- **Leniency was not made blanket policy.** Only `race` reads leniently. For enums that gate authorization or money, a crash is preferable to a silently wrong value, so the general treatment reports rather than coerces.
- **Trimming and validity were separated into independent passes.** They answer different questions and have different risk profiles: whitespace has exactly one correct resolution, an unrecognised value has none the machine can pick.
- **An invalid `title` is cleared instead of raised.** Asking an admin to open 319 members to blank a field they cannot verify is busywork on a field that gates nothing. Every other enum still stops and asks.
- **Rover crews are excluded from the home location fix.** A Rover's home is their crew while their scouting role sits at an ordinary group. That is their normal state, not a defect. This took the fix from 179 findings to 76. A group running a crew alongside a troop is an ordinary group and is still flagged.
- **`group_events.eventFor` and `eventFor2` were deliberately left out** of the enum map. There the enum is the wrong artefact and the data is right, and alerting on 93% of a table gives an admin nothing to act on. Written up as ticket `003`.
- **Zero dates were found during this work and deliberately not fixed here.** They are a silent wrong value rather than a crash, they need a product decision, and they span 28 columns. Written up as ticket `002`.
- **Two defects in this ticket's own work were found in review and fixed before completion**, not deferred: the findings read path was writing a log line per record (76 log lines per page view), and the per column cap truncated silently. Both are described in the build record below.
- **There is no duplicated navigation entry, and the claim that there was one was wrong.** It was filed as ticket `004` and the ticket has been deleted. `ManageDataFixesSettings` sets `$cluster = SettingsCluster::class`, and `Filament\Pages\Page::registerNavigationItems()` returns early for any clustered page, so it never registers a sidebar item. The "System" group holds two entries, Settings and Data Fixes, and the settings page sits one level down inside Settings alongside "Feature Flags" and "Form Settings", which is where a settings page belongs. **The "Known rough edge" paragraph in the preserved body below is superseded by this line.**
- **Priority.** Actioned at p2. An argument exists for p1, since for the 55 affected members every surface that read them was down. It sits at p2 because the blast radius was a known small set of members and the rest of the system was unaffected.

## Original ticket

The text below is the ticket as it stood before completion, including the build record, the corrections made during the work, and the mutation grids. Preserved verbatim.

---

# 001 — A legacy race value with trailing whitespace fatals every surface that reads a user

**Status:** done (generalised; run against sd-core, 3,640 rows trimmed)
**Reported:** 2026-08-19, from user #19476 (Sebenzile Nkosi)
**Size:** S

## Symptom

Opening a user whose stored race is `African ` throws before anything renders:

```
ValueError: "African " is not a valid backing value for enum App\Enums\UserRace
```

Reproduced against `system_users` #19476:

```
php artisan tinker --execute "App\Models\SystemUser::find(19476)->race"
# ValueError: "African " is not a valid backing value for enum App\Enums\UserRace
```

## Root cause

`SystemUser::casts()` maps `race` to the backed enum `App\Enums\UserRace` (`app/Models/SystemUser.php:78`).
`UserRace::African` is backed by `'African'` (`app/Enums/UserRace.php:12`). The legacy sd-core rows store
`'African '` with one trailing space, so Eloquent's enum cast calls `UserRace::from()` on a value that has no
case and throws. The throw happens at cast time, so it precedes every defensive guard downstream: the
`$state instanceof UserRace` check in `UserInfolist.php:98` never runs.

## Blast radius

Measured against the current sd-core database (65,433 rows), grouped **byte-exactly**
(`GROUP BY CAST(race AS BINARY)`):

| Stored value | Hex | Rows | Casts? |
| --- | --- | --- | --- |
| `NULL` | — | 38,464 | ok |
| `Caucasian` | `43617563617369616E` | 12,317 | ok |
| `African` | `4166726963616E` | 9,739 | ok |
| `Coloured` | `436F6C6F75726564` | 2,514 | ok |
| `Indian` | `496E6469616E` | 1,262 | ok |
| `Other` | `4F74686572` | 864 | ok |
| `Asian` | `417369616E` | 218 | ok |
| **`African `** | `4166726963616E20` | **55** | **throws** |

> **⚠ Corrected during pre-flight.** The first measurement of this table reported 9,794 broken rows and no
> clean `African` bucket at all. That figure was an artefact: `system_users.race` is
> `utf8mb4_unicode_ci`, a **PAD SPACE** collation, so a plain `GROUP BY race` treats `'African'` and
> `'African '` as one value, sums them, and returns whichever it met first as the label. The real split is
> 9,739 clean and 55 dirty. Any predicate over this column that must distinguish trailing whitespace has to
> avoid collation-sensitive comparison — hence `LENGTH(race) <> LENGTH(TRIM(race))` and
> `CAST(TRIM(race) AS BINARY) = ?` in the fix below, rather than the natural `race <> TRIM(race)`, which
> matches **nothing** under this collation.

**55 users cannot be viewed or edited**, on any surface that reads the attribute:

- `app/Filament/Admin/Resources/Users/Schemas/UserInfolist.php:98` — admin view page
- `app/Filament/Admin/Resources/Users/Schemas/UserForm.php:89` — admin create/edit form
- `app/Filament/Admin/Resources/Users/Tables/UsersTable.php:138` — admin list, once the Race column is toggled on (hidden by default, which is why this surfaced through the view page)
- `app/Filament/Member/Resources/Profile/Pages/EditProfile.php:71` — the member's **own** profile page, so those 55 members cannot open their own profile at all
- `app/Filament/Member/Resources/Profile/Schemas/ProfileInfolist.php:92`

## The class, enumerated

`SystemUser` carries four backed-enum casts. All four were audited byte-exactly against the live column
values, not just the reported one:

| Column | Enum | Distinct stored values | Verdict |
| --- | --- | --- | --- |
| `sex` | `UserSex` | `Male`, `Female`, `''`, `NULL` | clean (`UserSex::Other` is backed by `''` — the same class of legacy dirt, already absorbed as a case) |
| `race` | `UserRace` | see table above | **1 bad value, 55 rows** |
| `branch` | `UserBranchTypes` | `Land`, `Air`, `Sea`, `Ranger`, `Guide`, `NULL` | clean |
| `proficiencyInEnglish` | `UserEnglishProficiency` | `0`–`5`, `NULL` | clean |

So this is one value on one column, not a systemic cast problem. No other model casts `UserRace`.

## Decision

Two halves, because either alone leaves a hole:

1. **Tolerant read.** Normalise whitespace before resolving the enum, so no page can ever fatal on a legacy
   race value again. sd-core is shared with the legacy Scouts Digital app, which is free to write
   `'African '` back at any time; a data-only fix would 500 again the moment it does.
2. **Nightly data fix.** Trim the stored column through a `SystemFix` so the data converges on the canonical
   value and legacy reports stop bucketing `African` and `African ` separately.

Writes stay strict: Ssalute must normalise what it reads but must never persist a value outside the enum.

## Work

1. `UserRace::fromLegacyValue(?string $value): ?self` — trim, treat empty as `null`, `tryFrom` the rest,
   return `null` for anything unresolvable. The normalisation rule lives with the enum, not scattered.
2. Replace the `'race' => UserRace::class` cast on `SystemUser` with an `Attribute` accessor/mutator that
   reads through `fromLegacyValue()` and writes the canonical backing value. `Attribute` is already the
   established pattern on this model. The mutator throws on a non-empty value that does not resolve, so the
   strictness the enum cast gave the write path is preserved.
3. `App\Services\SystemFixes\EnsureUserRaceValuesAreCanonical` — trims `system_users.race` for rows where the stored
   value differs from its trimmed form, via the query builder so it does not stamp `modified` or emit an
   audit row across the affected historical records. Flags any trimmed value that still is not a `UserRace` case as
   an attention line rather than changing it. Registered in `RunSystemFixes::$fixes`, with the two
   `DataFixesSettings` toggles, settings migration, Filament tab and `SdCoreTestCase` seed.

## Acceptance criteria

Each criterion names the mutation it reds.

1. `a_user_whose_stored_race_carries_trailing_whitespace_resolves_to_the_enum_case` — a user seeded with the
   raw value `'African '` returns `UserRace::African` from `$user->race`.
   *Reds under:* deleting the `trim()` in `fromLegacyValue()` (restores the `ValueError`).
2. `an_unrecognised_stored_race_reads_as_null_instead_of_throwing` — a user seeded with `'Martian'` returns
   `null`, and reading it does not throw.
   *Reds under:* swapping `tryFrom()` back to `from()`.
3. `a_stored_race_that_is_only_whitespace_reads_as_null` — `'   '` reads as `null`, not as an attempted
   lookup of `''`.
   *Reds under:* dropping the empty-after-trim branch (`UserRace::tryFrom('')` returns `null` today, so this
   pins the intent rather than a crash — see note below).
4. `saving_a_race_through_the_model_persists_the_canonical_backing_value` — assigning `UserRace::African`
   and assigning the string `'African '` both store exactly `'African'` in the column.
   *Reds under:* returning the raw value from the mutator instead of the normalised one.
5. `saving_an_unrecognised_race_through_the_model_is_rejected` — assigning `'Martian'` throws
   `InvalidArgumentException` and writes nothing.
   *Reds under:* making the mutator fall back to `null` on an unresolvable value (silent data loss).
6. `the_admin_user_page_renders_for_a_member_whose_race_carries_trailing_whitespace` — the Filament view page
   for such a user returns 200 and shows `African`.
   *Reds under:* reverting `SystemUser` to the plain enum cast.
7. `the_member_profile_page_loads_for_a_member_whose_race_carries_trailing_whitespace` — `EditProfile` mounts
   and its `race` field is hydrated with `African`. This is the second surface, and it is the one the ticket
   was **not** reported from, so it gets its own criterion rather than "criterion 6 repeated".
   *Reds under:* the same revert; pinned separately because `EditProfile` hydrates through an explicit
   `form->fill()` rather than through the resource, so a fix that only satisfied the resource path would pass 6.
8. `the_fix_trims_stored_race_values_that_carry_whitespace` — two users seeded `'African '` and `'Coloured '`
   are both trimmed; the change lines name both.
   *Reds under:* a `whereRaw` predicate that matches nothing, or an update that writes the untrimmed value.
9. `the_fix_is_a_no_op_when_every_stored_race_is_already_clean` — with only canonical values seeded, the
   result carries no changes and no attentions, and `shouldNotify()` is false (idempotence on re-run).
   *Reds under:* updating every row unconditionally instead of only the rows that differ.
10. `the_fix_flags_a_value_that_is_not_a_race_even_after_trimming` — a user seeded `'Martian '` is left
    untouched and raised as an attention line. Trimming it would report it as fixed while it still does not
    resolve to a case, which is the one outcome that hides the problem instead of surfacing it.
    *Reds under:* folding unresolvable values into the trim update.
11. `the_fix_does_not_stamp_modified_or_write_an_audit_row` — the `modified` timestamp and audit row count
    for a trimmed user are unchanged after the run.
    *Reds under:* doing the update through Eloquent `save()` instead of the query builder. This is the
    complement axis (pre-flight 17): criteria 8–10 are all about *which rows change*; this one is about
    *what else the write records*.
12. `the_fix_is_skipped_when_its_toggle_is_off`, plus the three notification-suppression paths (global
    toggle off, per-fix toggle off, no webhook), matching `RunSystemFixesTest`'s existing shape.

**Regression:** `tests/Feature/Console/RunSystemFixesTest.php` and the existing admin-user and member-profile
Filament suites stay green **unedited**. Mutating `SystemUser::race()`'s accessor must red the new
`SystemUser` cast tests — the existing suites cannot observe it, because no fixture in them seeds a race
value at all, so they are named as a blast-radius check, not as the guard.

## Out of scope

- Backfilling the 38,464 `NULL` races. That is missing data, not dirty data.
- Any change to `UserSex`, `UserBranchTypes` or `UserEnglishProficiency`, all audited clean above.
- A one-off migration to trim the column. The nightly fix does the same work idempotently and also handles
  legacy writing the value back, which a migration cannot.

---

## Build record — 2026-08-19

**Shipped**

| File | What |
| --- | --- |
| `app/Enums/UserRace.php` | `fromLegacyValue()` — trim, empty to null, `tryFrom` the rest |
| `app/Models/SystemUser.php` | `race` moved off the plain enum cast onto an `Attribute` (lenient read, strict write) |
| `app/Services/SystemFixes/EnsureUserRaceValuesAreCanonical.php` | the nightly fix |
| `app/Console/Commands/RunSystemFixes.php` | registration |
| `app/Settings/DataFixesSettings.php` + `database/settings/2026_08_19_120000_…` | the two toggles, both defaulting on |
| `app/Filament/Admin/Clusters/Settings/Pages/ManageDataFixesSettings.php` | the "Race Values" tab |
| `tests/Support/SdCoreTestCase.php` | settings seed |
| `tests/Feature/Models/SystemUserRaceTest.php` | 9 tests, criteria 1–5 |
| `tests/Feature/Console/EnsureUserRaceValuesAreCanonicalTest.php` | 10 tests, criteria 8–12 |
| `tests/Feature/Filament/UsersResourceTest.php`, `ProfileTest.php` | criteria 6–7, added alongside the existing tests; no existing assertion was edited |

**Result:** full suite 417 passed, 3 skipped, 1,000 assertions. Against the live sd-core database, #19476
reads `UserRace::African`, and a cursor over all 65,433 rows throws on **zero** of them.

## Mutation grid

| # | Mutation | Reds |
| --- | --- | --- |
| M1 | drop `trim()` in `fromLegacyValue()` | 5 |
| M2 | `tryFrom()` → `from()` | 2 |
| M3 | mutator returns the raw value | 1 |
| M4 | mutator returns `null` instead of throwing | 1 |
| M5 | whitespace predicate written as `race <> TRIM(race)` | 6 |
| M6 | auto-fix compares case-insensitively (no `CAST … AS BINARY`) | 1 |
| M7 | unresolvable values folded into the trim | 3 |
| M8 | the update stamps `modified` | 1 |
| M9 | the update goes through Eloquent (stamps `modified` and audits) | 1 |

**Two of these were green on the first pass, and both were test defects rather than passes:**

- **M6** — `it_flags_a_case_variant…` seeded `'african'`, which carries no whitespace and so is never a
  candidate for the trim in the first place. It passed byte-exact comparison or not, and witnessed nothing.
  Re-seeded as `'african '`, where only the `CAST … AS BINARY` keeps it out of the auto-fixed set.
- **M8** — `it_does_not_stamp_modified…` captured `modified` before the run, but the factory stamps it at
  `now()` and the fix runs in the same second, so a re-stamp was indistinguishable from no stamp. The row's
  `modified` is now anchored to `2020-01-01` before the run.

Both are the pre-flight 16 shape: a mutation pass can only test the implementation against fixtures the suite
actually constructs, and neither suite constructed the value that would have shown the difference.

## Deployment note

`php artisan migrate` is owed — `2026_08_19_120000_add_ensure_user_race_values_are_canonical_settings` is
**Pending**, so the two toggles do not exist yet and the fix will be skipped until it runs. The read-side
fix needs no migration and is already live.

The 55 dirty rows are still dirty: the fix has not been run against sd-core, only against the test database.
Pages render correctly regardless, because the read no longer depends on the stored value being clean.

---

## Follow-up — 2026-08-19: the fix was generalised

`race` turned out not to be special. Auditing the rest of the strict-cast surface produced three
results, and the fix was reshaped around them.

**Enums: nothing to retrofit.** Only **3** enum-cast columns exist across every model —
`system_users.sex`, `.branch`, `.proficiencyInEnglish` — and all three are clean byte-exactly. There
is no second `race`. Note also that blanket read-leniency is *not* adopted as a policy: `race` earned
it because it is display-only, `null` is already its dominant state (38,464 rows), and the
alternative was a 500. An enum gating authorization or money should keep throwing, because a loud
failure beats a quiet wrong answer.

**Whitespace: much wider than `race`.** ~3,640 rows across seven columns:

| Column | Rows | Where |
| --- | --- | --- |
| `system_users.otherName` | 1,896 | all leading |
| `system_users.SSANumber` | 865 | all trailing |
| `system_users.first_name` | 817 | 814 leading, 3 trailing |
| `system_users.race` | 55 | trailing |
| `groups.gpsLon` / `gpsLat` / `branchCode` | 6 | mixed |
| `group_programs.title` | 1 | — |

Samples: `" Kayden"`, `" Liam Roger"`, `"140396 "`. A leading space sorts a member to the top of every
alphabetical list; a trailing space survives MySQL `=` under PAD SPACE but breaks PHP's `===`.

**Dates: a separate finding**, written up as `002` — 28 columns / ~36,000 rows of `0000-00-00`,
which do not throw but cast silently to `-0001-11-30`.

### What changed

`EnsureUserRaceValuesAreCanonical` became **`EnsureLegacyValuesAreCanonical`**, one fix under one
pair of toggles, running **two independent passes**:

1. **TRIM** — surrounding whitespace stripped from every listed column, unconditionally and
   automatically. It needs to know nothing about what the column means.
2. **VALIDATE** — every enum-backed column is then checked against its cases; anything that is not
   one of them is logged and raised for an admin, never guessed at.

Separating the passes fixed a design error in the original. The first version refused to trim
`Martian ` on the grounds that trimming would "report it as fixed". That conflated two independent
concerns: trimming `Martian ` is correct whether or not the result is a race, and the validate pass
still reports it. The order matters and is pinned — validate runs *after* trim, so the run never
reports a value it has just repaired (`it_does_not_report_a_race_the_same_run_has_just_trimmed_into_shape`).

Adding a column is now a one-line entry in `TRIM_COLUMNS` or `ENUM_COLUMNS`.

### Renames

| Was | Now |
| --- | --- |
| `EnsureUserRaceValuesAreCanonical` | `EnsureLegacyValuesAreCanonical` |
| `ensure_user_race_values_are_canonical_*` | `ensure_legacy_values_are_canonical_*` |
| settings migration `…_add_ensure_user_race_…` | `…_add_ensure_legacy_values_are_canonical_settings` |
| Filament tab "Race Values" | "Legacy Values" |

The settings migration had never been run, so it was rewritten rather than superseded — no orphaned
settings rows.

### Verification

Suite: **422 passed, 3 skipped, 1,029 assertions**. The fix's own suite is 15 tests / 68 assertions.

| # | Mutation | Reds |
| --- | --- | --- |
| M1 | collation-blind whitespace predicate (`col <> TRIM(col)`) | 6 |
| M2 | trim trailing whitespace only | 7 |
| M3 | drop `race` from the trim list | 4 |
| M4 | drop the `groups` table from the trim list | 1 |
| M5 | enum check compares case-insensitively | 1 |
| M6 | validate before trimming | 2 |
| M7 | the update stamps `modified` | 1 |

M6 is the one worth keeping: it is the only guard on the pass ordering, and without it a build that
reports every value it is about to repair looks identical to a correct one on the happy path.

---

## ⚠ CORRECTION — 2026-08-19: "only 3 enum-cast columns exist" was wrong

The follow-up above claimed the enum surface was 3 columns, all clean. **That was measured with a
scan too narrow to support the claim**, in two independent ways:

1. **The glob was `app_path('Models/*.php')` — not recursive.** `app/Models/Forms/` holds 5 models,
   including `ApplicationAdultMembershipRequest`, which casts `title` and `sex` to enums.
2. **`getCasts()` cannot see an enum resolved through an `Attribute`.** `SystemUser::title()` has
   used `UserTitle::tryFrom()` all along, and `Group::groupTypeID` uses `GroupTypes::tryFrom()`.
   Ironically, moving `race` onto an `Attribute` as part of this very ticket removed it from the
   scan's own results.

Enumerating from **the enums** rather than from the casts gives 11 enums and 11 bound columns:

| Column | Enum | Bound via | Verdict |
| --- | --- | --- | --- |
| `system_users.sex` | `UserSex` | cast | clean |
| `system_users.branch` | `UserBranchTypes` | cast | clean |
| `system_users.proficiencyInEnglish` | `UserEnglishProficiency` | cast | clean |
| `system_users.race` | `UserRace` | Attribute | clean (fixed by this ticket) |
| **`system_users.title`** | `UserTitle` | **Attribute** | **DIRTY — 319 rows, 5 values** |
| `forms_aam_requests.title` | `UserTitle` | cast | clean (0 rows) |
| `forms_aam_requests.sex` | `UserSex` | cast | clean (0 rows) |
| `groups.groupTypeID` | `GroupTypes` | Attribute | clean |
| `group_events.eventAway` | `EventAway` | Filament only | clean |
| **`group_events.eventFor`** | `EventFor` | Filament only | **DIRTY — see `003`** |
| **`group_events.eventFor2`** | `EventForType` | Filament only | **DIRTY, 93% — see `003`** |

`system_users.title` holds `"Not Set"` ×204, `"External Booking"` ×112, `"4"` ×1, `"MS"` ×1,
`"MR"` ×1. No crash — the accessor already used `tryFrom` — but the title reads as blank for 319
members, and `MS`/`MR` are one keystroke from correct. Exactly the "log and notify for an admin"
case, so it is now in `ENUM_COLUMNS`.

The two `eventFor*` columns are deliberately **excluded** and written up as `003`: there the enum is
wrong, not the data, and alerting on 93% of a table gives an admin nothing to act on.

**The lesson is the one this repo keeps relearning: a negative from a search is only as broad as the
search.** "There is no second `race`" was a claim about every model in the app and was checked
against one non-recursive glob of one binding mechanism.

### Final shape

`TRIM_COLUMNS` — 13 columns across 4 tables. `ENUM_COLUMNS` — 9 columns.

A drift guard (`every_string_backed_enum_column_is_also_trimmed`) asserts that any enum column on a
**text** column is also trimmed, so whitespace can never surface as an "unrecognised value" an admin
cannot act on. It caught `sex` and `branch` missing from the trim list the first time it ran.

Two SQL subtleties, both found by tests rather than by reading:

- **The comparison is done in the enum's domain; the blank check in the column's.** They are
  different discriminators on purpose. `GroupTypes` is string-backed over an int column, so keying
  both off the enum, or both off the column, is wrong in one direction or the other.
- **`GroupTypes::UNKNOWN = 'unknown'` coerces to `0` when MySQL compares it against an int column**,
  which silently makes a stored `0` look like a valid group type. Comparing through
  `CAST(col AS BINARY)` avoids it. Pinned by
  `it_reports_a_zero_on_an_int_backed_enum_that_has_no_zero_case`.

### Verification

Suite: **426 passed, 3 skipped, 1,050 assertions**. The fix's own suite is 19 tests / 89 assertions.
All 12 mutations red (M1–M7 above, plus):

| # | Mutation | Reds |
| --- | --- | --- |
| M8 | compare int columns raw (the `'unknown'`→0 coercion) | 2 |
| M9 | blank-check every column (int coercion hides a bad zero) | 1 |
| M10 | drop `system_users.title` from `ENUM_COLUMNS` | 1 |
| M11 | drop `groups.groupTypeID` from `ENUM_COLUMNS` | 2 |
| M12 | drop `sex`/`branch` from the trim list (the drift guard) | 1 |

### Ran against sd-core

At **19:24:54** on 2026-08-19 the command was run in `local` against `scouterg_2026_07_17` and
trimmed **3,640 rows** across 8 columns — `first_name` 817, `otherName` 1,896, `SSANumber` 865,
`race` 55, `groups.gpsLat` 1, `gpsLon` 4, `branchCode` 1, `group_programs.title` 1. Re-runs at
19:26:14 and 19:27:10 changed nothing, confirming idempotence, and `modified` was not stamped on any
row. #19476 now stores `African`. The settings migration has been applied (batch 18).

---

## Delivered shape — 2026-08-20

The sections above describe the fix as a console command that reported into Slack. Everything below
is what the ticket actually shipped as, after the notification turned out to be the wrong surface.

### Why the shape changed

The first working version dumped every flagged record into the Slack body. At 179 members that is a
wall of text an admin cannot act on, and the operator's instruction was explicit: *"We don't need to
try and surface everything in slack, we just want to ping that there's something to be done, and
send a link where they could action that change."*

That splits one responsibility into two. A fix must be able to say **what it found** without
changing anything, so the same list can be rendered on a page, counted for an alert, or written into
a run's report. That is the `ReportsFindings` contract.

### The contract

`App\Services\SystemFixes\ReportsFindings` adds two methods to a fix:

```php
public function findings(): Collection;   // Collection<int, SystemFixFinding>
public function findingsUrl(): ?string;   // where those findings can be actioned
```

`SystemFixFinding` is record-shaped, not summary-shaped, because an admin cannot act on "204 rows",
only on a member they can open: `title`, `detail`, `url`, `linkLabel`, `group`, `recordId`, `badge`.

Three rules hold the contract together:

1. **`findings()` must not write.** The page calls it on every load.
2. **That includes logging** (see the defect below).
3. **`run()` may call `findings()`; `findings()` must never call `run()`.**

All four registered fixes now implement it: `EnsureLegacyValuesAreCanonical`,
`FlagUsersWithoutRoleInHomeLocation`, `EnsureEachUserHasOnlyOnePrimaryRole`,
`EnsureYouthMemberIdsAreInSync`.

### ⚠ Defect found in review, fixed 2026-08-20: the read path was logging

Three of the four fixes emitted a structured `Log::warning` **per record** inside the method that
built their findings. That was correct when only the nightly command called it. Once the Filament
page called the same method, **opening Home Location Roles wrote 76 warning lines to the log, on
every page view**, and the log filled with a nightly-run signal that no longer meant a nightly run.

The lines were redundant as well as noisy: `RunSystemFixes` already logs every attention line under
`system_fix.completed`. All three were removed, and the reason is written into the interface
docblock so the next fix does not reintroduce it. The only `Log::` calls left in these four classes
are in genuine write paths (`run()`, `setHome()`, `reconcileUser()`).

### ⚠ Second defect: the per-column cap truncated silently

`RECORDS_PER_COLUMN = 500` bounded how many records one column contributed, with nothing to say the
list had been cut. Both the page and the Slack count would have understated the problem and looked
complete. The cap still applies, but an overflow is now counted and stated as its own finding
("*N* more not listed"). Landing exactly on the cap is a complete list, not a truncated one, which
is a boundary the first implementation got wrong and a test caught.

### The Data Fixes cluster

`app/Filament/Admin/Clusters/DataFixes/`, one page per fix, each backed directly by that fix's
`findings()`. An admin sees what is true when they open the page, not whatever the last nightly run
stored, so a finding somebody has already fixed disappears on refresh.

| Page | Fix | Live count |
| --- | --- | --- |
| Legacy Values | `EnsureLegacyValuesAreCanonical` | 0 |
| Home Location Roles | `FlagUsersWithoutRoleInHomeLocation` | 76 |
| Primary Roles | `EnsureEachUserHasOnlyOnePrimaryRole` | 0 |
| Youth Member Ids | `EnsureYouthMemberIdsAreInSync` | 7 |

`FindingsPage` is the shared base (full width, collection-backed `Table::records()`). A page may
declare a `solveAction()`, and when it does, **the whole row is that action**; when it does not, the
row is inert and the finding's own link is the way out.

Home Location Roles declares one. Most of these are a single member holding a single role at a
single place that is not their home, so the page offers a `Radio` of the member's own role locations
and writes the chosen one. The member's roles are not touched. The row then vanishes on refresh,
because the finding is recomputed rather than stored.

### Slack, after

Per fix, when there is something to say:

```
Fixed automatically: 3 changes.
7 items outstanding.
<https://…/admin/data-fixes/youth-member-ids|Review and fix →>
```

### Two behaviour decisions taken during the build

**Rover crews are not flagged.** A Rover's home is their crew while their scouting role sits at an
ordinary group. That mismatch is their normal state, not a defect, so a home group that runs rovers
**and no other section** is excluded. This took the fix from 179 findings to 76. A group that runs a
crew alongside a troop is an ordinary group and is still flagged, which is the boundary.

**An invalid `title` is cleared rather than raised.** `title` gates nothing: no authorization, no
money, no reporting. Asking an admin to open 319 members to blank a field they cannot verify is
busywork, so `ENUM_COLUMNS` entries may carry `clear: true`, which nulls an unrecognised value (or
empties it, on a NOT NULL column) as part of the automatic pass. This is deliberately opt-in per
column. Every other enum here still stops and asks, because a wrong `sex`, `branch` or `groupTypeID`
is a wrong answer somebody will act on. `system_users.title` is the only column carrying the flag,
and it now reports 0 unrecognised values.

### Mutation grid — the review pass

| # | Mutation | Reds |
| --- | --- | --- |
| M13 | drop the overflow finding entirely | 1 |
| M14 | drop the exact-cap guard (emits "0 more not listed") | 1 |
| M15 | report the total instead of the remainder | 1 |
| M16 | reintroduce a log line in `EnsureLegacyValuesAreCanonical`'s read path | 1 |
| M17 | reintroduce a log line in `FlagUsersWithoutRoleInHomeLocation`'s read path | 1 |
| M18 | reintroduce a log line in `EnsureYouthMemberIdsAreInSync`'s read path | 1 |

M17 came back **green on its first run**, and the reason is worth recording: the mutation's anchor
string did not match, so nothing was edited. **A mutation that fails to apply is indistinguishable
from a mutation that survives.** The anchor is asserted before the run now.

M17 was also genuinely green before this pass, on a real mutation: only
`EnsureLegacyValuesAreCanonical` had a read-path log guard, so the other three could have reacquired
one silently. Each now carries `listing_findings_writes_nothing_to_the_log`, and each asserts the
fixture produced at least one finding first, because the guard proves nothing against an empty list.

### Verification

Full suite: **453 passed, 3 skipped, 1,108 assertions**, 0 failures.

- `tests/Feature/Console/EnsureLegacyValuesAreCanonicalTest.php` — 25 tests
- `tests/Feature/Console/FlagUsersWithoutRoleInHomeLocationTest.php` — 16 tests
- `tests/Feature/Console/EnsureYouthMemberIdsAreInSyncTest.php` — 9 tests
- `tests/Feature/Filament/DataFixesClusterTest.php` — 15 tests
- `tests/Feature/Models/SystemUserRaceTest.php` — 9 tests

### Known rough edge

`ManageDataFixesSettings` (the toggles) and `DataFixesCluster` (the findings) both appear in the
admin nav as "Data Fixes". Moving the settings page into the cluster is the obvious tidy-up and has
not been done.

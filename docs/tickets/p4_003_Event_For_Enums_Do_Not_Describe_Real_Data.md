# 003. The Event "For" enums describe almost none of the real event data

**Found:** 2026-08-19, auditing every enum-backed column for `001`
**Updated:** 2026-08-20, after reading the legacy source (see "What the values actually mean")

## Finding

`group_events` has three columns driven by enums in the admin event form. Two of them hold values
the enum has never heard of, and one of those is wrong for **93% of the table**.

| Column | Enum | Enum covers | Stored values not covered | Rows |
| --- | --- | --- | --- | --- |
| `eventFor` | `EventFor` | 0–6 | 7, 8, 9, 10, 11, 12, 13, 14, 15, 17, 18, 24 | 424 |
| `eventFor2` | `EventForType` | 1, 2 | 15, 16, 17, 18 | **7,157 of 7,660** |
| `eventAway` | `EventAway` | 0, 1, 2 | none | clean |

`EventForType` declares exactly two cases (`Groups = 1`, `AdultLeaders = 2`). The live data is
17 (×4,163), 16 (×2,572), 15 (×307) and 18 (×115). **503 of 7,660 rows match the enum.**

## Why this is not a data problem

This is the opposite of `001`. There, 55 rows were wrong and the enum was right. Here the enums are
the incomplete artefact and the data is what the legacy system actually writes, so they must **not**
be added to `EnsureLegacyValuesAreCanonical`'s `ENUM_COLUMNS`. Doing so would raise 7,157 rows for
"an admin to correct", and no admin can correct them: the correction belongs in the model, and
nobody can act on an alert that fires on 93% of a table.

`eventAway` **is** clean and **is** in the check.

## What the values actually mean

The meaning of these values was established from the legacy app's own behaviour, which answers the
question outright and closes the step 1 that an earlier revision of this ticket left open.

### `eventFor2` is a `system_user_types.id`, not a two-case type

The legacy event management screen renders this column through its role-name lookup, which resolves
the value against `system_user_types.id`. The four "unknown" values are the four youth section
roles:

| Value | `system_user_types.name` |
| --- | --- |
| 15 | Meerkat |
| 16 | Cub |
| 17 | Scout |
| 18 | Rover |

The legacy event-creation path sets them from the audience picker: Meerkat Dens → 15, Cub Packs →
16, Scout Troops → 17, Rover Crews → 18, and anything adult falls through to a preset of `2`.

**1 and 2 are not role ids in this column.** They are an ad-hoc "group adults" / "district adults"
flag, and the legacy dashboard's events-to-attend listing consumes them that way. Resolving them
through the role-name lookup instead yields "Scouts.Digital System Administrator" and "Regional
Commissioner", which is nonsense on screen. So the column is genuinely two domains in one integer, and the current
`EventForType` names only the broken half.

Also note that the legacy creation path maps *every* adult audience (`eventForID > 4`) to
`eventFor2 = 18` (Rover) before its later branches overwrite it. That looks like a legacy bug, not a meaning.

### `eventFor` is two domains depending on which page wrote the row

The legacy audience picker offers:

| Value | Label |
| --- | --- |
| 6 / 1 / 2 / 3 | Meerkat Dens / Cub Packs / Scout Troops / Rover Crews |
| 5 | Group Adult Leaders / Parents Committee |
| 7 | District Adult Leaders Only |
| 8 | All Group + All District Adult Leaders |
| 9 | Regional Adult Leaders Only |
| 10 | All District + All Regional |
| 11 | All Group + All District + All Regional |
| 12 | National Adult Leaders Only |
| 13 | All Regional + All National |
| 14 | All District + All Regional + All National |
| 15 | All Group + All District + All Regional + All National |

But the legacy group-attending path writes `eventFor = eventTypeID` — a
`system_group_event_types.id` — when a group signs itself up to a parent event. That is where the
values outside the picker come from: 24 = "Den Event" (46 rows, all with `eventFor2 = 15` Meerkat),
18 = "Chief Commissioners Council", 17 = "Pack Good Turn Project". It also accounts for chunks that
*look* in-range: `eventFor = 9 / eventFor2 = 17 / eventTypeID = 9` (Troop Event, 46 rows) and
`eventFor = 8 / eventFor2 = 16 / eventTypeID = 8` (Pack Event, 148 rows) are the same path, not the
audience domain. On that path `eventFor == eventTypeID`, which is the only discriminator available,
and it is not reliable where the two id spaces collide (e.g. `eventFor = 5`).

The current `EventFor` enum is wrong about the values it *does* cover, too: `Group = 5` is legacy's
"Group Adult Leaders / Parents Committee", and `All = 0` / `AdultsOnly = 4` appear in no legacy
picker at all (3 and 76 rows respectively, all pre-2019).

## Not currently a live defect, but one page away from being one

`EventForm` renders these as `Select::make('eventFor2')->options(EventForType::options())`. A stored
17 matches no option, so the field would render empty and a save would write the empty value over
it. **`EventResource::getPages()` currently registers only `index` and `view`**. There is no edit
page, so nothing can trigger this today. It becomes a silent data-loss bug the moment an edit page
is added, which is exactly the kind of change nobody would think to check this against.

Legacy has the same class of bug: its event edit path re-derives `eventFor2` from `eventTypeID` on
every save, so editing an event through legacy can rewrite the audience.

## Work

1. Replace `EventForType` with a relationship to `system_user_types` for the 15–18 case, and decide
   explicitly how to represent the 1/2 "group adults / district adults" case, which is not a role.
   A single int column carrying two domains cannot be one enum.
2. Split `EventFor` the same way: the audience picker values above are a real fixed set and belong
   in an enum with the legacy labels; the `system_group_event_types.id` values written by the
   group-attending path are a lookup, not enum cases. Fix `Group = 5`'s label while there.
3. Decide whether to normalise the stored data or model both domains. Normalising needs a rule for
   the colliding ranges, and the `eventFor == eventTypeID` heuristic is not one.
4. Only once the model is correct, add `group_events.eventFor` and `.eventFor2` to `ENUM_COLUMNS`
   so the check guards them from then on.
5. Add a regression test asserting the event form's options cover the values actually stored.

## Related, found in the same sweep

- **`GroupTypes` is string-backed (`'1'`…`'5'`, `'unknown'`) over the integer column
  `groups.groupTypeID`.** The data is clean and it works, because PHP coerces the int on
  `tryFrom()`. Two smells worth a look: `UNKNOWN = 'unknown'` can never be stored in an int column,
  and comparing this enum's cases against the raw column in SQL makes MySQL coerce `'unknown'` to
  `0`, which silently makes a stored `0` look valid. `EnsureLegacyValuesAreCanonical` works around
  the second one by comparing through `CAST(col AS BINARY)`; the enum itself is still mismodelled.
- **`SectionTypes` and `SystemDefinedRoles` are referenced nowhere outside their own files.** Dead
  code; candidates for deletion once someone confirms nothing external reaches for them.

# Accent purple is not the SSA brand purple

**Priority when actioned:** p4

## Synopsis

The app shipped two purples: the accent token and the three Filament panels used `#5C2D91`, while the membership certificate already used the SCOUTS South Africa brand purple `#622599`. Align everything on the brand value.

## Resolution

- `resources/css/app.css`: `--color-accent` and `--color-accent-content` set to `#622599`. The dark mode lift (`#7B4DB8`) is unchanged.
- `AdminPanelProvider`, `MemberPanelProvider`, `HoldingZonePanelProvider`: `'primary' => Color::hex('#622599')` so Filament derives the full shade scale from the brand value instead of using a flat string.
- `resources/views/sso-refused.blade.php`: the hard coded `bg-[#5C2D91]` became `bg-accent`, and the hover uses the skill's `--purple-deep` value `#4A1C73`.
- A tree grep for `5c2d91` (case insensitive, excluding vendor, node_modules, public and storage) returns nothing.

## Verification

- `php artisan test --compact` run after the change (see the 034 and 035 completion records for the suite result on the same day).
- `vendor/bin/duster fix --dirty` run.
- A feature test is not meaningful for a colour token, as the ticket anticipated. Correctness rests on the grep above and on the visual pass recorded under ticket 034, which covered the member login, a BackOffice table and the holding zone in light and dark mode.
- White on `#622599` is WCAG AAA per the World Scouting accessibility tables; no contrast change was expected and none was seen.

## Risk assessment

- Filament now derives primary shades from `Color::hex()` rather than a flat string, so the 50 to 950 scale differs slightly from before. Any view that relied on the exact previous rendering of `primary-50` style classes shifts by a small amount. Nothing in the repo asserts on those values.
- Nothing else is affected: no neutral scale or section colour changed.

## Decisions

- Kept the dark mode accent at `#7B4DB8` as the skill documents it as our own extension.
- The ticket was completed alongside 034 and 035 in one working session so the logo could land on the right purple.

## Original ticket

# Accent purple is not the SSA brand purple

Panel: member, backoffice, holding zone

The app's accent purple is `#5C2D91` in `resources/css/app.css` (light mode `--color-accent` and `--color-accent-content`), in all three Filament panel providers (`'primary' => '#5C2D91'`) and hard coded in `resources/views/sso-refused.blade.php`. The SCOUTS South Africa brand purple is `#622599` (Pantone 527 C, CMYK 79 94 0 0, RGB 98 37 153), per the SSA Brand Manual 2015 section 2.5 and the Marketing Toolkit wiki. The membership certificate view already uses `#622599`, so the app currently ships two purples. The `scouts-sa-brand` skill (`.claude/skills/scouts-sa-brand/SKILL.md`) is the reference.

Filed at p4 because it is hygiene: nothing is broken, but every new surface copies the wrong value and the drift widens.

## Scope

- Set `--color-accent` and `--color-accent-content` to `#622599` in `app.css`. Keep the dark mode lift (`#7B4DB8`) as is; the skill documents it as our extension.
- Set `'primary'` to `#622599` in `AdminPanelProvider`, `MemberPanelProvider` and `HoldingZonePanelProvider`. Use `Filament\Support\Colors\Color::hex('#622599')` so Filament derives the shade scale rather than a flat colour.
- Replace the hard coded `bg-[#5C2D91]` and `hover:bg-[#4a2475]` in `sso-refused.blade.php` with the accent token (`bg-accent`) and a hover that uses the skill's `--purple-deep` value `#4A1C73`.
- Grep the tree for `5C2D91` and `5c2d91` afterwards; nothing should remain.
- Check contrast of white text on the new primary in the Filament buttons and in Flux focus rings. `#622599` with white is WCAG AAA per the World Scouting accessibility tables, so no change is expected, but confirm visually in both themes.

## Out of scope

- Adding the SSA logo or the WOSM membership line. That is ticket 034.
- Any change to the zinc neutral scale or the section coding colours.

## Verification

- `npm run build` and a visual pass over the member login, a BackOffice resource table and the holding zone.
- A feature test is not meaningful for a colour token; say so in the completion record and rest correctness on the grep and the visual pass.

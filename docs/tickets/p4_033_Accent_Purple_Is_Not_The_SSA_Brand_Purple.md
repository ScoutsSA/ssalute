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

# Brand the email views in the SSA corporate CI

Panel: none (mail)
Gate: none. The `<x-ssa.logo>` and `<x-ssa.membership-line>` components and the artwork under `public/images/brand/` landed with ticket 034.

Split out of ticket 034 on 2026-10-08 so the splash, login, panel and certificate work could ship as a reviewable diff. The eight mail views under `resources/views/emails/` are still unbranded: no SSA logo, no membership line, the UI font rather than Verdana, and `aam_applicant_initial` writes "Scouts SA". The `scouts-sa-brand` skill (`.claude/skills/scouts-sa-brand/SKILL.md`) is the reference; the email rules are under "Typefaces" and "Logo, emblem and marks".

Filed at p6 alongside its parent: a clear near term payoff for how the organisation reads in members' inboxes, nobody outside the repo is waiting on a date.

## Scope

- A shared mail layout (or the published Laravel markdown mail theme, if the views move onto markdown mail) with a flat `#622599` header band carrying the white-on-purple logo as the PNG (`ssa-logo-white-on-purple.png`, since mail clients do not reliably render SVG), and a footer with the membership line and the National Office contact block: `info@scouts.org.za`, `www.scouts.org.za`, nothing else.
- Body text in `Verdana, Geneva, Tahoma, sans-serif`, 10 to 11 pt, headings Verdana Bold.
- Every view under `resources/views/emails/` uses the layout: `report_system_issue`, `profile/report_issue`, `directory/contact_via_system`, and the five `forms/aam/*` views.
- Copy says "SCOUTS South Africa" in full. No rope, no textures, no badge logo.
- Sign-off line on official emails uses the membership line.

## Out of scope

- Any change to what the emails say beyond the organisation name, or to who receives them.
- The World Scouting logo.

## Verification

- A feature test per mailable that renders the view and asserts on the logo alt text and the membership line.
- One rendered email checked in a mail client or the Nightwatch mail preview in light and dark mode.

# Adopt the SSA corporate brand on official surfaces

Panel: member, backoffice, holding zone
Gate: the supplied SSA corporate logo artwork (white on purple and purple on white, SVG or high resolution PNG) is in the repo. It comes from the National Office PR files, not from any redraw. Nothing in this ticket may start from a traced or AI generated fleur-de-lis.

Ssalute is a National Office system. The SSA Brand Manual 2015 reserves the corporate identity (clean white background, the SCOUTS South Africa logo, the "Member of the World Organisation of the Scout Movement" line) for the National and Regional offices, which is exactly what this app is, yet it carries no SSA logo at all: the favicon and the `app-logo` components are the app's own icon, the auth layouts show no organisation mark, and the emails are unbranded. The `scouts-sa-brand` skill (`.claude/skills/scouts-sa-brand/SKILL.md`, plus `references/`) holds the rules and the reasoning, including the WOSM licensing position that makes this use free for an NSO.

Filed at p6: a clear near term payoff for how the app reads to members and Regions, but nobody outside the repo is waiting on a date. Depends on ticket 033 landing first so the logo sits on the right purple.

## Scope

- **Assets.** Add the supplied artwork under `public/images/brand/` (`ssa-logo-white-on-purple.svg`, `ssa-logo-purple-on-white.svg`, PNG fallbacks). Never inline the paths by hand in Blade. Keep the app icon for favicons, Apple touch icons and the PWA splash set; the SSA logo is the organisation's signature, not the product icon.
- **A Blade component** `<x-ssa-logo variant="on-purple|on-white" />` that renders the right file with alt text "SCOUTS South Africa", respects the manual's minimum size (do not render below roughly 120 px wide, where "South Africa" stops being legible) and never gets a filter, shadow or recolour.
- **Membership line** component or slot: "Member of the World Organisation of the Scout Movement", Verdana in documents and emails, the UI font in app chrome.
- **Auth surfaces.** The three auth layouts (`components/layouts/auth/card`, `simple`, `split`), the member login blurb and the Scouts Digital login view show the SSA logo above the app name, with the membership line in the footer. The purple area behind the white logo must be `#622599`.
- **Filament panels.** Use `->brandLogo()` and `->darkModeBrandLogo()` on all three panels with a view that renders the SSA logo lockup next to the panel name, sized to `->brandLogoHeight('2.25rem')` or thereabouts. The BackOffice panel keeps its super user styling otherwise.
- **Emails.** Every mail view under `resources/views/emails/` gets a purple header band with the white logo and a footer carrying the membership line, the National Office contact details (`info@scouts.org.za`, `www.scouts.org.za`) and nothing else. Body text in Verdana per the manual. If the emails move onto Laravel's markdown mail, publish the vendor theme and do it once there instead.
- **Generated documents.** The membership certificate view already uses the brand purple; add the logo and membership line there too, following the manual's certificate examples (logo in the purple area, "Member of the World Organisation of the Scout Movement" as the standard footer line).
- **Copy.** Where the app names the organisation it says "SCOUTS South Africa" in full. The skill's naming rules apply.

## Out of scope, decided deliberately

- The World Scouting logo and the bare World Scout Emblem. Showing WOSM membership with the 2024 World Scouting logo is within SSA's NSO permissions, but WOSM has not published how a national logo sits beside it, so it is a ManCo brand decision and gets its own ticket if taken.
- The promotional CI (hessian textures, badge logo, AG Stencil). Print only and not for an administrative system.
- Any change to the section coding colours or to the neutral palette.

## Verification

- Feature tests that the auth layouts and each mail view render the logo component and the membership line (assert on the alt text and the line, not on markup).
- Visual pass in light and dark mode on the member login, a BackOffice page, the holding zone and one rendered email.
- Confirm no file under `public/images/brand/` differs from the supplied artwork (byte compare against the originals kept outside the repo).

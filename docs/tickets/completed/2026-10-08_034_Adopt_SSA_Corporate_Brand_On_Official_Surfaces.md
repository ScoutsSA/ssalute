# Adopt the SSA corporate brand on official surfaces

**Priority when actioned:** p6

## Synopsis

Ssalute is a National Office system and carried no SCOUTS South Africa logo at all. Put the supplied corporate logo, the WOSM membership line and the full organisation name on the official surfaces: the splash page, the login and auth screens, and the three Filament panels. Emails were split out (see Decisions).

## Resolution

- **Artwork.** The National Office's web derivatives are in `public/images/brand/` (logo in the four colourways as SVG and PNG, the five rope variants as SVG, PNG and cropped PDF). They are copies of `~/Documents/scouts-brand-sources/web/`, not redraws.
- **Components.** `<x-ssa.logo variant="on-purple|on-white">` (`resources/views/components/ssa/logo.blade.php`) renders the supplied SVG with alt text "SCOUTS South Africa", `draggable="false"` and a `min-w-[120px]` floor so "South Africa" stays legible. `<x-ssa.membership-line>` renders the WOSM line and takes attributes.
- **Filament panels.** All three providers set `brandName`, `brandLogo` (the shared view `filament/shared/brand-logo.blade.php`, logo lockup plus the panel name) at `brandLogoHeight('2.5rem')`, which puts the logo at about 127 px wide, above the floor. A `PanelsRenderHook::FOOTER` hook renders `filament/shared/footer.blade.php` with the membership line on every panel page, including the login page. The admin theme gained `@source` lines for the shared views and the `ssa` components so Tailwind compiles their classes.
- **Login.** The holding zone login heading is now "Sign in to Ssalute" because the logo above it already says SCOUTS South Africa.
- **Auth layouts.** `card`, `simple` and `split` show the logo above the app name and the membership line below. The hard coded `class="dark"` on their `<html>` elements was removed so they follow the user's Flux appearance like the rest of the app.
- **Splash page.** `welcome.blade.php` rebuilt in the corporate CI with a modern layout (option A of the mockup John picked on 2026-10-08): flat `#622599` band with the white-on-purple logo top left, the Ssalute mark and wordmark, white headline and white primary button; white body with the two cards and the open source note; footer with the membership line. Dark mode keeps the band on the brand purple and drops the body to near-black with the lifted purple for links; `@fluxAppearance` drives the `dark` class. The gradient and dot texture are gone.
- **Copy.** "SCOUTS South Africa" in the welcome widget, the info blurb, the certificate generator page and notice, the AAM form views and the account check tool. Em dashes in page copy replaced.
- **Tests.** `tests/Feature/BrandingTest.php`: splash, holding zone login, password reset request, member dashboard, holding zone dashboard and BackOffice dashboard each assert the logo alt text and the membership line; the component test asserts the file names and that the artwork files exist.

## Verification

- `php artisan test --compact tests/Feature/BrandingTest.php`: 7 passed. Full suite result recorded in the 035 completion record for the same day.
- Mutation check: removing the `FOOTER` render hook from `MemberPanelProvider` makes `member_panel_carries_the_ssa_logo_and_membership_line` fail; restoring it passes. See the 035 record for the run.
- `vendor/bin/duster fix --dirty` run. `npm run build` run.
- Visual pass in Chrome, light and dark: splash, holding zone login, member dashboard, a BackOffice table, holding zone dashboard. Recorded in the 035 completion record.
- Byte comparison of `public/images/brand/` against the originals cannot be done inside the dev container (the sources folder is on John's machine). John copied the files in on 2026-10-08; the comparison is his to confirm with `sha256sum`. The white-on-purple SVG in the repo carries `#622599` as its fill, which is the expected derivation.

## Risk assessment

- The auth layouts no longer force dark mode. Anyone who relied on the password reset pages always being dark sees them follow their appearance setting instead. Low impact and consistent with the panels.
- The `FOOTER` hook adds a line to every panel page. Filament renders that hook inside the app layout after the main content, so sticky or full-height custom pages gain about 2 rem at the bottom.
- The logo is served as SVG. Browsers that cannot render SVG are not a concern for this app; emails (ticket 036) use the PNG.
- `brandLogoHeight('2.5rem')` was chosen against the 120 px floor. Lowering it would breach the manual's minimum size.

## Decisions

- Emails split into ticket 036 so this diff stayed reviewable; John chose the split on 2026-10-08.
- The full `web/` folder was committed rather than only the two logos and one rope, because the skill names it as the only permitted source and keeping the set whole makes future byte comparisons simpler. The black logo variants and the extra ropes are not referenced by any view.
- The membership line appears in the footer of every panel page, not only auth pages. It is small, uses the UI font per the skill, and reads as the organisation's signature rather than chrome.
- The Ssalute mascot stays the app mark (favicons, PWA icons, the wordmark on the splash) and is never labelled as the organisation.

## Original ticket

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
- **Generated documents.** The membership certificate is its own ticket, 035, because it needs a full rebuild rather than a logo drop. This ticket supplies the `<x-ssa-logo>` component and the membership line component that 035 consumes.
- **Copy.** Where the app names the organisation it says "SCOUTS South Africa" in full. The skill's naming rules apply.

## Out of scope, decided deliberately

- The World Scouting logo and the bare World Scout Emblem. Showing WOSM membership with the 2024 World Scouting logo is within SSA's NSO permissions, but WOSM has not published how a national logo sits beside it, so it is a ManCo brand decision and gets its own ticket if taken.
- The promotional CI (hessian textures, badge logo, AG Stencil). Print only and not for an administrative system.
- Any change to the section coding colours or to the neutral palette.

## Verification

- Feature tests that the auth layouts and each mail view render the logo component and the membership line (assert on the alt text and the line, not on markup).
- Visual pass in light and dark mode on the member login, a BackOffice page, the holding zone and one rendered email.
- Confirm no file under `public/images/brand/` differs from the supplied artwork (byte compare against the originals kept outside the repo).

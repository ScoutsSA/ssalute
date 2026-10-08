# Membership certificate in the SSA corporate brand

**Priority when actioned:** p5

## Synopsis

The public membership certificate read as a generic app card: mascot labelled as the organisation, gradient bars, green and red dashed stamps, UI font, no sign of World Scouting membership. Rebuild it as an SSA corporate CI document that members can hand to employers, schools and event organisers.

## Resolution

`resources/views/membership-certificate/show.blade.php` was rebuilt; the controller is unchanged.

- **Band.** Flat `#622599` band with the supplied white-on-purple logo at the left via `<x-ssa.logo>` and the title "Membership Certificate" plus the issue date at the right. No gradient, no pattern, no effects.
- **Identification bar.** A purple-tint strip under the band carrying "Member of the World Organisation of the Scout Movement", mirroring the "NATIONAL OFFICE" bar on the National letterhead.
- **Body.** White, Verdana (`Verdana, Geneva, Tahoma, sans-serif`), near-black `#1E1E1E` text, 14 px on screen and 10.5 pt in print. "This certifies that {name} is a registered and active member of SCOUTS South Africa", the SSA ID chip, the optional details grid and the roles list with Group · District · Region scope. The `visible_fields` gating, the photo and the eligible-roles check are untouched.
- **Status.** Active: a purple panel reading "Verified member" with "Active membership of SCOUTS South Africa confirmed as at {date}". Inactive: a grey panel with a dark border reading "No longer an active member" and "This certificate is not valid as at {date}". Red is a section coding colour in this brand and is not used. A short line under either state says the certificate confirms membership only and that status is live.
- **Footer.** National Office contact block (`info@scouts.org.za`, `www.scouts.org.za`), the certificate reference, the verification QR with "Scan to verify", then the supplied tricolour rope with "be prepared" (`ssa-rope-flag-be-prepared.svg`) across the bottom, mirroring the letterhead. The rope appears nowhere else in the app.
- **Print.** `@page A4 portrait, margin 0`; the sheet becomes 210 x 297 mm with 16 mm side margins, the logo at the manual's A4 width of 64 mm, `print-color-adjust: exact` so the band and rope print in colour, toolbar and attribution hidden, status and roles blocks kept on one page where possible.
- **Dark mode.** The sheet is a document and is always white. The ground, toolbar and attribution follow the OS `prefers-color-scheme`. The theme toggle and `cert-theme` storage are gone.
- **Copy and metadata.** `<title>` is "{name}, Membership Certificate, SCOUTS South Africa"; Open Graph and Twitter text say SCOUTS South Africa; the share image falls back to `ssa-logo-white-on-purple.png` instead of the mascot; em dashes are gone from page copy. The mascot appears once, off print, in "Issued by Ssalute, the SCOUTS South Africa member system".
- **Tests.** `tests/Feature/Filament/Member/MembershipCertificateTest.php` updated: the public render test asserts the title, logo alt text and file, membership line, rope file, QR alt text, contact block and attribution, and that "Scouts South Africa" (old casing) no longer appears; the inactive and active tests assert the new status copy and each other's absence; a new test covers the share image fallback.

## Verification

- `php artisan test --compact` on 2026-10-08: 845 passed, 3 skipped (the skips predate this work). Re-derive with the same command.
- `php artisan test --compact tests/Feature/Filament/Member/MembershipCertificateTest.php`: 19 passed.
- Mutation check: changing the active status copy makes `public_certificate_page_renders` and `public_certificate_shows_verified_when_user_has_active_roles` fail (observed while iterating on the copy); the 034 record covers the footer hook mutation.
- `vendor/bin/duster fix --dirty` run, `npm run build` run.
- Visual pass in Chrome on 2026-10-08 against a synced certificate at desktop width: band, logo, identification bar, roles, purple status panel, footer and rope all render; one defect found and fixed (the SSA ID chip doubled the "SSA ID" prefix because the accessor already includes it). The splash page was checked in light and dark; the member panel and a BackOffice table in dark and light.
- Not verified: the printed PDF from Chrome and Firefox, and the phone-width screen check. The print rules were written against A4 but no PDF was exported in this session. John should print once from each browser before relying on it.
- The holding zone login page was not viewed in the browser because the session was signed in; its rendering is covered by `BrandingTest::holding_zone_login_carries_the_ssa_logo_and_membership_line`.

## Risk assessment

- Print output is the untested path (see above). `print-color-adjust: exact` is honoured by Chrome and Firefox; Safari needs the `-webkit-` prefix, which is set.
- The rope SVG is 265 KB. It loads once per certificate view and is cached. Acceptable for a page members open occasionally; swap to the PNG if it ever matters.
- Status copy changed, so any external reader that scraped "Verified Member" or "Inactive Member" text would break. No such reader is known.
- The sheet no longer has a dark variant; anyone who preferred the dark certificate loses it. The manual's certificate is a white document and this is deliberate.

## Decisions

- The ground around the sheet follows the OS theme; the sheet never does. Recorded here as the ticket asked.
- The rope is included (John chose this on 2026-10-08) since the National Office supplied the artwork and the skill permits it in corporate document footers.
- Verdana was kept for the whole certificate rather than Instrument Sans (John chose this on 2026-10-08): it is a document in the manual's sense and prints identically everywhere.
- The identification bar carries the membership line rather than "NATIONAL OFFICE", because the certificate is issued by the system on behalf of the organisation, not by the office as a letter would be.

## Original ticket

# Membership certificate in the SSA corporate brand

Module: 01-adult-member-system
Panel: member (the certificate page itself is a public, unguessable route, `membership-certificate.show`, reached from the member profile)
Gate: the supplied SSA corporate logo artwork (white on purple and purple on white) is in `public/images/brand/`. Shared gate with ticket 034; whichever lands first adds the files. Nothing here may start from a traced or AI generated fleur-de-lis.

The membership certificate (`resources/views/membership-certificate/show.blade.php`, `MembershipCertificateController`) is the one SSA document members share outside the organisation: with employers, schools, event organisers and parents. It is "official membership documentation" in the terms of the 2016 Marketing and Branding Policy, which puts it squarely in the standard corporate CI. Today it reads as a generic app card: the purple band carries the Ssalute smiley mascot labelled "Scouts South Africa", the header and footer bars are gradients, the verified and inactive stamps are green and red dashed circles, the type is the UI font, and there is no sign that SSA is a member of World Scouting. The `scouts-sa-brand` skill (`.claude/skills/scouts-sa-brand/SKILL.md`, `references/brand-manual-digest.md` sections 3.4, 3.5 and 6.8) is the reference.

Filed at p5: the National Chair for IT has asked for it by name as the first visible brand fix, and it is the document members are most likely to put in front of people outside Scouting. Below the p4 hygiene fix (033) that it builds on.

## What the brand asks of a certificate

From the manual's corporate certificate examples (Wood Badge, Certificate of Merit, Star Awards):

- The SCOUTS South Africa logo, white on the brand purple, in the purple area at the top, left aligned per section 2.2, never centred as the only element and never with effects.
- The line "Member of the World Organisation of the Scout Movement" as the standard header or footer line.
- A clean white body. Purple and white carry the brand; one additional colour at most, with strong contrast.
- The rope and "be prepared" tag line are part of the corporate CI and appear on official certificates. Use the supplied rope artwork only, in the purple or colour version, never redrawn; if the National Office cannot supply it, leave it out rather than imitate it.
- Typefaces: Verdana for body copy (web safe, no font loading), Verdana Bold or Futura for headings if Futura is available to the renderer. Not Instrument Sans.
- The National Office contact block in the footer: `info@scouts.org.za`, `www.scouts.org.za`.
- The organisation is written "SCOUTS South Africa".

## Scope

- **Rebuild the page around the corporate CI.** Purple header band (`#622599`, flat, no gradient) with the SSA logo via the `<x-ssa-logo>` component from ticket 034 and the title "Membership Certificate"; white body; footer with the membership line, the contact block, the verification QR code and the certificate reference. The two gradient bars go.
- **Keep what works functionally**: the share and print toolbar (off-print), the QR code to the verification URL, the `visible_fields` gating, the photo, the roles list with its Group, District and Region scope, the eligible-roles check that drives the status.
- **Status treatment.** Replace the green and red dashed stamps with something the manual would recognise: a purple ribbon or badge reading "Verified member as at {date}" for the active case, and a plain, unmistakable grey panel reading "No longer an active member" for the inactive case. Red is a section coding colour (adults) in this brand and should not read as "invalid"; use the neutral scale for the negative state and purple for the positive one. Keep the inactive case loud enough that nobody mistakes it for valid.
- **Typography.** Set the certificate in Verdana (body 10 to 11 pt equivalent on screen, headings Verdana Bold), scoped to this view so the app's Instrument Sans is untouched elsewhere.
- **Print.** The `@page` and `@media print` rules produce an A4 portrait sheet that matches the manual's letterhead proportions: purple band across the top, logo at the manual's A4 width (64 mm), clear space respected, membership line in the footer, no toolbar, no theme toggle. Test a PDF export from Chrome and one from Firefox.
- **Dark mode.** The certificate is a document; render it on white regardless of the OS theme. Drop the theme toggle and the `cert-theme` storage, or keep the toggle only for the page chrome around the sheet. Decide and record under `## Decisions`.
- **Copy and metadata.** "SCOUTS South Africa" everywhere, including `<title>`, Open Graph and Twitter card text; the OG image falls back to the SSA logo on purple, not the mascot; replace the em dashes in the page copy with commas or full stops per the skill's writing rules; the alt text on the logo says "SCOUTS South Africa", the mascot is no longer labelled as the organisation.
- **The app mark.** The Ssalute mascot and favicon may still appear once, small, in the off-print "Issued by Ssalute" line below the sheet, so the product is credited without sharing the organisation's signature.

## Out of scope, decided deliberately

- The World Scouting logo and the bare World Scout Emblem. Showing WOSM membership is within SSA's permissions but the lockup beside a national logo is unpublished; the text line carries the meaning here.
- The promotional CI (hessian, badge logo, AG Stencil). Certificates are corporate.
- Changing what the certificate asserts, who can issue one, or the `visible_fields` model.

## Verification

- Feature test on the show route: renders the SSA logo alt text, the membership line, "SCOUTS South Africa" in the title, the QR code, and the correct status copy for an eligible and an ineligible user (factories with and without eligible role attachments).
- Visual pass on screen (desktop and phone width) and a printed PDF from two browsers, checked against the manual's section 3.4 example for logo position, band and footer line.
- Byte compare the committed artwork against the supplied originals kept outside the repo.

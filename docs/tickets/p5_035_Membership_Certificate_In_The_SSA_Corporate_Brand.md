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

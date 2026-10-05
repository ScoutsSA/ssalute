---
name: scouts-sa-brand
description: "SCOUTS South Africa (SSA) brand guidelines condensed for product work. Activate whenever you touch anything a member or the public sees: Blade views, Filament panel branding, Flux or Tailwind styling, emails, PDFs, certificates, Slack or WhatsApp message templates, marketing copy, logos, favicons, colour tokens, fonts, or imagery. Also activate when the user mentions SSA, SCOUTS SA, WOSM, the World Scout Emblem, the fleur-de-lis, the SSA purple, the badge logo, the rope, or asks whether something is 'on brand'. Covers the official colours, the two corporate identities (corporate vs promotional), logo rules and what we may NOT draw, typefaces and their web fallbacks, tone of voice, naming, section colour coding, imagery rules, and the WOSM ownership constraints. Do not use for backend logic with no user-facing output."
---

# SCOUTS South Africa brand

Condensed from the SSA Brand Manual 2015, the 2020 "How is the SCOUTS SA brand used?" infographic, the SSA Marketing Toolkit wiki page, and the SSA letterhead guideline. Full detail and sources are in `references/`. Read this file first; open a reference only when the question is not answered here.

Two things matter more than everything else:

1. **The purple is `#622599`** (Pantone 527 C, CMYK 79/94/0/0, RGB 98/37/153). Not `#5C2D91`, not Tailwind `purple-700`, not "a nice purple". Dark-mode variants are ours to define (see Digital tokens), the base value is not.
2. **We never draw the World Scout Emblem (fleur-de-lis) or reconstruct the SCOUTS logo.** Both are registered trademarks owned by World Scouting. We only place official artwork that SSA supplied, unaltered, and only where SSA permits it. When in doubt, use the app's own mark and the words "SCOUTS South Africa".

## Who we are (for copy and tone)

- **Name**: always "SCOUTS South Africa" in full on first use, "SSA" after that in internal text. "SCOUTS" is upper case in the organisation name because it is the wordmark. Country name capitalised as a title. Never "Scouts SA" in formal copy, never "Boy Scouts", never "the Scouting Association of South Africa" (that is the pre-2015 name whose red logo may no longer be used).
- **Vision**: SSA is South Africa's premier youth movement dedicated to the development of young people in creating a better country for all.
- **Mission**: to contribute to the education of young people, through a value system based on the Scout Promise and Law, to help build a better world where people are self-fulfilled as individuals and play a constructive role in society.
- **Brand strengths (the personality)**: Involving (constructive, educational, equal), Exciting (attractive, dynamic, innovative), Empowering (value-based, democratic, responsible). Every piece of copy, every image, every UI state should be able to answer "which of the three is this?".
- **Communication themes** (2016 policy): SSA is a "Social Force" that brings a "Culture of Peace" and makes a "Constructive Contribution" to society and the environment. Use these as the frame for any public-facing "about" copy.
- **Tagline**: "be prepared" (lower case in the artwork, always as part of the rope artwork or badge, never typed as a free-standing headline). In running text write "Be Prepared" normally.
- **Tone**: warm, direct, plain English, second person, active voice. Adventurous and energetic without being loud. Respectful of volunteers (they are the audience most of the time). No corporate jargon, no military framing ("troops march", "command"), no hype. Short sentences. Scouting values are shown, not preached.
- **Sections and their colours** (used for programme categorisation): Meerkats, Cubs (lime `#739600`), Scouts (yellow `#FFB612`), Rovers (orange `#FF5800`), Adults (red `#DE3831`). Meerkats post-date the manual and have no official coding colour yet; do not invent one, use purple.
- **Section nouns**: Meerkat Den, Cub Pack, Scout Troop, Rover Crew. Adults are "adult leaders" or "volunteers" (uniformed adults hold a "warrant"). The unit is a "Scout Group", the structure is Group, District, Region, National.
- **Contact and handles** that appear in official material: `info@scouts.org.za`, `pr@scouts.org.za` (brand queries), `ceo@scouts.org.za` (brand consent), `www.scouts.org.za`, `0860 SCOUTS (0860 726887)`, Facebook `SAScout`, Twitter/X `@SAScout`, hashtags `#SCOUTSSA #BeSeen #Skills4Life`.

## The two corporate identities (never mixed in one document)

| | Corporate CI | Promotional CI ("promo brand") |
|---|---|---|
| Who may use it | National and Regional teams only | Groups, Districts, Regions, National for PR |
| Look | white background, clean SCOUTS South Africa logo white on purple, "be prepared" tagline, the tricolour rope | canvas / hessian / burlap textures, SSA badges as graphic elements, SSA logo in **badge form**, "be prepared", AG Stencil headings |
| Used for | official letters, warrants, certificates, awards, policies, HR and finance documents, signage, flags, merchandise | brochures, posters, pull-up banners, PowerPoints, websites, social media, newsletters, adverts, programme and training materials |
| Rope | yes (SA flag colours, purple, black or white versions) | **never** |
| Badge logo | no | yes (exception: signage, banners, flags use the clean logo) |

Rule of thumb for our apps: **ssalute is an administrative system, so it sits closest to the corporate CI** (clean, white, purple accent, no textures). **The support bot talks to members and the public and may borrow the warmer promo register** (paper tint, friendlier copy) but it still does not get to use the SSA badge logo or the emblem; it has its own campfire mark for that reason. Neither app may use the rope artwork or AG Stencil headings; those are print elements and the rope is corporate-only.

## Colours

Primary, from the manual (section 2.5):

| Name | Hex | RGB | CMYK | Pantone |
|---|---|---|---|---|
| SSA Purple | `#622599` | 98 37 153 | 79 94 0 0 | 527 C/U/M |
| White | `#FFFFFF` | 255 255 255 | 0 0 0 0 | |

Secondary "coding system" (nine reserved colours, used to categorise publications and sections, never as a second brand colour):

| Name | Hex | Pantone | Reserved for |
|---|---|---|---|
| Black | `#1E1E1E` | Process Black | text |
| Blue | `#002395` | Reflex Blue | |
| Green | `#007A4D` | 3415 | |
| Red | `#DE3831` | 179 | adults |
| Yellow | `#FFB612` | 1235 | scouts |
| Lime | `#739600` | 377 | cubs |
| Sky blue | `#0098DB` | 2925 | |
| Orange | `#FF5800` | 021 | rovers |
| Grey | `#8996A0` | 7544 | |

Blue, green, red and yellow are the South African flag colours and are what the rope is drawn in.

Rules:
- Purple and white carry the brand. One additional colour is allowed per piece (for example a section colour) and it must contrast strongly with the purple.
- Avoid dark backgrounds behind the purple logo, yellow backgrounds behind the white logo, and low-contrast purple-on-colour generally.
- Pink and the lighter spectrum tints are explicitly "colours to avoid" as backgrounds.
- Body text is near-black `#1E1E1E`, not pure black and not purple.

### Digital tokens (our extension, not from the manual)

The manual predates dark mode and web tokens. Both apps already converge on this set; keep to it:

```css
--purple:       #622599;  /* brand, light-mode accent, primary buttons, links */
--purple-deep:  #4A1C73;  /* hover / pressed on light */
--purple-soft:  #E6DBF3;  /* selected rows, chips */
--purple-tint:  #F3EEFA;  /* subtle backgrounds, callouts */
--paper:        #FAFAF8;  /* page background (promo-register surfaces) */
--ink:          #18181B;  /* text */
```

Dark mode: lift the accent to roughly `#7B4DB8` so purple stays legible on near-black, keep the purple area itself `#622599` for the logo lockup. Semantic status colours (success green, warning yellow, danger red) stay in the app's neutral palette and are not brand colours; do not reuse the section coding colours for status.

Filament panels: `'primary' => Color::hex('#622599')`. Flux / Tailwind v4: `--color-accent: #622599` in `@theme`. Zinc stays the neutral scale.

## Logo, emblem and marks

What the official SCOUTS South Africa logo is: the World Scout Emblem (fleur-de-lis) + the wordmark "SCOUTS" + the ® + the country name "South Africa", white on a purple rectangle. There is exactly one logo for the country. It is never used to identify a Region or Group.

Hard rules (manual 2.1, 2.2, A.1; infographic 2020):

- Never redraw, trace, vectorise, recolour, outline, distort, crop, rotate, animate or add effects to the emblem or the logo. Never draw a fleur-de-lis of our own. Never generate one with AI.
- Never split the lockup: emblem, wordmark and country name are not used separately. Never replace "SCOUTS" with another word, never swap the emblem for a Group or app icon.
- Colours: white on purple (standard); purple on white (allowed exception); white on black (mono reproduction only). No other colours, no mixed colours inside the logo.
- Clear space: the logo sits inside its purple area; the space to the edge of that area is its clear space. Never centre the logo as the only element on a page. Never use a low-contrast placement.
- Minimum sizes: logo with country name 40 mm wide in print (A6 40, A5 50, A4/A3 64, A2 100 mm); emblem alone 6 mm high. For screens, do not scale an official logo raster below the point where "South Africa" is legible, roughly 120 px wide.
- Where the logo comes from: SSA sends the badge logo to registered Groups on request (`pr@scouts.org.za`). The clean corporate logo and the bare emblem are not for us to use without written consent through the National Scout Office. Royalties apply to merchandise.
- Partner / co-branding: the SCOUTS logo keeps its fixed-proportion purple rectangle, partner logo gets equal visual weight with 2x clear space, caption "Member of the World Organisation of the Scout Movement" is the standard footer line on official stationery.
- The old red logo with the Springbok head (Scouting Association of South Africa) may not be used anywhere.

Practical consequence for our apps:

- **These are National Office systems.** The product owner (John Roux) is SSA's National Chair for IT, sits on ManCo and is part of the National Office, so the NSO-level permissions in the manual and the 2016 policy apply directly: the apps may carry the SSA corporate logo (clean version, white on purple or purple on white), the "Member of the World Organisation of the Scout Movement" line, and official SSA stationery conventions in emails and generated documents. Placement decisions are his to make. What stays outside that remit: altering the artwork in any way, putting the marks on merchandise or anything sold (WOSM licence and royalties), using the bare World Scout Emblem or the World Scouting logo on its own (brand-team-controlled at WOSM), and anything the manual reserves for the CEO or PR office (`ceo@scouts.org.za`, `pr@scouts.org.za`).
- **The apps still use their own marks for app identity** (ssalute's icon, the support bot's campfire) so the SSA logo keeps its meaning as the organisation's signature rather than a product icon. The SSA logo is an unmodified supplied raster/SVG loaded from `public/images/brand/`, never inlined by hand, shown in official spots: login and SSO screens, email headers or footers, PDF letterheads and certificates, "about" pages.
- Favicons, Apple touch icons and OG images are the app mark, not the emblem.
- Impersonation and SSO hand-off screens should say "SCOUTS South Africa" in text and may use the purple area, but still no emblem.

## Typefaces

Official (manual 2.4, wiki):

- **Verdana**: body text of all documents, website and emails. Chosen for on-screen legibility.
- **Futura / Futura Bold Condensed**: the country name in the logo, headlines and main titles of South African publications. Futura is a licensed font; we do not ship it.
- **AG Stencil**: promotional-CI graphic headings "stencilled" onto canvas. Print only, never UI text.

Digital stance, agreed across both apps:

- UI chrome, admin panels and the chat use **Instrument Sans** (already wired into Flux, Filament and the bot's `<x-brand.head>`), with the system-ui stack as fallback. This is a product typeface, not the brand typeface, and that is acceptable because the manual's Verdana mandate is about documents and emails, not application interfaces.
- **Emails and generated documents (PDF certificates, letters, exports) use Verdana**, `font-family: Verdana, Geneva, Tahoma, sans-serif`, because they are documents in the manual's sense and because Verdana is on every client. Body 10 to 11 pt, headings Verdana Bold. Where a letterhead is reproduced: Group name max 10 pt, contact lines 7 pt, logo max 10 x 10 mm, always upper left.
- Headings in documents may use Futura if the rendering environment has it, otherwise Verdana Bold. Never substitute a "similar looking" geometric sans and call it Futura.

## Imagery and illustration

From manual 2.6 and the 2020 infographic. Applies to photos we show, placeholder art we pick, and AI-generated or stock imagery we are asked to add.

- Content over style. Real Scouts, real activity, real places. Scouts are recognisable as Scouts (scarf, uniform, badges) where possible.
- Show balance and diversity: girls and boys, women and men, all ethnic backgrounds and regions, multiple generations working together.
- Show movement and purpose: doing, building, hiking, leading. Not posed group shots, not static protocol, not bored faces, not military formations, not aggressive leadership.
- Natural colour and setting, wide perspective. No artificial colour grading, no cut-out backgrounds, no odd camera angles.
- The majority of images on any surface should "show the fun and adventure of Scouting" rather than people looking at the camera.
- Empty states and illustrations: outdoor, campfire, compass, knots, tents, trail themes are on brand. Anything that mimics the fleur-de-lis is not.
- Children: never pair a child's face with their full name in anything public. Internal admin screens (ssalute) are fine; public bot answers and marketing are not. (Our rule, derived from the SSA Child Protection Policy that the branding policy says must be read with it; not stated in the brand manual itself.)

## Writing copy and messages

- Lead with what the reader can do. Volunteers are busy; respect their time.
- Use the section names and roles exactly (Scouter, Troop Scouter, Pack Scouter, Rover, Adult Leader, Regional Commissioner, District Commissioner, Group Leader). Do not Americanise ("Scoutmaster", "Boy Scouts", "Eagle Scout").
- Spell South African English (colour, organisation, programme, licence as noun).
- Keep the brand strengths in mind: an error message can still be involving ("Let's fix that together"), a success state can be exciting without exclamation marks everywhere.
- Scouting is non-partisan and non-commercial: no political framing, no selling. Brand use "is for PR purposes only, not for commercial use". The 2016 policy forbids advertising for personal or corporate financial gain on any SSA platform; only Scouting-related merchandise, activities, training and events may be promoted, and third-party adverts need Marketing Committee or Exco approval. This applies to anything the apps display or send.
- Grievances and organisational disputes do not belong in public-facing channels (policy 7). The support bot should route those to real people, not relay them.
- When an answer or template references the brand itself, point people to the Marketing Toolkit on the SSA wiki and to `pr@scouts.org.za`; do not promise logo files.
- Sign-offs in official emails use the WOSM membership line: "Member of the World Organisation of the Scout Movement".

## WOSM (World Scouting) constraints

The SSA brand is a WOSM-licensed "Country Identity Brand": WOSM owns the emblem and the "SCOUTS + country" logo, and SSA's licence to run Scouting depends on using it correctly (which is why every older SSA logo is banned). SSA's 2015 manual follows the 2007 World Scout brand. **WOSM refreshed its own brand in August 2024** ("World Scouting", tagline "Ready for Life", new emblem drawing, Scouts GT Planar and Noto Sans, a ten-colour palette) and has not yet published rules for national lockups; SSA has not published a response. Full detail and sources in `references/wosm.md`. What it means for us:

- Scouting Purple is still `#622599` under both brands. No token changes.
- Keep following the SSA manual for the SSA logo; do not invent a "World Scouting" style version. Pairing the SSA logo with the new World Scouting logo is an NSO-level decision the National Office can take (WOSM encourages it to show membership), but it is a policy choice for ManCo, not something to add in a UI ticket.
- Never use WOSM's retired tagline "Creating a Better World" in new copy. "Ready for Life" is WOSM's, not SSA's; SSA's is "be prepared".
- Noto Sans is an acceptable on-brand fallback when neither Instrument Sans nor Verdana fits the medium. Midnight Purple `#4D006E` is WOSM's body-text colour, not ours.
- WOSM's WCAG-tested pairings on our shared purple are reusable: white, Ember Orange `#FFAE80`, River Blue `#82E6DE`, Leaf Green `#9FED8F` and Blossom Pink `#FF8DFF` all reach AAA on `#622599`. SSA's own section colours on purple are untested; check contrast yourself.
- WOSM's voice rules are a good tie-breaker for copy: sentences under ten words, no jargon, curiosity, exclamation marks sparingly, always say how to get involved.
- Membership figure for copy: "60 million Scouts in 176 National Scout Organisations" (World Scouting, 2024), not the 32 million in SSA's 2015 collateral.

## Checklist before shipping a user-facing change

- [ ] Purple is `#622599` (or the agreed dark-mode lift), nothing else carries the brand.
- [ ] No hand-drawn, AI-drawn or modified fleur-de-lis or SCOUTS logo anywhere, including favicons, OG images and empty states.
- [ ] App mark used for app identity; SSA logo only as supplied, unaltered artwork in official spots (login, email, documents, about).
- [ ] Emails and generated documents in Verdana; UI in Instrument Sans.
- [ ] Copy says "SCOUTS South Africa", uses SA section names and SA English, reads as involving / exciting / empowering.
- [ ] Section colours only used to categorise sections, never as status colours.
- [ ] Imagery shows active, diverse, real Scouting; no posed or military imagery.
- [ ] No rope, textures, badges or AG Stencil in app UI (print-only elements).
- [ ] Nothing implies commercial use or sale of branded items.

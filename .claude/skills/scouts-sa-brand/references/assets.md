# Official artwork we hold

Everything here lives outside the repos in `~/Documents/scouts-brand-sources/` on John's machine. Repo copies under `public/images/brand/` must be byte-identical to the files in `web/`; that is how a reviewer proves nothing was redrawn.

## Master files (National Office, received 2026-10-08)

Folder `masters-2026-10-08/`, forwarded from the National Office in a zip titled "SCOUTS SA Assets". SHA256 sums sit next to the files.

| File | What it is | Provenance |
|---|---|---|
| `SCT_Logo_SouthAfrica_527_no.ai` / `.pdf` | SCOUTS South Africa logo, **white on the purple area** (negative). The standard logo. | Illustrator, World Scout Bureau template |
| `SCT_Logo_SouthAfrica_527_pos.eps` | Logo in purple on white (positive). The allowed exception. | EPS, "For: World Scout Bureau", Illustrator 11, 23 Feb 2009 |
| `SCT_Logo_SouthAfrica_blk_pos.eps` | Logo in black on white (mono reproduction). | same |
| `SCT_Logo_SouthAfrica_blk_co.eps` | Logo white on a black area (mono reversed). | same |
| `Rope_SouthAfrica_cmyk.ai` / `.pdf` | The tricolour rope (SA flag colours plus black) with "be prepared...." | Illustrator 24, 2020 |
| `Rope_SouthAfrica_cmyk_no_slogan.ai` / `.pdf` | Same rope without the slogan | |
| `Rope_SouthAfrica_527.ai` / `.pdf` | Rope in purple only, with slogan | |
| `Rope_SouthAfrica_B-W.ai` / `.pdf` | Rope in black, with slogan | |
| `Rope_SouthAfrica_B-W_no_slogan.ai` / `.pdf` | Rope in black, no slogan | |

Facts about the masters that matter when deriving anything:

- Pure vector. No embedded rasters, no live text, every glyph is outlined. The ® after SCOUTS is part of the artwork.
- The purple is the spot colour **PANTONE 527 U** with a CMYK alternate of 73/100/0/0. Rendered naively that comes out near `#611F91`, which is not the brand hex. The manual's RGB for Pantone 527 is `#622599`, so the web derivatives carry `#622599` as the fill. That is a colour-space mapping of the same ink, not a recolour.
- Black in the masters is rich black `#231F20` (CMYK 0/0/0/100 as Illustrator renders it). Left as is in the derivatives.
- The rope flag colours as rendered: red `#F1491C`, yellow `#FAB41D`, blue `#2151A8`, green `#00875D`, black `#231F20`. These are the Illustrator CMYK renders, not the Pantone values in the manual's coding table; print from the masters, do not retype these.
- Logo aspect ratio 181.59 x 57.09 pt (3.18 : 1). The purple area in the negative file **is** the logo's clear space; do not add another rectangle around it.
- Ropes sit on an A4 landscape page in the masters; the `web/` copies are cropped to the artwork (841.89 x 77.4 pt).

## Web-ready derivatives (`web/`)

Produced with `pdftocairo` from the masters (EPS went through Ghostscript `pdfwrite` with `-dEPSCrop` first). The only edit applied was the fill substitution to `#622599` described above.

| File | Use |
|---|---|
| `ssa-logo-white-on-purple.svg` / `.png` | Default. Purple header bands, login screens, email headers, dark surfaces. The purple area is part of the file. |
| `ssa-logo-purple-on-white.svg` / `.png` | On white or the paper tint. Footers, about pages, documents, print. Transparent PNG. |
| `ssa-logo-black-on-white.svg` / `.png` | Mono only (fax, stamps, single-colour print). Not for UI. |
| `ssa-logo-white-on-black.svg` / `.png` | Mono reversed. Not for UI. |
| `ssa-rope-flag-be-prepared.svg` / `.png` / `-cropped.pdf` | Corporate CI letter and certificate footers. |
| `ssa-rope-flag.svg` / `.png` / `-cropped.pdf` | Same without the slogan. |
| `ssa-rope-purple-be-prepared.svg` / `.png` / `-cropped.pdf` | Single-colour rope. |
| `ssa-rope-black-be-prepared.svg` / `.png` / `-cropped.pdf` | Mono rope. |
| `ssa-rope-black.svg` / `.png` / `-cropped.pdf` | Mono rope, no slogan. |

PNGs are 600 dpi renders (logos 1514 x 476 px, ropes 7039 x 645 px) with transparent backgrounds. Resize down for a specific slot; never upscale a PNG, use the SVG.

Rules that still apply to these files: no filters, shadows, outlines, rotation, cropping of the lockup, or recolouring. Logo never narrower than about 120 px on screen. The rope is **corporate CI only**: official letters, certificates and the like. Not in app chrome, not next to the badge logo, not on promotional material.

## National letterhead (`letterhead-2026-10/`)

`national_letterhead.docx` is the current National Office Word letterhead, with its header and footer extracted as images. The header JPEG is CMYK, so its colours preview wrong (a blue-violet) in a browser; do not sample colours from it.

Current National Office contact block as printed on it (supersedes the manual's 2015 address):

```
PO Box 2434, Clareinch 7740
Tel: +27 (0)68 069 9463
Email: info@scouts.org.za
Web: https://www.scouts.org.za
```

with a second column for the National Scout Shop (`Tel: +27 (0)67 693 2560`, `shop@scouts.org.za`, `https://shop.scouts.org.za`), the logo at the right, a "NATIONAL OFFICE" identification bar beneath the band, the line "Member of the World Organisation of the Scout Movement" under that, and the tricolour rope with "be prepared...." as the footer. This is the layout to mirror in generated letters and certificates.

`scouts-logo-badge-layers.png` is a photo-style render of the embroidered badge (1552 x 839). It is promotional-CI material; see below.

## Promotional CI pack (`promo-2026-10-05/`)

From the Marketing Toolkit OneDrive share, 2026-10-05. All raster.

- `SSA Logo.png`, `SSA Logo ii.png`, `34474-cover.jpg`, `SSA.jpg`: raster copies of the logo on purple. Superseded by the vector masters; keep only as a cross-check.
- `SSA badge.png`: the embroidered badge logo (367 x 137), the one the manual says Groups use on promotional material.
- `Header.png`, `Bus card 1.jpg`, `SSA background 1` to `6.png`: finished promo compositions (hessian strip, badges, logo badge with "be prepared"), roughly 955 x 536 each. Templates for posters and social, not for the apps.
- `Hessian_brown.png`, `Hessian_brown_border.png`, `purple-hessian-sack-cloth-...jpg`: the canvas textures. The purple one is a stock photo (ID 84148337 in the filename), licence unknown.

Nothing in this folder goes into ssalute. The support bot may draw on the promo register for warmth but still does not place the badge or textures (see SKILL.md).

## Fonts (`fonts/`)

- `FuturaStd-Book.otf`: Adobe Futura Std Book, a commercially licensed font (Adobe / Neufville). We have one weight, the licence that came with it is unknown. Use for local document rendering only; **do not ship it in a web app** and do not embed it in a PDF we distribute without checking the licence.
- `AG-Stencil.ttf`: the promotional-CI stencil face (free font, foundry "pyrs"). Print only, never UI text.

Verdana is not in this folder because it ships with every client.

# Normalize Legacy Html Entity Encoding

Panel: console

The legacy editors re-encoded HTML entities on every save, so `system_faq.a`, `sd_articles.intro`, `sd_articles.article` and `system_roadmap_little.text` hold double and triple encoded HTML (as of the 2026-08-22 sync: 209 of 212 FAQ answers, 33 of 34 articles, 8 of 8 roadmap items). The legacy display pipeline copes by decoding twice at render time. The BackOffice rich editors now decode on hydrate (`LegacyHtmlService::decode`) and write clean HTML back on save, so any entry edited in Ssalute normalizes itself. This ticket is about normalizing the remaining rows in bulk with a data migration.

## The backwards compatibility catch

Legacy display runs `strip_tags` with a whitelist (`b, strong, u, i, br, p, div, ul, ol, li`) BEFORE decoding. On encoded rows the whitelist sees no tags and keeps everything, then the decodes reveal the tags and the browser renders all of them. The whitelist is therefore bypassed today, and non whitelisted tags currently render. After normalization the whitelist would actually apply and strip them.

Measured against the 2026-08-22 sync, decoded content contains non whitelisted tags in 34 of 212 FAQ answers and 20 of 34 articles (none in roadmap items): `span` x55, `a` x40, `blockquote` x8, `o` x4 (Word paste artifacts), `sup` x3, `h3` x3. Blanket normalization would most visibly turn 40 hyperlinks into plain text on the legacy pages.

## Recommended path

1. Patch the legacy `cleanDbOutput` whitelist to also allow `a, span, blockquote, sup, h3` (this matches what actually renders today) and deploy that first. The legacy repo is patched directly on master, outside this repository.
2. Then add a roll forward data migration here that rewrites all four columns through `LegacyHtmlService::decode`, and run it on deploy.
3. Keep the `formatStateUsing` decode on the BackOffice editors permanently: the legacy admin screens still single encode on their own saves, so encoded rows reappear whenever someone uses them.

An alternative if the legacy patch is unwanted: a filtered migration that only normalizes rows whose decoded content uses whitelisted tags exclusively (178 of 212 FAQ answers, 14 of 34 articles, all 8 roadmap items as of the sync), leaving the rest encoded. Re-derive all counts at actioning time against a fresh sync; the tag tally script lives in the session that created this ticket and is easy to reconstruct: decode each row, `preg_match_all` for tag names, diff against the whitelist.

## Scope when actioned

- Take a dump of the four columns before rewriting.
- The migration writes to tables the legacy app also writes; it is idempotent by nature (decoding stable content is a no op) but coordinate the legacy whitelist deploy first if the blanket variant is chosen.

# Normalize Entity Encoding Across All Text Columns

Panel: console

The legacy `clean_input` helper runs `htmlspecialchars` on every save, and repeated edits re-encode, so entity encoded text (`&#039;`, `&amp;`, `&quot;`, and worse) is present across the whole schema, not just the FAQ and article content that ticket 006 covered. Scanned against the 2026-08-22 sync on 2026-08-27: 196 text columns contain encoded entities, 82,279 affected values in total, and that excludes seven large log style tables that were skipped for size (`admin_good_logons`, `advancement_cubs`, `advancement_notes`, `advancement_scouts`, `event_competitions_location_logging`, `group_attendance`, `system_user_logging`). The biggest: `group_programs.description` (25,405), `ams_training_courses_annual_bookings.previousCourses` (13,412), `badges_notes.note` (10,631), `group_events.description` (5,094), plus member facing values such as `system_users.phys_address` (362).

This matters to Ssalute directly: Filament escapes output, so stored `&#039;` renders literally in the panels, which members and admins can see today. The legacy pages hide the problem by decoding at render time.

## Approach

`App\Services\LegacyHtmlService` already holds the two building blocks: `decode` (entity decode until stable plus stripslashes, mirroring the legacy display pipeline) and `usesOnlyLegacyWhitelistedTags` (the guard that keeps member facing rendering unchanged where the legacy `strip_tags` whitelist would start applying to decoded tags, see ticket 006 for that analysis). The two shipped migrations (`2026_08_27_120000` and `2026_08_27_130000`) are the pattern: decode, skip whitelist breaking values, idempotent.

Preferred shape per discussion on 2026-08-27: a data fixer in `app:system-fixes` (use the `adding-a-data-fix` skill) rather than one giant migration, because the legacy admin screens keep producing newly encoded rows, so this is a recurring condition, not a one off. The fixer walks a configured list of table and column pairs in chunks and normalizes with the same two guards. Default its enabled toggle to off, as all new fixers do.

## Scope decisions to make when actioned

- Which columns to include. Content and identity columns (descriptions, notes, names, addresses, titles) are the value; log and audit style tables (`system_user_logging`, `notifications_archive`, `admin_good_logons` and friends) are noise and can be excluded outright.
- Columns embedded in URLs (`system_users_forced_logouts.fromURL` and similar) decode safely (`&amp;` in a query string becomes `&`, which is the real URL), but verify nothing compares those strings verbatim.
- Check for legacy code that compares or joins on any included column with literal string equality before normalizing it; a decoded value no longer matches its encoded twin.
- The whitelist guard stays until the legacy `cleanDbOutput` whitelist patch from ticket 006 lands; after that the guard can be dropped and the skipped values picked up.
- Re-derive the scan at actioning time: iterate `information_schema` text columns, count values matching the entity patterns, skip tables above a row threshold. The scan takes about a minute against a local sync.

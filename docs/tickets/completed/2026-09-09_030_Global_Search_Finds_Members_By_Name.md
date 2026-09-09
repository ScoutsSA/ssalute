# Global Search Finds Members By Name

**Priority when actioned:** p6

## Synopsis

The BackOffice global search box matched members on `username` only, because that is the resource's record title attribute and Filament searches nothing else by default. Typing a name such as "John Roux" found nobody. The ticket asked for members to be searchable by name, with results shown as `Name (#id)` and linking to the user's view page.

Filed and worked on 2026-09-09 at the user's request.

## Resolution

- `app/Filament/Admin/Resources/Users/UserResource.php`. `getGloballySearchableAttributes()` returns `first_name`, `surname`, `knownName`, `username` and `idNumber`. Filament's default term splitting is left on, so every word of the query must match one of those columns, which is what makes "John Roux" match first name plus surname. `getGlobalSearchResultTitle()` renders `Name (#id)` (the `name` accessor prefers `knownName` over `first_name`, the same as everywhere else). `getGlobalSearchResultDetails()` adds the username and the home region and group as `Name (#id)`, and `getGlobalSearchEloquentQuery()` eager loads those two relations so a page of 50 results does not lazy load them. `idNumber` was in the feature spec's global search line but had never been implemented.
- `docs/features/01-adult-member-system/technical.md`. The global search line under the user resource now lists the real columns and the splitting behaviour.
- `tests/Feature/Filament/UserGlobalSearchTest.php` (new), see Verification.

## Verification

Run on 2026-09-09 against the MySQL test database with the real legacy schema.

- `tests/Feature/Filament/UserGlobalSearchTest.php`, five tests, green: a two word query returns only the member whose first name and surname both match (two decoys sharing one of the words are excluded); known name and username each find the member; ID number finds the member; a result links to the view page and carries the home region as `Name (#id)` with no group key when the member has no group; the panel's `GlobalSearch` Livewire component lists the member for "Johannes Rouxel".
- Mutation check, restored afterwards: removing `surname` from the searchable attributes reds three of the five tests.
- Full suite green on 2026-09-09: 736 passed, 3 skipped. Re-derive with `php artisan test --compact`, do not trust this line.
- `vendor/bin/duster fix --dirty` run.
- Not verified: performance on the production table. Each word becomes five `LIKE '%word%'` clauses across roughly 60,000 rows, capped at 50 results. The users table search already does this for first name and surname and is not a known problem, but it was not measured.
- Not verified: on production. Nothing here has been deployed.

## Risk assessment

- `LIKE '%term%'` on `idNumber` and `username` cannot use an index. If the search box becomes slow the first lever is dropping `idNumber`, the second is `$shouldSplitGlobalSearchTerms = false`.
- The result details show the username, which is the member's email address, to anyone who can open the BackOffice. That panel is restricted to super users and the users table already shows the same column, so nothing new is exposed.
- Global search across the other resources is unchanged. Only the user resource had its attributes overridden.

## Decisions

- `idNumber` was included because the feature spec listed it and admins reconcile members by it, even though the request only mentioned names.
- `knownName` was included because the name shown everywhere in the app prefers it, so a member displayed as "Jono Rouxel" should be found by "Jono".
- Filed at `p6` (a feature with a clear near term payoff) rather than `p3`, since nothing was wrong with the data or a report, the search was merely narrower than expected.

## Original ticket

# Global Search Finds Members By Name

Module: 02-adult-management
Panel: backoffice

## Problem

The BackOffice global search box only matches members on `username`, because `UserResource` sets `username` as its record title attribute and that is all Filament searches by default. Typing a member's name, for example "John Roux", returns nothing. `SystemUser::name` is an accessor built from `knownName` or `first_name` plus `surname`, so it cannot be searched as a column.

## Scope

- Search members on `first_name`, `surname`, `knownName` and `username`. Filament splits the query into words and requires every word to match some column, so "John Roux" finds first name John, surname Roux.
- Show the result as `Name (#id)` per the BackOffice identifier rule, linking to the user's view page, with the username and home region and group underneath.
- Feature tests for a two word name, known name, username, the result link and the details.

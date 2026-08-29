# Log in via Scouts.Digital

**Priority when actioned:** p6

Panel: holding zone

## Synopsis

Members use the same password across legacy Scouts Digital, Ssalute and the new support assistant. Scouts Digital now issues a short lived signed hand-off token (its `sso-handoff.php`, built for the support assistant), so Ssalute's login page can offer "Log in via Scouts.Digital": the member goes to Scouts Digital, logs in there if they are not already in, and comes back to Ssalute authenticated, landing on the page they were heading to.

## Resolution

Branch `feature/scouts-digital-sso`.

- `App\Auth\SignedSsoToken` and `App\Auth\SsoTokenException`: the verifier, a port of the support assistant's class with the same checks (shape, `hash_equals` on the HMAC SHA256 signature, `exp` in the future, `iat` no older than 60 seconds and not in the future, nonce replay guard through `Cache::add` for the token's remaining lifetime). Issuer agnostic; `forScoutsDigital()` reads `ssalute.scouts_digital_sso_secret`.
- `App\Auth\MemberLandingUrl::for()`: the default tenant's member dashboard, else the holding zone, extracted from the holding zone `Login::authenticate()` override, which now uses it.
- `ScoutsDigitalSsoController` on `GET /sso/scouts-digital` (`throttle:10,1`): 404 while the secret is empty; verifies; loads the member by id and refuses unknown or inactive members explicitly (the provider's `retrieveById()` does not filter on `active`); `Auth::login()` without remember me, session regenerate, `sso.scouts_digital.logged_in`; redirects to a relative `intended` parameter, else the session's `url.intended` from a guest bounce, else `MemberLandingUrl`. Refusals render `sso-refused.blade.php` (403, link to the holding zone login) and log `sso.scouts_digital.rejected` with a one word reason, never the token.
- The button: a second render hook on the holding zone panel (`AUTH_LOGIN_FORM_AFTER`, view `filament/member/scouts-digital-login.blade.php`), rendered only when the secret is configured, linking to `{scouts_digital_url}/sso-handoff.php?app=ssalute`.
- Config `ssalute.scouts_digital_sso_secret` from `SSALUTE_SCOUTS_DIGITAL_SSO_SECRET`; `.env.example` gains it and the previously undocumented `SSALUTE_SCOUTS_DIGITAL_URL`.
- The Scouts Digital side (`sso-handoff.php`, the `SSO_SSALUTE_URL` and `SSO_SSALUTE_SECRET` pair, the return to the endpoint after login) is in that repo on `feature/sso-handoff`, commit a670eea.

## Verification

- `tests/Feature/Auth/ScoutsDigitalSsoTest.php` (10 tests): valid token lands on the tenant dashboard and logs the event; no tenant lands in the holding zone; expired, forged, wrong signature and garbage tokens are 403 with the reason logged and the token absent from the log context; replay refused; inactive and unknown refused with their ids; 404 without a secret; `intended` relative only; a guest bounced from a member page lands back there; the eleventh request in a minute is 429. `HoldingZonePanelTest` gains the button present and absent cases.
- Mutation check: flipping `$user->active !== 1` to `=== 1` in the controller reds `inactive_and_unknown_members_are_refused` and `a_valid_token_logs_the_member_in_and_lands_on_their_dashboard`.
- Full suite on 2026-08-29: 483 tests green (`php artisan test --compact` reports them under PHPUnit's deprecation label, as it does for the whole suite). Duster run.
- Not run: the browser round trip against a local Scouts Digital, and `npm run build` for the new Tailwind classes in the two views (`public/build` is not committed).

## Risk assessment

- No remember cookie on the SSO path, matching the login form with the box unticked; a member who wants to stay logged in uses the form.
- The token is not bound to the browser that started the flow (login CSRF within the 60 second window). Accepted for now; a state cookie set before leaving for Scouts Digital would close it.
- The secret must be identical on both sides and rotated together; a mismatch shows as `bad_signature` in the log and "That link has expired" to the member.

## Decisions

- `MemberLandingUrl` replaces only the login page's copy of the default tenant logic; the same computation in `AdminPanelProvider`, the users resource and `RedirectToValidTenant` is left as is.
- No feature spec change: `docs/features` does not describe the holding zone login.

## Original ticket

# Log in via Scouts.Digital

Panel: holding zone
Background: the support assistant's ticket 097 (its `/sso/scouts-digital` verifier) and Scouts Digital's `sso-handoff.php`.

Add a "Log in via Scouts.Digital" button to the holding zone login page. It sends the member to Scouts Digital's hand-off endpoint with `app=ssalute`; Scouts Digital logs them in if needed and returns them to a new `GET /sso/scouts-digital` here with a signed token, which logs them in and sends them to the page they were heading to or their dashboard.

- Port the support assistant's verifier as is; secret in `config/ssalute.php`.
- Only show the button once the secret is configured.
- Feature tests for the route and the button.

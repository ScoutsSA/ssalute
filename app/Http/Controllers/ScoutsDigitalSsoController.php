<?php

namespace App\Http\Controllers;

use App\Auth\MemberLandingUrl;
use App\Auth\SignedSsoToken;
use App\Auth\SsoTokenException;
use App\Models\SystemUser;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * The landing side of the "Log in via Scouts.Digital" button: Scouts Digital
 * logs the member in over there, mints a signed token and sends them here.
 * Dark (404) until the shared secret is configured.
 */
class ScoutsDigitalSsoController extends Controller
{
    public function __invoke(Request $request): RedirectResponse|Response
    {
        $verifier = SignedSsoToken::forScoutsDigital();

        abort_unless($verifier->isConfigured(), 404);

        try {
            $claims = $verifier->verify((string) $request->query('token', ''));
        } catch (SsoTokenException $exception) {
            return $this->refuse($exception->reason);
        }

        $user = SystemUser::query()->find($claims['uid']);

        if (! $user instanceof SystemUser) {
            return $this->refuse('unknown_member', $claims['uid']);
        }

        if ($user->active !== 1) {
            return $this->refuse('inactive_member', $user->id);
        }

        Auth::login($user);
        $request->session()->regenerate();

        Log::info('sso.scouts_digital.logged_in', ['user_id' => $user->id]);

        $intended = $this->relativeIntended($request->query('intended'));

        if ($intended === null) {
            return redirect(session()->pull('url.intended', MemberLandingUrl::for($user)));
        }

        $request->session()->forget('url.intended');

        return redirect($intended);
    }

    /**
     * Only a path on this host is honoured, never a full URL or a protocol
     * relative one, so the issuer cannot bounce a member elsewhere.
     */
    protected function relativeIntended(mixed $intended): ?string
    {
        if (! is_string($intended)) {
            return null;
        }

        if ($intended === '' || strlen($intended) > 2000) {
            return null;
        }

        if (! str_starts_with($intended, '/')) {
            return null;
        }

        if (str_starts_with($intended, '//') || str_starts_with($intended, '/\\')) {
            return null;
        }

        return $intended;
    }

    protected function refuse(string $reason, ?int $userId = null): Response
    {
        Log::warning('sso.scouts_digital.rejected', array_filter([
            'reason' => $reason,
            'user_id' => $userId,
        ]));

        return response()->view('sso-refused', ['loginUrl' => Filament::getPanel('holding-zone')->getLoginUrl()], 403);
    }
}

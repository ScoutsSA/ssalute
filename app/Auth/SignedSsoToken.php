<?php

namespace App\Auth;

use Illuminate\Support\Facades\Cache;

/**
 * Verifies the short lived signed hand-off token legacy Scouts Digital issues
 * from its sso-handoff.php so a member can log in here without a password
 * crossing the wire. The token is `{payloadB64url}.{hexSignature}` where the
 * payload is JSON {"uid", "iat", "exp", "nonce"} and the signature is HMAC
 * SHA256 over the encoded payload with the shared secret. The same class,
 * with the same checks, lives in the support bot.
 */
class SignedSsoToken
{
    public const SCOUTS_DIGITAL = 'scouts-digital';

    public function __construct(
        public readonly string $issuer,
        protected string $secret,
        protected int $maxAgeSeconds = 60,
    ) {}

    public static function forScoutsDigital(): self
    {
        return new self(self::SCOUTS_DIGITAL, (string) config('ssalute.scouts_digital_sso_secret'));
    }

    public function isConfigured(): bool
    {
        return $this->secret !== '';
    }

    /**
     * Checks shape, signature, expiry, age and replay, in that order, and
     * returns the claims. Every failure throws with a one word reason.
     *
     * @return array{
     *     uid: int,
     *     iat: int,
     *     exp: int,
     *     nonce: string
     * }
     */
    public function verify(string $token): array
    {
        if (! $this->isConfigured()) {
            throw new SsoTokenException('unconfigured');
        }

        $parts = explode('.', $token);

        if (count($parts) !== 2) {
            throw new SsoTokenException('malformed');
        }

        [$payload, $signature] = $parts;

        if ($payload === '' || $signature === '') {
            throw new SsoTokenException('malformed');
        }

        $expected = hash_hmac('sha256', $payload, $this->secret);

        if (! hash_equals($expected, strtolower($signature))) {
            throw new SsoTokenException('bad_signature');
        }

        $claims = $this->decodeClaims($payload);

        $now = now()->getTimestamp();

        if ($claims['exp'] <= $now) {
            throw new SsoTokenException('expired');
        }

        if ($claims['iat'] < $now - $this->maxAgeSeconds || $claims['iat'] > $now + 5) {
            throw new SsoTokenException('stale');
        }

        $lifetime = max(1, min($claims['exp'] - $now, $this->maxAgeSeconds)) + 5;

        if (! Cache::add($this->nonceKey($claims['nonce']), true, $lifetime)) {
            throw new SsoTokenException('replayed');
        }

        return $claims;
    }

    /**
     * Builds a token the way the issuer does. Used by the tests and handy
     * for trying the route by hand; production tokens come from Scouts Digital.
     *
     * @param  array{uid: int, iat?: int, exp?: int, nonce?: string}  $claims
     */
    public function issue(array $claims): string
    {
        $now = now()->getTimestamp();

        $payload = rtrim(strtr(base64_encode(json_encode([
            'uid' => $claims['uid'],
            'iat' => $claims['iat'] ?? $now,
            'exp' => $claims['exp'] ?? $now + $this->maxAgeSeconds,
            'nonce' => $claims['nonce'] ?? bin2hex(random_bytes(16)),
        ], JSON_THROW_ON_ERROR)), '+/', '-_'), '=');

        return "{$payload}." . hash_hmac('sha256', $payload, $this->secret);
    }

    /**
     * @return array{
     *     uid: int,
     *     iat: int,
     *     exp: int,
     *     nonce: string
     * }
     */
    protected function decodeClaims(string $payload): array
    {
        $decoded = base64_decode(strtr($payload, '-_', '+/'), true);
        $claims = is_string($decoded) ? json_decode($decoded, true) : null;

        if (! is_array($claims)) {
            throw new SsoTokenException('malformed');
        }

        if (! is_int($claims['uid'] ?? null) || $claims['uid'] <= 0) {
            throw new SsoTokenException('malformed');
        }

        if (! is_int($claims['iat'] ?? null) || ! is_int($claims['exp'] ?? null)) {
            throw new SsoTokenException('malformed');
        }

        if (! is_string($claims['nonce'] ?? null) || $claims['nonce'] === '' || strlen($claims['nonce']) > 64) {
            throw new SsoTokenException('malformed');
        }

        return [
            'uid' => $claims['uid'],
            'iat' => $claims['iat'],
            'exp' => $claims['exp'],
            'nonce' => $claims['nonce'],
        ];
    }

    protected function nonceKey(string $nonce): string
    {
        return "sso:{$this->issuer}:nonce:" . hash('sha256', $nonce);
    }
}

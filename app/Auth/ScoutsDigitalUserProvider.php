<?php

namespace App\Auth;

use App\Models\SystemUser;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\UserProvider as UserProviderContract;

class ScoutsDigitalUserProvider implements UserProviderContract
{
    public function __construct(
        protected string $model = SystemUser::class,
    ) {}

    /**
     * Laravel 12 adds this hook to allow rehashing. Not applicable for AES-DB passwords.
     */
    public function rehashPasswordIfRequired(AuthenticatableContract $user, array $credentials, bool $force = false): void
    {
        // No-op: Passwords are stored encrypted at the DB level and are not hashed application-side.
    }

    public function retrieveById($identifier): ?AuthenticatableContract
    {
        /** @var SystemUser $model */
        $model = new $this->model;

        return $model->newQuery()->find($identifier);
    }

    public function retrieveByToken($identifier, $token): ?AuthenticatableContract
    {
        /** @var SystemUser $model */
        $model = new $this->model;

        return $model->newQuery()
            ->where($model->getAuthIdentifierName(), $identifier)
            ->where($model->getRememberTokenName(), $token)
            ->first();
    }

    public function updateRememberToken(AuthenticatableContract $user, $token): void
    {
        $user->setRememberToken($token);
        $user->save();
    }

    public function retrieveByCredentials(array $credentials): ?AuthenticatableContract
    {
        // Require a password to be present for lookup-by-encrypted-match
        if (! isset($credentials['password'])) {
            return null;
        }

        /** @var SystemUser $model */
        $model = new $this->model;
        $query = $model->newQuery();

        // Prefer an explicit username; otherwise, fall back to the model's auth identifier name.
        if (isset($credentials['username'])) {
            $query->where('username', $credentials['username']);
        } else {
            $identifierName = $model->getAuthIdentifierName();
            if (isset($credentials[$identifierName])) {
                $query->where($identifierName, $credentials[$identifierName]);
            }
        }

        // Optionally enforce active users only, if scope exists
        if (method_exists($model, 'scopeActive')) {
            $query->active();
        }

        // Match against the encrypted value at the DB level so no decryption/comparison happens in PHP
        $key = config('auth.scouts_digital.authentication.encryption_key');
        $plain = (string) $credentials['password'];
        $query->whereRaw('passwordNew = AES_ENCRYPT(?, ?)', [$plain, $key]);

        return $query->first();
    }

    public function validateCredentials(AuthenticatableContract $user, array $credentials): bool
    {
        $plain = (string) ($credentials['password'] ?? '');
        if ($plain === '') {
            return false;
        }

        $key = config('auth.scouts_digital.authentication.encryption_key');

        /** @var SystemUser $model */
        $model = new $this->model;

        // Check the currently-authenticated user's row:
        return $model->newQuery()
            ->whereKey($user->getAuthIdentifier())
            ->whereRaw('passwordNew = AES_ENCRYPT(?, ?)', [$plain, $key])
            ->exists();
    }
}

<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class CurrentPasswordUsingAuthProvider implements ValidationRule
{
    public function __construct(private string $guard = 'web') {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $guard = Auth::guard($this->guard);
        $user = $guard->user();

        if (! $user || ! $guard->getProvider()->validateCredentials($user, ['password' => $value])) {
            $fail('The provided password does not match your current password.');
        }
    }
}

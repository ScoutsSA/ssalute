<?php

namespace App\Auth;

use RuntimeException;

/**
 * A hand-off token that must not log anyone in. The reason is a short
 * machine word for the log line; the token itself is never logged.
 */
class SsoTokenException extends RuntimeException
{
    public function __construct(public readonly string $reason)
    {
        parent::__construct("SSO token rejected: {$reason}");
    }
}

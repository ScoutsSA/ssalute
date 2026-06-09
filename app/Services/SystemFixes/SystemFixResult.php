<?php

namespace App\Services\SystemFixes;

class SystemFixResult
{
    /**
     * @param  string  $fix  Human-readable name of the fix that produced this result.
     * @param  string  $summary  One-line summary of what the fix did (or did not) change. Logged, never the body of a Slack alert.
     * @param  list<string>  $changes  One human-readable line per data change that was made.
     * @param  list<string>  $attentions  One line per issue the fix could not resolve and that needs an admin to act.
     */
    public function __construct(
        public readonly string $fix,
        public readonly string $summary,
        public readonly array $changes = [],
        public readonly array $attentions = [],
    ) {}

    public function hasChanges(): bool
    {
        return $this->changes !== [];
    }

    public function needsAttention(): bool
    {
        return $this->attentions !== [];
    }

    /**
     * Whether this result warrants an alert: a Slack message should only be sent
     * when data was changed or something needs an admin's attention.
     */
    public function shouldNotify(): bool
    {
        return $this->hasChanges() || $this->needsAttention();
    }
}

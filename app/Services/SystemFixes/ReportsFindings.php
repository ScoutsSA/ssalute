<?php

namespace App\Services\SystemFixes;

use Illuminate\Support\Collection;

/**
 * A fix that can list what it found without changing anything.
 *
 * The fix's page in the Data Fixes cluster calls findings() directly, so an admin sees what is
 * true when they open the page rather than whatever the last nightly run happened to store. A
 * finding somebody has already fixed disappears on refresh, and a fix's findings live in exactly
 * one place: the fix.
 *
 * Implementations must not write — and that includes logging. The page calls findings() on every
 * load, so a log line per finding would put 76 warnings in the log each time somebody looked at a
 * list. What a nightly run saw is already recorded by RunSystemFixes in `system_fix.completed`,
 * which carries every attention line; there is nothing for a finding builder to add.
 *
 * run() may call findings() to build its own report; findings() must never call run().
 */
interface ReportsFindings
{
    /**
     * @return Collection<int, SystemFixFinding>
     */
    public function findings(): Collection;

    /**
     * The page where these findings can be actioned. Used by the Slack alert, which carries only
     * a count and this link.
     */
    public function findingsUrl(): ?string;
}

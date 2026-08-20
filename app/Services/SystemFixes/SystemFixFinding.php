<?php

namespace App\Services\SystemFixes;

/**
 * One thing a fix found that it will not change on its own, and that somebody has to act on.
 *
 * A finding is deliberately record-shaped rather than summary-shaped: an admin cannot act on
 * "204 rows", only on a member they can open. Where the record has an admin surface, `url` points
 * straight at it; where it does not, `url` is null and the finding is informational.
 */
class SystemFixFinding
{
    /**
     * @param  string  $title  Short statement of what is wrong. Shown as the row's heading.
     * @param  string  $detail  The specifics: which column, which value.
     * @param  string|null  $url  Where the finding can be actioned, if there is such a place.
     * @param  string|null  $linkLabel  Wording for the link, e.g. "Edit member".
     * @param  string|null  $group  Heading the finding is filed under on the page.
     * @param  int|string|null  $recordId  The record this is about, so a page action can act on it
     *                                     in place rather than sending the admin elsewhere.
     * @param  string|null  $badge  The offending value, shown as its own column so 200 rows of the
     *                              same problem stay scannable.
     */
    public function __construct(
        public readonly string $title,
        public readonly string $detail,
        public readonly ?string $url = null,
        public readonly ?string $linkLabel = null,
        public readonly ?string $group = null,
        public readonly int|string|null $recordId = null,
        public readonly ?string $badge = null,
    ) {}

    /**
     * The one-line form used in logs and in a Slack body, where there is nothing to click.
     */
    public function toLine(): string
    {
        return trim("{$this->title} — {$this->detail}");
    }
}

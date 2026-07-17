<?php

namespace App\Sync\Anonymizers;

use App\Sync\Anonymizers\Concerns\ScrubsColumns;

/**
 * Scrubs `system_users_email_verifications`, which stores every real member email
 * address alongside the raw text of the verification messages exchanged. Each
 * address is replaced with a deterministic fake tied to the member, and the stored
 * message bodies and headings are blanked so no correspondence survives locally.
 */
class AnonymizeSystemUserEmailVerifications
{
    use ScrubsColumns;

    public function __invoke(string $connection): void
    {
        $this->perRowScrub(
            $connection,
            'system_users_email_verifications',
            ['emailAddress', 'response', 'responseHeading', 'subjectReceivedBack', 'messageReceivedBack'],
            fn (string $column, object $row): string => $column === 'emailAddress'
                ? 'member' . ((int) ($row->userID ?? $row->id)) . '@example.test'
                : '',
        );
    }
}

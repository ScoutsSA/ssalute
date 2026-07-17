<?php

namespace App\Sync\Anonymizers;

use App\Sync\Anonymizers\Concerns\ScrubsColumns;

/**
 * Wipes the login and credential audit trails: the good/bad logon histories (which
 * record usernames and the passwords that were attempted) and the log of passwords
 * that were emailed to members. These tables are large and need no per-row
 * uniqueness, so each is cleared with a single bulk UPDATE.
 */
class AnonymizeLoginHistory
{
    use ScrubsColumns;

    public function __invoke(string $connection): void
    {
        $this->bulkScrub($connection, 'admin_good_logons', ['username' => 'redacted', 'password' => '']);
        $this->bulkScrub($connection, 'admin_bad_logons', ['username' => 'redacted', 'password' => '']);
        $this->bulkScrub($connection, 'system_users_passwords_emailed', ['username' => 'redacted', 'emailed' => '']);
    }
}

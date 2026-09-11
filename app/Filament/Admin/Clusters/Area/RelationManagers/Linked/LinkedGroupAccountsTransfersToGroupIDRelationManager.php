<?php

namespace App\Filament\Admin\Clusters\Area\RelationManagers\Linked;

/**
 * Generated from AreaReferenceMap. Do not edit by hand.
 */
final class LinkedGroupAccountsTransfersToGroupIDRelationManager extends LinkedRecordsRelationManager
{
    protected static string $relationship = 'linkedGroupAccountsTransfersToGroupID';

    protected static string $linkedTable = 'group_accounts_transfers';

    protected static ?string $title = 'Group Accounts Transfers (to group)';
}

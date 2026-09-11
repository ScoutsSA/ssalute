<?php

namespace App\Filament\Admin\Clusters\Area\RelationManagers\Linked;

/**
 * Generated from AreaReferenceMap. Do not edit by hand.
 */
final class LinkedSystemUsersRelationManager extends LinkedRecordsRelationManager
{
    protected static string $relationship = 'linkedSystemUsers';

    protected static string $linkedTable = 'system_users';

    protected static ?string $title = 'Users (home area)';
}

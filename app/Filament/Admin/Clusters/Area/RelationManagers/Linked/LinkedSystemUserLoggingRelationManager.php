<?php

namespace App\Filament\Admin\Clusters\Area\RelationManagers\Linked;

/**
 * Generated from AreaReferenceMap. Do not edit by hand.
 */
final class LinkedSystemUserLoggingRelationManager extends LinkedRecordsRelationManager
{
    protected static string $relationship = 'linkedSystemUserLogging';

    protected static string $linkedTable = 'system_user_logging';

    protected static ?string $title = 'User activity log';
}

<?php

namespace App\Filament\Admin\Clusters\Area\RelationManagers\Linked;

/**
 * Generated from AreaReferenceMap. Do not edit by hand.
 */
final class LinkedErrorLoggingRelationManager extends LinkedRecordsRelationManager
{
    protected static string $relationship = 'linkedErrorLogging';

    protected static string $linkedTable = 'error_logging';

    protected static ?string $title = 'Error log entries';
}

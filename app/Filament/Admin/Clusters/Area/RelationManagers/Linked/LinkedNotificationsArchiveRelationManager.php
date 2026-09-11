<?php

namespace App\Filament\Admin\Clusters\Area\RelationManagers\Linked;

/**
 * Generated from AreaReferenceMap. Do not edit by hand.
 */
final class LinkedNotificationsArchiveRelationManager extends LinkedRecordsRelationManager
{
    protected static string $relationship = 'linkedNotificationsArchive';

    protected static string $linkedTable = 'notifications_archive';

    protected static ?string $title = 'Archived notifications';
}

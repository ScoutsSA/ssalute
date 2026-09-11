<?php

namespace App\Filament\Admin\Clusters\Area\Schemas;

use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Services\Areas\AreaDeletionGuard;
use App\Services\Areas\AreaReferenceMap;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;

/**
 * Infolist section listing every table that references the record, which is also what blocks its deletion.
 */
class LinkedRecordsSection
{
    public static function make(): Section
    {
        return Section::make('Linked records')
            ->description('Rows in other tables that reference this record. While any exist the record cannot be deleted. Each table is also a tab below.')
            ->collapsible()
            ->schema([
                TextEntry::make('linkedRecords')
                    ->hiddenLabel()
                    ->badge()
                    ->color('warning')
                    ->placeholder('No linked records. This record can be deleted.')
                    ->state(function (Region|District|Group $record): array {
                        $blockers = resolve(AreaDeletionGuard::class)->blockersFor($record);

                        $lines = [];

                        foreach ($blockers as $table => $count) {
                            $lines[] = AreaReferenceMap::label($table) . ": {$count}";
                        }

                        return $lines;
                    }),
            ]);
    }
}

<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\RoverMeetingTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\RoverMeetingTypes\RoverMeetingTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRoverMeetingTypes extends ManageRecords
{
    protected static string $resource = RoverMeetingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

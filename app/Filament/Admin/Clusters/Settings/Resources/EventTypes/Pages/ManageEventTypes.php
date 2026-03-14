<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\EventTypes\Pages;

use App\Filament\Admin\Clusters\Settings\Resources\EventTypes\EventTypeResource;
use App\Models\SystemGroupEventType;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageEventTypes extends ManageRecords
{
    protected static string $resource = EventTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $data['position'] = (SystemGroupEventType::max('position') ?? 0) + 1;

                    return $data;
                }),
        ];
    }
}

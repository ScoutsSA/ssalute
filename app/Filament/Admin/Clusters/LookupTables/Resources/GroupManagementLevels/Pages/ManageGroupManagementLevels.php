<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\GroupManagementLevels\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\GroupManagementLevels\GroupManagementLevelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageGroupManagementLevels extends ManageRecords
{
    protected static string $resource = GroupManagementLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $data['created'] = now();
                    $data['createdby'] = auth()->id() ?? 1;

                    return $data;
                }),
        ];
    }
}

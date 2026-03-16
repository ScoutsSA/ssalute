<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\AwardHeadings\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\AwardHeadings\AwardHeadingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAwardHeadings extends ManageRecords
{
    protected static string $resource = AwardHeadingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

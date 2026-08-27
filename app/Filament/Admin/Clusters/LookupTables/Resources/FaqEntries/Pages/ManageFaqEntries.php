<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\FaqEntries\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\FaqEntries\FaqEntryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Width;

class ManageFaqEntries extends ManageRecords
{
    protected static string $resource = FaqEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth(Width::SevenExtraLarge),
        ];
    }
}

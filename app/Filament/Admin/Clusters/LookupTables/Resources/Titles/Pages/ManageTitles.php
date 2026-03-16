<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\Titles\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\Titles\TitleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTitles extends ManageRecords
{
    protected static string $resource = TitleResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

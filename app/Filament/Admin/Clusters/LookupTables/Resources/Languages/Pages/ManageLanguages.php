<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\Languages\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\Languages\LanguageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageLanguages extends ManageRecords
{
    protected static string $resource = LanguageResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ProgramTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\ProgramTypes\ProgramTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageProgramTypes extends ManageRecords
{
    protected static string $resource = ProgramTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

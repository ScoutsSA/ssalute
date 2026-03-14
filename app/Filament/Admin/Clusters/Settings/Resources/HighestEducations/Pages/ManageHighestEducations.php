<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\HighestEducations\Pages;

use App\Filament\Admin\Clusters\Settings\Resources\HighestEducations\HighestEducationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageHighestEducations extends ManageRecords
{
    protected static string $resource = HighestEducationResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\Pages;

use App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\PoliceClearanceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPoliceClearance extends ViewRecord
{
    protected static string $resource = PoliceClearanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

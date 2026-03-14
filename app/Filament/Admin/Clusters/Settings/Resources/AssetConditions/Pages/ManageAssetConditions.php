<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\AssetConditions\Pages;

use App\Filament\Admin\Clusters\Settings\Resources\AssetConditions\AssetConditionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAssetConditions extends ManageRecords
{
    protected static string $resource = AssetConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

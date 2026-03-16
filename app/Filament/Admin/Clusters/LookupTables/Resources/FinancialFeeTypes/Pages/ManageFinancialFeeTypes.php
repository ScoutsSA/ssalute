<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\FinancialFeeTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\FinancialFeeTypes\FinancialFeeTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageFinancialFeeTypes extends ManageRecords
{
    protected static string $resource = FinancialFeeTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

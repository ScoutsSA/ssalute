<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\CompetitionJudgeTypes\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\CompetitionJudgeTypes\CompetitionJudgeTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCompetitionJudgeTypes extends ManageRecords
{
    protected static string $resource = CompetitionJudgeTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

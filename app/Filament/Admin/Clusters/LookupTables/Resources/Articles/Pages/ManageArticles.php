<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\Articles\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\Articles\ArticleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Width;

class ManageArticles extends ManageRecords
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth(Width::SevenExtraLarge)
                ->mutateDataUsing(function (array $data): array {
                    $data['created'] = now();
                    $data['createdby'] = (string) (auth()->id() ?? 1);

                    return $data;
                }),
        ];
    }
}

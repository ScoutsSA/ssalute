<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ArticleCategories\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\ArticleCategories\ArticleCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageArticleCategories extends ManageRecords
{
    protected static string $resource = ArticleCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

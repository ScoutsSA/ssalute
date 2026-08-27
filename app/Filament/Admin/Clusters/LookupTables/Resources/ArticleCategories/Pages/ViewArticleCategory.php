<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\ArticleCategories\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\ArticleCategories\ArticleCategoryResource;
use Filament\Resources\Pages\ViewRecord;

class ViewArticleCategory extends ViewRecord
{
    protected static string $resource = ArticleCategoryResource::class;
}

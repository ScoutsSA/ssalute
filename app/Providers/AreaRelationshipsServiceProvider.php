<?php

namespace App\Providers;

use App\Filament\Admin\Clusters\Area\RelationManagers\Linked\LinkedRelationManagers;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Services\Areas\AreaReferenceMap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\ServiceProvider;

/**
 * Registers a hasMany relationship on Region, District and Group for every blocking table that references them,
 * driven by AreaReferenceMap, so the linked record tabs and the delete guard share one source of truth. The non
 * blocking log tables get no relationship, matching the tabs.
 */
class AreaRelationshipsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        foreach ([Region::class, District::class, Group::class] as $modelClass) {
            $this->registerRelationships($modelClass);
        }
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    private function registerRelationships(string $modelClass): void
    {
        foreach (AreaReferenceMap::canonicalFor($modelClass) as $table => $columns) {
            foreach ($columns as $column) {
                $this->registerRelationship($modelClass, $table, $column, LinkedRelationManagers::relationshipName($table));
            }
        }

        foreach (AreaReferenceMap::extraFor($modelClass) as $table => $columns) {
            foreach ($columns as $column) {
                $this->registerRelationship($modelClass, $table, $column, LinkedRelationManagers::relationshipName($table, $column));
            }
        }
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    private function registerRelationship(string $modelClass, string $table, string $column, string $name): void
    {
        $relatedClass = AreaReferenceMap::modelFor($table);

        if ($relatedClass === null || ! AreaReferenceMap::isBlocking($table)) {
            return;
        }

        $modelClass::resolveRelationUsing(
            $name,
            fn (Model $model): HasMany => $model->hasMany($relatedClass, $column, 'id'),
        );
    }
}

<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Adds support for automatically setting the `createdby` column, if it exists on the model's table.
 */
trait MightHaveCreatedBy
{
    /**
     * Boot the trait.
     */
    public static function bootMightHaveCreatedBy(): void
    {
        static::creating(static function (Model $model): void {
            if (! static::hasCreatedBy($model)) {
                return;
            }

            $userId = Auth::id();

            if ($userId !== null && ! $model->isDirty('createdby')) {
                $model->setAttribute('createdby', $userId);
            }
        });
    }

    /**
     * Determine if the model's table has a `createdby` column.
     */
    protected static function hasCreatedBy(Model $model): bool
    {
        return in_array('createdby', $model->fillable ?? [], true);
    }
}

<?php

namespace App\Models\Concerns;

use App\Services\Areas\AreaDeletionGuard;
use Illuminate\Database\Eloquent\Model;

/**
 * Hard stop for area deletion: throws AreaStillReferencedException while any table references the record.
 */
trait PreventsDeletionWhenReferenced
{
    public static function bootPreventsDeletionWhenReferenced(): void
    {
        static::deleting(static function (Model $model): void {
            $guard = resolve(AreaDeletionGuard::class);
            $guard->forget($model);
            $guard->assertDeletable($model);
        });
    }
}

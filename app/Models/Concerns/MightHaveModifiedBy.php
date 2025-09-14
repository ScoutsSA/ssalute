<?php

namespace App\Models\Concerns;

use App\Models\SystemUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * Adds support for automatically setting the `modifiedby` column, if it exists on the model's table.
 */
trait MightHaveModifiedBy
{
    /**
     * Boot the trait.
     */
    public static function bootMightHaveModifiedBy(): void
    {
        // Use saving to cover both creating and updating events.
        static::saving(static function (Model $model): void {
            if (! static::hasModifiedBy($model)) {
                return;
            }

            $userId = Auth::id();

            if ($userId !== null && ! $model->isDirty('modifiedby')) {
                $model->setAttribute('modifiedby', $userId);
            }
        });
    }

    /**
     * Determine if the model's table has a `modifiedby` column.
     */
    protected static function hasModifiedBy(Model $model): bool
    {
        return in_array('modifiedby', $model->fillable ?? [], true);
    }

    public function modifiedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'modifiedby');
    }
}

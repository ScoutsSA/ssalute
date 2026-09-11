<?php

namespace App\Models\Concerns;

use App\Services\Areas\AreaDeletionGuard;
use Illuminate\Database\Eloquent\Model;

/**
 * Hard stop for area deletion: delete() throws AreaStillReferencedException while any table references the record.
 *
 * forceDeleteWhileReferenced() bypasses the stop for an admin who has been shown the consequences. It removes
 * only this record; the referencing rows are neither deleted nor changed and keep pointing at the missing id.
 */
trait PreventsDeletionWhenReferenced
{
    protected bool $deletingWhileReferenced = false;

    public static function bootPreventsDeletionWhenReferenced(): void
    {
        static::deleting(static function (Model $model): void {
            if ($model->deletingWhileReferenced) {
                return;
            }

            $guard = resolve(AreaDeletionGuard::class);
            $guard->forget($model);
            $guard->assertDeletable($model);
        });
    }

    public function forceDeleteWhileReferenced(): ?bool
    {
        $this->deletingWhileReferenced = true;

        try {
            return $this->delete();
        } finally {
            $this->deletingWhileReferenced = false;
        }
    }
}

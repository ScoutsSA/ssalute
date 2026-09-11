<?php

namespace App\Exceptions;

use App\Services\Areas\AreaDeletionGuard;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class AreaStillReferencedException extends RuntimeException
{
    /**
     * @param  array<string, int>  $blockers
     */
    public static function for(Model $record, array $blockers): self
    {
        $label = class_basename($record);
        $name = $record->getAttribute('name');
        $description = AreaDeletionGuard::describe($blockers);

        return new self("{$label} {$name} (#{$record->getKey()}) cannot be deleted while records reference it: {$description}.");
    }
}

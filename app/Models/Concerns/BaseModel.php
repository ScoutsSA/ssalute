<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * BaseModel for application Eloquent models.
 *
 * - Uses `created` / `modified` as timestamp columns.
 * - Automatically sets `createdby` and `modifiedby` columns when present.
 */
abstract class BaseModel extends Model
{
    use MightHaveCreatedBy;
    use MightHaveModifiedBy;

    public function getCreatedAtColumn(): ?string
    {
        return array_key_exists('created', $this->getCasts() ?? []) ? 'created' : null;
    }

    public function getUpdatedAtColumn(): ?string
    {
        return array_key_exists('modified', $this->getCasts() ?? []) ? 'modified' : null;
    }
}

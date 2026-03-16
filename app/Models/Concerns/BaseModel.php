<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * BaseModel for application Eloquent models.
 *
 * - Uses `created` / `modified` as timestamp columns.
 * - Automatically sets `createdby` and `modifiedby` columns when present.
 * - Auditable: all changes are tracked in the ssalute_audits table.
 */
abstract class BaseModel extends Model implements Auditable
{
    use HasFactory;
    use IsAuditable;
    use MightHaveCreatedBy;
    use MightHaveModifiedBy;

    public function setAttribute($key, $value): static
    {
        if (is_null($value) && $this->hasCast($key, ['string'])) {
            $value = '';
        }

        return parent::setAttribute($key, $value);
    }

    public function getCreatedAtColumn(): ?string
    {
        return array_key_exists('created', $this->getCasts() ?? []) ? 'created' : null;
    }

    public function getUpdatedAtColumn(): ?string
    {
        return array_key_exists('modified', $this->getCasts() ?? []) ? 'modified' : null;
    }
}

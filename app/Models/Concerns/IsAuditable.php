<?php

namespace App\Models\Concerns;

use App\Models\Audit;
use OwenIt\Auditing\Auditable;

trait IsAuditable
{
    use Auditable;

    public function getAuditExclude(): array
    {
        return array_merge(
            config('audit.exclude', []),
            $this->auditExclude ?? [],
        );
    }

    public function resolveAuditImplementation(): string
    {
        return Audit::class;
    }
}

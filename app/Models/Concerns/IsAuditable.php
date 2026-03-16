<?php

namespace App\Models\Concerns;

use App\Models\Audit;
use OwenIt\Auditing\Auditable;
use STS\FilamentImpersonate\Facades\Impersonation;

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

    public function generateTags(): array
    {
        if (Impersonation::isImpersonating()) {
            $impersonatorId = Impersonation::getImpersonatorId();

            return ["impersonated_by:{$impersonatorId}"];
        }

        return [];
    }
}

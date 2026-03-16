<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Models\Audit as BaseAudit;

class Audit extends BaseAudit
{
    protected $connection = AppServiceProvider::DB_SD_CORE;

    protected $table = 'ssalute_audits';

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'user_id');
    }
}

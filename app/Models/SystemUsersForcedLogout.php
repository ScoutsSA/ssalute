<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemUsersForcedLogout extends BaseModel
{
    public $timestamps = false;

    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_users_forced_logouts';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'date' => 'datetime',
        'userID' => 'int',
        'fromURL' => 'string',
        'toURL' => 'string',
        'IPAddress' => 'string',
        'extended' => 'string',
        'userAgent' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }
}

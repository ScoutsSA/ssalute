<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemBadgeScoutsToBadge extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_badge_scouts_to_badge';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'badgeID' => 'int',
        'toBadgeTaskID' => 'int',
        'active' => 'int',
    ];

}

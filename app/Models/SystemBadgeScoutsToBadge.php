<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemBadgeScoutsToBadge extends Model
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

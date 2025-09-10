<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemAdvancementScoutsSecondEntshaBadge extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_scouts_second_entsha_badges';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'taskID' => 'int',
        'badgeID' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupEventsAttending extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_events_attending';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'groupID' => 'int',
        'eventID' => 'int',
        'userID' => 'int',
        'roleID' => 'int',
        'attending' => 'int',
        'cost' => 'float',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

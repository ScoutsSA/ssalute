<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class EventUserBooking extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_user_booking';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'status' => 'int',
        'userID' => 'int',
        'travelArrangements' => 'int',
        'accommodationArrangements' => 'int',
        'apparelOption' => 'int',
        'patrolID' => 'int',
        'canAdmin' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

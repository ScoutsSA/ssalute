<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupAttendance extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_attendance';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userId' => 'int',
        'userSex' => 'string',
        'type' => 'string',
        'programId' => 'int',
        'eventId' => 'int',
        'programDate' => 'date',
        'assocToGroup' => 'int',
        'attendance' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'moved' => 'int',
    ];

}

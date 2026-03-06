<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupAttendance extends BaseModel
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userId');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'assocToGroup');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(GroupProgram::class, 'programId');
    }
}

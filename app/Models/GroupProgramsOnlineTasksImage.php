<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupProgramsOnlineTasksImage extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_programs_online_tasks_images';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programID' => 'int',
        'taskID' => 'int',
        'userID' => 'int',
        'description' => 'string',
        'location' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(GroupProgramsOnlineTask::class, 'taskID');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(GroupProgram::class, 'programID');
    }
}

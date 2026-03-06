<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupRoversPatrolName extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_rovers_patrol_names';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToGroup' => 'int',
        'crewID' => 'int',
        'name' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'assocToGroup');
    }

    public function crew(): BelongsTo
    {
        return $this->belongsTo(GroupRoverCrew::class, 'crewID');
    }
}

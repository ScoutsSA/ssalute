<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupBadgesInProgram extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_badges_in_programs';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToGroup' => 'int',
        'scoutProgramTypeID' => 'int',
        'type' => 'string',
        'programID' => 'int',
        'firstID' => 'int',
        'secondID' => 'int',
        'thirdID' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'assocToGroup');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(GroupProgram::class, 'programID');
    }

    public function scoutProgramType(): BelongsTo
    {
        return $this->belongsTo(SystemProgramTypesScout::class, 'scoutProgramTypeID');
    }
}

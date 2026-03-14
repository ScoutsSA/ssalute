<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StarAwardsNote extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'star_awards_notes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'groupID' => 'int',
        'denID' => 'int',
        'packID' => 'int',
        'troopID' => 'int',
        'patrolID' => 'int',
        'crewID' => 'int',
        'noteType' => 'int',
        'note' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'groupID');
    }

    public function den(): BelongsTo
    {
        return $this->belongsTo(GroupMeerkatDen::class, 'denID');
    }

    public function pack(): BelongsTo
    {
        return $this->belongsTo(GroupCubPack::class, 'packID');
    }

    public function troop(): BelongsTo
    {
        return $this->belongsTo(GroupScoutTroop::class, 'troopID');
    }

    public function patrol(): BelongsTo
    {
        return $this->belongsTo(GroupScoutsPatrolName::class, 'patrolID');
    }

    public function crew(): BelongsTo
    {
        return $this->belongsTo(GroupRoverCrew::class, 'crewID');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JamboreeTroopPatrolAllocation extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_troop_patrol_allocations';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'troopID' => 'int',
        'patrolID' => 'int',
        'roleID' => 'int',
        'active' => 'int',
        'notes' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function troop(): BelongsTo
    {
        return $this->belongsTo(JamboreeTroop::class, 'troopID');
    }

    public function patrol(): BelongsTo
    {
        return $this->belongsTo(JamboreePatrol::class, 'patrolID');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(JamboreeAdultRole::class, 'roleID');
    }
}

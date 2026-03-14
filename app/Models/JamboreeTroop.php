<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JamboreeTroop extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_troops';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'name' => 'string',
        'subCampID' => 'int',
        'colour' => 'string',
        'active' => 'int',
    ];

    public function subCamp(): BelongsTo
    {
        return $this->belongsTo(JamboreeSubCamp::class, 'subCampID');
    }

    public function patrols(): HasMany
    {
        return $this->hasMany(JamboreePatrol::class, 'troopID', 'id');
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(JamboreeTroopPatrolAllocation::class, 'troopID', 'id');
    }
}

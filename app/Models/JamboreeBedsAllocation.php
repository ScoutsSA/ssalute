<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JamboreeBedsAllocation extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_beds_allocations';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'subcampID' => 'int',
        'troopID' => 'int',
        'patrolID' => 'int',
        'bedID' => 'int',
        'active' => 'int',
    ];

    public function subCamp(): BelongsTo
    {
        return $this->belongsTo(JamboreeSubCamp::class, 'subcampID');
    }

    public function troop(): BelongsTo
    {
        return $this->belongsTo(JamboreeTroop::class, 'troopID');
    }

    public function patrol(): BelongsTo
    {
        return $this->belongsTo(JamboreePatrol::class, 'patrolID');
    }

    public function bed(): BelongsTo
    {
        return $this->belongsTo(JamboreeBed::class, 'bedID');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JamboreePatrol extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_patrols';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'troopID' => 'int',
        'name' => 'string',
        'active' => 'int',
    ];

    public function troop(): BelongsTo
    {
        return $this->belongsTo(JamboreeTroop::class, 'troopID');
    }
}

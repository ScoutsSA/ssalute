<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemAdvancementScoutsLevel extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_scouts_levels';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'scoutProgramTypeID' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'name' => 'string',
        'description' => 'string',
        'htmlColor' => 'string',
        'colour' => 'string',
        'highLevel' => 'int',
        'investment' => 'int',
        'active' => 'int',
    ];

    public function scoutProgramType(): BelongsTo
    {
        return $this->belongsTo(SystemProgramTypesScout::class, 'scoutProgramTypeID');
    }
}

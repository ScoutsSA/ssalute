<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SystemAdvancementCubsLevel extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_cubs_levels';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'name' => 'string',
        'description' => 'string',
        'highLevel' => 'int',
        'investment' => 'int',
        'colour' => 'string',
        'active' => 'int',
    ];

    public function areas(): HasMany
    {
        return $this->hasMany(SystemAdvancementCubsSecond::class, 'advancmentID')->orderBy('position');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(SystemAdvancementCubsThird::class, 'advancmentID')->orderBy('position');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SystemAdvancementMeerkatsLevel extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_meerkats_levels';

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
        'active' => 'int',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(SystemAdvancementMeerkatsSecond::class, 'advancmentID')->orderBy('position');
    }
}

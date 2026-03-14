<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemAdvancementCubsSecond extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_cubs_second';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'advancmentID' => 'int',
        'advancementArea' => 'string',
        'name' => 'string',
        'description' => 'string',
    ];

    public function advancement(): BelongsTo
    {
        return $this->belongsTo(SystemAdvancementCubsLevel::class, 'advancmentID');
    }
}

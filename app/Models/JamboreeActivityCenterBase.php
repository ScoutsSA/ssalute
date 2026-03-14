<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JamboreeActivityCenterBase extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_activity_center_bases';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'centerID' => 'int',
        'name' => 'string',
        'active' => 'int',
        'concurrentPatrols' => 'int',
        'hoursLong' => 'float',
        'slots' => 'int',
    ];

    public function center(): BelongsTo
    {
        return $this->belongsTo(JamboreeActivityCenter::class, 'centerID');
    }
}

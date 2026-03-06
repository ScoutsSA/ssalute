<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmsWarrantCancellationType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_warrant_cancellation_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'active' => 'int',
    ];

    public function warrants(): HasMany
    {
        return $this->hasMany(AmsWarrantInfo::class, 'cancellationTypeID');
    }
}

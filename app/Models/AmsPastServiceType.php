<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmsPastServiceType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_past_service_type';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'name' => 'string',
        'newID' => 'int',
    ];

    public function pastServices(): HasMany
    {
        return $this->hasMany(AmsPastServiceInfo::class, 'pastServiceType');
    }
}

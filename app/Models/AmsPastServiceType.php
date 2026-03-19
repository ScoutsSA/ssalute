<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmsPastServiceType extends BaseModel // This whole model/database table isn't used at all in SD
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_past_service_type'; // Can be removed - No impact to SD

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
        return $this->hasMany(PastService::class, 'pastServiceType');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmsWarrantType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_warrant_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'name' => 'string',
        'shortName' => 'string',
        'description' => 'string',
        'national' => 'int',
        'region' => 'int',
        'district' => 'int',
        'group' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function warrants(): HasMany
    {
        return $this->hasMany(AmsWarrantInfo::class, 'warrantTypeID');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(AmsWarrantApplication::class, 'warrantTypeID');
    }
}

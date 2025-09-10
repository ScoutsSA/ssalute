<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'regions';
    protected $guarded = [];
    protected $casts = [
        'id' => 'int',
        'position' => 'int',
        'name' => 'string',
        'short' => 'string',
        'usingAMS' => 'bool',
        'description' => 'string',
        'phys_address' => 'string',
        'active' => 'bool',
        'accountID' => 'int',
        'censusDone' => 'bool',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'regionID', 'id');
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_region', 'id');
    }
}

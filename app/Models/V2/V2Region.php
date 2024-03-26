<?php

namespace App\Models\V2;

use App\Models\V3\V3Region;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class V2Region extends Model
{
    protected $connection = 'sd_v2_core';
    protected $table = 'regions';
    protected $guarded = [];
    protected $hidden = [];
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

    public function newRegion(): HasOne
    {
        return $this->hasOne(V3Region::class, 'sd_region_id', 'id');
    }

    public function v2Districts(): HasMany
    {
        return $this->hasMany(V2District::class, 'regionID', 'id');
    }

    public function v2Groups(): HasMany
    {
        return $this->hasMany(V2Group::class, 'assoc_to_region', 'id');
    }
}

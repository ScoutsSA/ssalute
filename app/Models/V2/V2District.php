<?php

namespace App\Models\V2;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class V2District extends Model
{
    protected $connection = 'sd_core';
    protected $table = 'districts';
    protected $guarded = [];
    protected $hidden = [];

    protected $casts = [
        'id' => 'int',
        'regionID' => 'int',
        'superDistrictID' => 'int',
        'name' => 'string',
        'description' => 'string',
        'phys_address' => 'string',
        'countryID' => 'int',
        'active' => 'bool',
        'accountID' => 'int',
        'censusDone' => 'bool',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(V2Region::class, 'regionID', 'id');
    }

    public function groups(): HasMany
    {
        return $this->hasMany(V2Group::class, 'assoc_to_district', 'id');
    }
}

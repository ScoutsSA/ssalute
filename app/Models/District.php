<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'districts';
    protected $guarded = [];
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
        return $this->belongsTo(Region::class, 'regionID', 'id');
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_district', 'id');
    }
}

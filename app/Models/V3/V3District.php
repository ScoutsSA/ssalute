<?php

namespace App\Models\V3;

use App\Models\V2\V2District;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class V3District extends Model
{
    use HasFactory;

    protected $connection = 'v3_core';
    protected $table = 'districts';
    protected $guarded = [];
    protected $casts = [
        'id' => 'int',
        'sd_district_id' => 'int',
        'region_id' => 'int',
        'name' => 'string',
        'is_active' => 'bool',
        'features_flags' => 'object',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    public function v2District(): HasOne
    {
        return $this->hasOne(V2District::class, 'sd_district_id', 'id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(V3Region::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(V3Group::class);
    }
}

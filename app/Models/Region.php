<?php

namespace App\Models;

use App\Models\V2\V2Region;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Region extends Model
{
    protected $guarded = [];
    protected $casts = [
        'sd_region_id' => 'int',
        'display_order' => 'int',
        'name' => 'string',
        'short_code' => 'string',
        'active' => 'bool',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    public function v2Region(): HasOne
    {
        return $this->hasOne(V2Region::class, 'sd_region_id', 'id');
    }

    // Districts

    // Groups

    // Sections

    // Users
}

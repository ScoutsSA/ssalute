<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $guarded = [];
    protected $casts = [
        'sd_region_id' => 'int',
        'display_order' => 'int',
        'name' => 'string',
        'short_code' => 'string',
        'active' => 'bool',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    // SD Region

    // Districts

    // Groups

    // Sections

    // Users
}

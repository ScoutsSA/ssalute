<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'id' => 'int',
        'region_id' => 'int',
        'district_id' => 'int',
        'group_id' => 'int',
        'type' => 'string',
        'is_active' => 'bool',

        'name' => 'string',
        'email' => 'string',
        'features_flags' => 'object',
        'created_at' => 'datetime',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}

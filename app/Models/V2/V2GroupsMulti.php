<?php

namespace App\Models\V2;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class V2GroupsMulti extends Model
{
    public const TYPE_MEERCAT = 'Meerkat';
    public const TYPE_CUB = 'Cub';
    public const TYPE_SCOUT = 'Scout';
    public const TYPE_ROVER = 'Rover';

    protected $connection = 'sd_core';
    protected $table = 'groups_multi';
    protected $guarded = [];
    protected $hidden = [];

    protected $casts = [
        'id' => 'int',
        'type' => 'string',
        'groupID' => 'integer',
        'name' => 'string',
        'active' => 'bool',
        'created' => 'datetime',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(V2Region::class, 'assoc_to_district', 'id');
    }
}

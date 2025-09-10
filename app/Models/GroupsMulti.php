<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupsMulti extends Model
{
    public const TYPE_MEERCAT = 'Meerkat';
    public const TYPE_CUB = 'Cub';
    public const TYPE_SCOUT = 'Scout';
    public const TYPE_ROVER = 'Rover';

    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'groups_multi';
    protected $guarded = [];

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
        return $this->belongsTo(Region::class, 'assoc_to_district', 'id');
    }
}

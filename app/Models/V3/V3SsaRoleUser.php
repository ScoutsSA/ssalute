<?php

namespace App\Models\V3;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class V3SsaRoleUser extends Pivot
{

    protected $connection = 'v3_core';
    protected $table = 'ssa_role_user';
    public $incrementing = true;

    protected $guarded = [];

    protected $casts = [
        'ssa_role_id' => 'integer',
        'user_id' => 'integer',
        'related_model' => 'string',
        'related_id' => 'integer',
        'is_active' => 'boolean',
        'creation_notes' => 'string',

        'warrant_id' => 'integer',
        'created_by' => 'integer',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    public function ssaRole(): BelongsTo
    {
        return $this->belongsTo(V3SsaRole::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(V3User::class);
    }
}

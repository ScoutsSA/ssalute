<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SsaRoleUser extends Pivot
{
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
        return $this->belongsTo(SsaRole::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

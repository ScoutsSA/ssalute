<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'warrant_id' => 'integer',
        'created_by' => 'integer',
    ];

    public function ssaRoles(): HasMany
    {
        return $this->hasMany(SsaRole::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

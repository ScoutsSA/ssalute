<?php

namespace App\Models\V3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class V3SsaRole extends Model
{

    protected $connection = 'v3_core';
    protected $table = 'ssa_roles';
    protected $guarded = [];
    protected $casts = [
        'sd_system_user_type_id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'related_to' => 'string',
        'requires_warrant' => 'bool',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(V3User::class)->using(V3SsaRoleUser::class)->withTimestamps();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(V3Permission::class)->withTimestamps();
    }
}

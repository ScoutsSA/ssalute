<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SsaRole extends Model
{
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
        return $this->belongsToMany(User::class)->using(SsaRoleUser::class)->withTimestamps();
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupsPropertyUpdate extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'groups_property_updates';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'groupID' => 'int',
        'updatedby' => 'int',
        'updatedDate' => 'datetime',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'groupID');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'updatedby');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmsSuspendLeader extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_suspend_leader';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'suspendDate' => 'date',
        'suspenReasonID' => 'int',
        'unsuspendDate' => 'datetime',
        'unsuspendedby' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'assocToRegion');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'assocToDistrict');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'assocToGroup');
    }

    public function suspendReason(): BelongsTo
    {
        return $this->belongsTo(AmsSuspendReason::class, 'suspenReasonID');
    }

    public function unsuspendedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'unsuspendedby');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScouterReview extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'scouter_reviews';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'roleID' => 'int',
        'review' => 'string',
        'reviewedFor' => 'string',
        'stars' => 'int',
        'active' => 'int',
        'approved' => 'int',
        'approvedby' => 'int',
        'approvedDate' => 'datetime',
        'declined' => 'int',
        'declinedby' => 'int',
        'declinedDate' => 'datetime',
        'declinedReason' => 'string',
        'declinedNotes' => 'string',
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
        return $this->belongsTo(Region::class, 'regionID');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'districtID');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'groupID');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(SystemUserType::class, 'roleID');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'approvedby');
    }

    public function declinedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'declinedby');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InfoSharing extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'info_sharing';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'region' => 'int',
        'type' => 'int',
        'name' => 'string',
        'description' => 'string',
        'contactPerson' => 'string',
        'email' => 'string',
        'tel' => 'string',
        'website' => 'string',
        'address' => 'string',
        'gpsLat' => 'string',
        'gpsLon' => 'string',
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

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region');
    }

    public function infoType(): BelongsTo
    {
        return $this->belongsTo(InfoSharingType::class, 'type');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'approvedby');
    }

    public function declinedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'declinedby');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(InfoSharingLike::class, 'infoID', 'id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(InfoSharingReview::class, 'infoID', 'id');
    }
}

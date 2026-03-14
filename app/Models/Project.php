<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'projects';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'projectForID' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'typeID' => 'int',
        'name' => 'string',
        'description' => 'string',
        'aim' => 'string',
        'startDate' => 'date',
        'endDate' => 'date',
        'document' => 'string',
        'contactPerson' => 'string',
        'contactEmail' => 'string',
        'contactCell' => 'string',
        'contactWebsite' => 'string',
        'active' => 'int',
        'approved' => 'int',
        'approvedby' => 'int',
        'approveddate' => 'datetime',
        'declined' => 'int',
        'declinedby' => 'int',
        'declineddate' => 'datetime',
        'declinedReason' => 'string',
        'declinedNotes' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

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

    public function projectFor(): BelongsTo
    {
        return $this->belongsTo(ProjectsFor::class, 'projectForID');
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

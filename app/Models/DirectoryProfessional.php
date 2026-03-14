<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DirectoryProfessional extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'directory_professional';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'companyName' => 'string',
        'countryID' => 'int',
        'locationName' => 'string',
        'bio' => 'string',
        'skills' => 'string',
        'likes' => 'int',
        'facebook' => 'string',
        'linkedin' => 'string',
        'twitter' => 'string',
        'pintrest' => 'string',
        'googlePlus' => 'string',
        'website' => 'string',
        'contactPersonName' => 'string',
        'contactEmail' => 'string',
        'contactTel' => 'string',
        'active' => 'int',
        'approved' => 'int',
        'approvedBy' => 'int',
        'approvedDate' => 'datetime',
        'declined' => 'int',
        'declinedBy' => 'int',
        'declinedDate' => 'datetime',
        'declinedReason' => 'string',
        'declinedNotes' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'approvedBy');
    }

    public function declinedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'declinedBy');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(DirectoryProfessionalReview::class, 'directoryID');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(DirectoryProfessionalLike::class, 'directoryID');
    }
}

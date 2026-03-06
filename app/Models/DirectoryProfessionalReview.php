<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DirectoryProfessionalReview extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'directory_professional_reviews';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'directoryID' => 'int',
        'review' => 'string',
        'stars' => 'int',
        'active' => 'int',
        'approved' => 'int',
        'approvedBy' => 'int',
        'approvedDate' => 'datetime',
        'declined' => 'int',
        'declinedReasonID' => 'int',
        'declinedby' => 'int',
        'declinedDate' => 'datetime',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function directory(): BelongsTo
    {
        return $this->belongsTo(DirectoryProfessional::class, 'directoryID');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'approvedBy');
    }

    public function declinedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'declinedby');
    }
}

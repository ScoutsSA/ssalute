<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class InfoSharingReview extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'info_sharing_reviews';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'infoID' => 'int',
        'title' => 'string',
        'review' => 'string',
        'stars' => 'int',
        'active' => 'int',
        'approved' => 'int',
        'declined' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'approvedby' => 'int',
        'approvedDate' => 'datetime',
        'declinedDate' => 'datetime',
        'declinedby' => 'int',
        'declineReason' => 'string',
        'declinedNotes' => 'string',
    ];

}

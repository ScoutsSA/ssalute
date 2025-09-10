<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class ScouterReview extends Model
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

}

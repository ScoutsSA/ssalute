<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class DirectoryProfessionalReview extends Model
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

}

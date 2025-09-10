<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AmsAwardApplication extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_award_applications';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'userID' => 'int',
        'awardHeadingID' => 'int',
        'awardTypeID' => 'int',
        'PDFLocation' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'awardDate' => 'datetime',
        'awardedBy' => 'int',
        'declinedDate' => 'datetime',
        'declinedBy' => 'int',
        'awardType' => 'string',
        'awardDescription' => 'string',
    ];

}

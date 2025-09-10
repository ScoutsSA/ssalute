<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class BadgesCub extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'badges_cubs';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'cubID' => 'int',
        'userID' => 'int',
        'firstID' => 'int',
        'secondID' => 'int',
        'badgeDate' => 'date',
        'notes' => 'string',
        'PDFLocation' => 'string',
        'latest' => 'int',
        'instructorsName' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

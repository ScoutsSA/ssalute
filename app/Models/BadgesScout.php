<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class BadgesScout extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'badges_scouts';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'scoutID' => 'int',
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
        'approvedDate' => 'datetime',
        'approvedBy' => 'int',
    ];

}

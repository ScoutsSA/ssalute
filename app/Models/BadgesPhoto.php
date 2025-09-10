<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class BadgesPhoto extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'badges_photos';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'type' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'description' => 'string',
        'PDFLocation' => 'string',
        'thumbLocation' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'badgeFirstID' => 'int',
        'badgeSecondID' => 'int',
        'active' => 'int',
    ];

}

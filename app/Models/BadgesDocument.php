<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class BadgesDocument extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'badges_documents';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'type' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'description' => 'string',
        'PDFLocation' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'badgeFirstID' => 'int',
        'badgeSecondID' => 'int',
        'active' => 'int',
    ];

}

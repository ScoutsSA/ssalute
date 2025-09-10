<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class BadgesNote extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'badges_notes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'type' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'note' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'firstID' => 'int',
        'secondID' => 'int',
        'thirdID' => 'int',
        'active' => 'int',
    ];

}

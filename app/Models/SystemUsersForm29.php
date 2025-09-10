<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemUsersForm29 extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_users_form29';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'PDFLocation' => 'string',
        'sentToDSD' => 'date',
        'DSDResponse' => 'string',
        'DSDResponseNotes' => 'string',
        'DSDResponseDate' => 'datetime',
        'DSDResponseBy' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupWeeklyEmailsEmailed extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_weekly_emails_emailed';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToGroup' => 'int',
        'accountID' => 'int',
        'userID' => 'int',
        'programID' => 'int',
        'programDate' => 'date',
        'sentDate' => 'datetime',
        'created' => 'datetime',
        'createdby' => 'int',
        'mailType' => 'string',
    ];

}

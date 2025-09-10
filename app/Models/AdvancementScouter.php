<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AdvancementScouter extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'advancement_scouters';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'assocToGroup' => 'int',
        'scouterID' => 'int',
        'advancementID' => 'int',
        'advancementDate' => 'date',
        'notes' => 'string',
        'latest' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

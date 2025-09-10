<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AdvancementNote extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'advancement_notes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'type' => 'int',
        'countryID' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'note' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'advancementFirstID' => 'int',
        'advancementSecondID' => 'int',
        'advancementThirdID' => 'int',
        'active' => 'int',
    ];

}

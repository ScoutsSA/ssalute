<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AdvancementDocument extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'advancement_documents';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'type' => 'int',
        'countryID' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'description' => 'string',
        'PDFLocation' => 'string',
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

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AdvancementMeerkat extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'advancement_meerkats';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'meerkatID' => 'int',
        'userID' => 'int',
        'themeID' => 'int',
        'advancementID' => 'int',
        'advancementSecondID' => 'int',
        'advancementThirdID' => 'int',
        'notes' => 'string',
        'PDFLocation' => 'string',
        'advancementDate' => 'date',
        'latest' => 'int',
        'instructorsName' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

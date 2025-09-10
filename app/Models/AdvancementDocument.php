<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AdvancementDocument extends Model
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

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class JamboreeScouter extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_scouters';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'scouterPosition' => 'string',
        'scouterFirst' => 'string',
        'scouterSurname' => 'string',
        'scouterEmail' => 'string',
        'scouterCellNr' => 'string',
    ];

}

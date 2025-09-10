<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class JamboreeScouter extends Model
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

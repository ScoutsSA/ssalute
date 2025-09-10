<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AdvancementScouter extends Model
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

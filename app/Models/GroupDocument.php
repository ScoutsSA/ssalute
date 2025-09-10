<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupDocument extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_documents';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'docType' => 'int',
        'docArea' => 'string',
        'assocToPerson' => 'int',
        'assocToAccount' => 'int',
        'assocToGroup' => 'int',
        'description' => 'string',
        'location' => 'string',
        'expiryDate' => 'date',
        'active' => 'int',
        'created' => 'date',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

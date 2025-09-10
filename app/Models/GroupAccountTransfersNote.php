<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupAccountTransfersNote extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_account_transfers_notes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'transferID' => 'int',
        'note' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

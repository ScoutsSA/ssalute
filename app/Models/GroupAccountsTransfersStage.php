<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupAccountsTransfersStage extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_accounts_transfers_stages';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
    ];

}

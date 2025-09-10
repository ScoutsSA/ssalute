<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupAccountsTransfersStage extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_accounts_transfers_stages';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
    ];

}

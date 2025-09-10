<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupAccountsTransfer extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_accounts_transfers';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'fromCountryID' => 'int',
        'fromRegionID' => 'int',
        'fromDistrictID' => 'int',
        'fromGroupID' => 'int',
        'toCountryID' => 'int',
        'toRegionID' => 'int',
        'toDistrictID' => 'int',
        'toGroupID' => 'int',
        'accountID' => 'int',
        'action' => 'int',
        'notes' => 'string',
        'fromSGLApproved' => 'int',
        'fromSGLID' => 'int',
        'fromSGLApprovedDate' => 'datetime',
        'fromSGLNotes' => 'string',
        'fromTreasurerApproved' => 'int',
        'fromTreasurerID' => 'int',
        'fromTreasurerApprovedDate' => 'datetime',
        'fromTreasurerNotes' => 'string',
        'toSGLApproved' => 'int',
        'toSGLID' => 'int',
        'toSGLApprovedDate' => 'datetime',
        'toSGLNotes' => 'string',
        'actualTransferDate' => 'datetime',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

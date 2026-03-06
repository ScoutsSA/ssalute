<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupAccountsTransfer extends BaseModel
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

    public function fromGroup(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'fromGroupID');
    }

    public function toGroup(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'toGroupID');
    }

    public function fromRegion(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'fromRegionID');
    }

    public function toRegion(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'toRegionID');
    }

    public function fromDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'fromDistrictID');
    }

    public function toDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'toDistrictID');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(GroupAccount::class, 'accountID');
    }

    public function fromSgl(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'fromSGLID');
    }

    public function fromTreasurer(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'fromTreasurerID');
    }

    public function toSgl(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'toSGLID');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(GroupAccountTransfersNote::class, 'transferID');
    }
}

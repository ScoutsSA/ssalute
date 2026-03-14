<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmsWarrantApplication extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_warrant_applications';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'warrantTypeID' => 'int',
        'PDFLocation' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'awardDate' => 'datetime',
        'awardedBy' => 'int',
        'declinedDate' => 'datetime',
        'declinedBy' => 'int',
        'awardType' => 'string',
        'awardDescription' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'assocToRegion');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'assocToDistrict');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'assocToGroup');
    }

    public function warrantType(): BelongsTo
    {
        return $this->belongsTo(AmsWarrantType::class, 'warrantTypeID');
    }

    public function awardedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'awardedBy');
    }

    public function declinedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'declinedBy');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmsAdultLeaderMove extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_adult_leader_moves';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'userID' => 'int',
        'fromPosition' => 'int',
        'ToPosition' => 'int',
        'fromGroup' => 'int',
        'toGroup' => 'int',
        'fromDistrict' => 'int',
        'toDistrict' => 'int',
        'effectiveDate' => 'date',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'assocToRegion');
    }

    public function fromPosition(): BelongsTo
    {
        return $this->belongsTo(SystemUserType::class, 'fromPosition');
    }

    public function toPosition(): BelongsTo
    {
        return $this->belongsTo(SystemUserType::class, 'ToPosition');
    }

    public function fromGroupModel(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'fromGroup');
    }

    public function toGroupModel(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'toGroup');
    }

    public function fromDistrictModel(): BelongsTo
    {
        return $this->belongsTo(District::class, 'fromDistrict');
    }

    public function toDistrictModel(): BelongsTo
    {
        return $this->belongsTo(District::class, 'toDistrict');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JamboreeExprOfInterest extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_expr_of_interest';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'userID' => 'int',
        'parentID' => 'int',
        'positionID' => 'int',
        'passportCountryID' => 'int',
        'passportCheck' => 'int',
        'notes' => 'string',
        'created' => 'datetime',
        'active' => 'int',
        'offeredPosition' => 'int',
        'offeredPositionDate' => 'datetime',
        'offeredPositionBy' => 'int',
        'declinedPosition' => 'int',
        'declinedPositionDate' => 'datetime',
        'declinedPositionBy' => 'int',
        'declinedReason' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'regionID');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'districtID');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'groupID');
    }

    public function offeredPositionByUser(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'offeredPositionBy');
    }

    public function declinedPositionByUser(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'declinedPositionBy');
    }
}

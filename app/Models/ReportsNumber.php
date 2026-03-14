<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportsNumber extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'reports_numbers';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'month' => 'date',
        'meerkatsM' => 'int',
        'meerkatsF' => 'int',
        'cubsM' => 'int',
        'cubsF' => 'int',
        'scoutsM' => 'int',
        'scoutsF' => 'int',
        'roversM' => 'int',
        'roversF' => 'int',
        'adultsDenM' => 'int',
        'adultsDenF' => 'int',
        'adultsPackM' => 'int',
        'adultsPackF' => 'int',
        'adultsTroopM' => 'int',
        'adultsTroopF' => 'int',
        'adultsCrewM' => 'int',
        'adultsCrewF' => 'int',
        'adultsGroupM' => 'int',
        'adultsGroupF' => 'int',
        'committee' => 'int',
        'helpers' => 'int',
        'created' => 'datetime',
    ];

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
}

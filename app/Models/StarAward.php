<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StarAward extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'star_awards';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'year' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'denID' => 'int',
        'packID' => 'int',
        'troopID' => 'int',
        'patrolID' => 'int',
        'crewID' => 'int',
        'scouterAskedAward' => 'string',
        'scouterAskedAwardDate' => 'datetime',
        'scouterAskedAwardUserID' => 'int',
        'scouterMotivation' => 'string',
        'nptmRecommended' => 'string',
        'nptmAskedAwardDate' => 'datetime',
        'nptmAskedAwardUserID' => 'int',
        'nptmMotivation' => 'string',
        'rtcRecommended' => 'string',
        'rtcRecommendedDate' => 'datetime',
        'rtcRecommendedUserID' => 'int',
        'rtcMotivation' => 'string',
        'chairAwarded' => 'int',
        'chairAwardedDate' => 'datetime',
        'chairAwardedUserID' => 'int',
        'active' => 'int',
    ];

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

    public function scouterAskedAwardUser(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'scouterAskedAwardUserID');
    }

    public function nptmAskedAwardUser(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'nptmAskedAwardUserID');
    }

    public function rtcRecommendedUser(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'rtcRecommendedUserID');
    }

    public function chairAwardedUser(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'chairAwardedUserID');
    }

    public function den(): BelongsTo
    {
        return $this->belongsTo(GroupMeerkatDen::class, 'denID');
    }

    public function pack(): BelongsTo
    {
        return $this->belongsTo(GroupCubPack::class, 'packID');
    }

    public function troop(): BelongsTo
    {
        return $this->belongsTo(GroupScoutTroop::class, 'troopID');
    }

    public function patrol(): BelongsTo
    {
        return $this->belongsTo(GroupScoutsPatrolName::class, 'patrolID');
    }

    public function crew(): BelongsTo
    {
        return $this->belongsTo(GroupRoverCrew::class, 'crewID');
    }
}

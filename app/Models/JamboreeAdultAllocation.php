<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JamboreeAdultAllocation extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_adult_allocations';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'subCampID' => 'int',
        'activityCenterID' => 'int',
        'baseID' => 'int',
        'roleID' => 'int',
        'userID' => 'int',
        'notes' => 'string',
        'active' => 'int',
        'position' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(JamboreeAdultRole::class, 'roleID');
    }

    public function base(): BelongsTo
    {
        return $this->belongsTo(JamboreeActivityCenterBase::class, 'baseID');
    }

    public function subCamp(): BelongsTo
    {
        return $this->belongsTo(JamboreeSubCamp::class, 'subCampID');
    }

    public function activityCenter(): BelongsTo
    {
        return $this->belongsTo(JamboreeActivityCenter::class, 'activityCenterID');
    }
}

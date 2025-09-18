<?php

namespace App\Models;

use App\Models\Concerns\MightHaveCreatedBy;
use App\Models\Concerns\MightHaveModifiedBy;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SystemUsersOtherRole extends Pivot
{
    use MightHaveCreatedBy;
    use MightHaveModifiedBy;

    const ?string CREATED_AT = 'created';
    const ?string UPDATED_AT = 'modified';

    public $incrementing = true;

    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_users_other_roles';
    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'superDistrictID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'roleID' => 'int',
        'defaultRole' => 'int',
        'active' => 'int',
        'creationNotes' => 'string',
        'actionCountryID' => 'int',
        'actionRegionID' => 'int',
        'actionSuperDistrictID' => 'int',
        'actionDistrictID' => 'int',
        'actionGroupID' => 'int',
        'retired' => 'int',
        'resigned' => 'int',
        'suspended' => 'int',
        'multiID' => 'int',
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
        return $this->belongsTo(SystemUserType::class, 'roleID');
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
}

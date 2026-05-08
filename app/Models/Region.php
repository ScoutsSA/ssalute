<?php

namespace App\Models;

use App\Enums\GroupTypes;
use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'regions';
    protected $guarded = [];
    protected $casts = [
        'id' => 'int',
        'position' => 'int',
        'name' => 'string',
        'short' => 'string',
        'usingAMS' => 'bool',
        'description' => 'string',
        'phys_address' => 'string',
        'active' => 'bool',
        'accountID' => 'int',
        'censusDone' => 'bool',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'regionID', 'id');
    }

    public function superDistricts(): HasMany
    {
        return $this->hasMany(DistrictsSuper::class, 'regionID', 'id');
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_region', 'id');
    }

    public function communityGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_region', 'id')->where('groups.groupTypeID', GroupTypes::COMMUNITY->value);
    }

    public function ngoGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_region', 'id')->where('groups.groupTypeID', GroupTypes::NGO->value);
    }

    public function churchGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_region', 'id')->where('groups.groupTypeID', GroupTypes::CHURCH->value);
    }

    public function schoolGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_region', 'id')->where('groups.groupTypeID', GroupTypes::SCHOOL->value);
    }

    public function dsdGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_region', 'id')->where('groups.groupTypeID', GroupTypes::DSD->value);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(GroupProgram::class, 'assocToRegion', 'id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(GroupEvent::class, 'assocToRegion', 'id');
    }

    public function newsletters(): HasMany
    {
        return $this->hasMany(GroupNewsletter::class, 'assocToRegion', 'id');
    }

    public function districtReports(): HasMany
    {
        return $this->hasMany(GroupDistrictReport::class, 'assocToRegion', 'id');
    }

    public function committees(): HasMany
    {
        return $this->hasMany(GroupCommittee::class, 'assocToRegion', 'id');
    }

    public function youthCharges(): HasMany
    {
        return $this->hasMany(GroupYouthCharge::class, 'assocToRegion', 'id');
    }

    public function roleAttachments(): HasMany
    {
        return $this->hasMany(SystemUsersOtherRole::class, 'regionID');
    }

    public function ownedAccount(): BelongsTo
    {
        return $this->belongsTo(GroupAccount::class, 'accountID');
    }
}

<?php

namespace App\Models;

use App\Enums\GroupTypes;
use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'districts';
    protected $guarded = [];
    protected $casts = [
        'id' => 'int',
        'regionID' => 'int',
        'superDistrictID' => 'int',
        'name' => 'string',
        'description' => 'string',
        'phys_address' => 'string',
        'countryID' => 'int',
        'active' => 'bool',
        'accountID' => 'int',
        'censusDone' => 'bool',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'regionID', 'id');
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_district', 'id');
    }

    public function communityGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_district', 'id')->where('groups.groupTypeID', GroupTypes::COMMUNITY->value);
    }

    public function ngoGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_district', 'id')->where('groups.groupTypeID', GroupTypes::NGO->value);
    }

    public function churchGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_district', 'id')->where('groups.groupTypeID', GroupTypes::CHURCH->value);
    }

    public function schoolGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_district', 'id')->where('groups.groupTypeID', GroupTypes::SCHOOL->value);
    }

    public function dsdGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'assoc_to_district', 'id')->where('groups.groupTypeID', GroupTypes::DSD->value);
    }

    // This relationship could be defined both ways, so this is the district's primary owned account
    // (as opposed to accounts that may be linked to the district for other reasons)
    public function ownedAccount()
    {
        return $this->hasOne(GroupAccount::class, 'id', 'accountID');
    }
}

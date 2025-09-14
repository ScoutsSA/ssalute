<?php

namespace App\Models;

use App\Enums\GroupTypes;
use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Builder;
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
}

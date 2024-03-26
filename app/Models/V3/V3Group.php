<?php

namespace App\Models\V3;

use App\Constants\SectionTypes;
use App\Models\V2\V2Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class V3Group extends Model
{
    use HasFactory;

    protected $connection = 'v3_core';
    protected $table = 'groups';
    protected $guarded = [];
    protected $casts = [
        'id' => 'int',
        'sd_group_id' => 'int',
        'region_id' => 'int',
        'district_id' => 'int',
        'type' => 'string',
        'is_active' => 'bool',
        'managed_regionally' => 'bool',

        'name' => 'string',
        'email' => 'string',
        'description' => 'string',
        'scarf' => 'string',
        'physical_address' => 'string',

        'banking_details' => 'string',
        'website' => 'string',
        'related_social_links' => 'object', // Facebook/Twitter/Instagram/YouTube etc
        'google_maps' => 'string',
        'features_flags' => 'object',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    public function v2Group(): HasOne
    {
        return $this->hasOne(V2Group::class, 'sd_group_id', 'id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(V3Section::class);
    }

    public function dens(): HasMany
    {
        return $this->hasMany(V3Section::class)->where('sections.type', SectionTypes::DEN);
    }

    public function packs(): HasMany
    {
        return $this->hasMany(V3Section::class)->where('sections.type', SectionTypes::PACK);
    }

    public function troops(): HasMany
    {
        return $this->hasMany(V3Section::class)->where('sections.type', SectionTypes::TROOP);
    }

    public function crews(): HasMany
    {
        return $this->hasMany(V3Section::class)->where('sections.type', SectionTypes::CREW);
    }
}

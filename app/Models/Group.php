<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;


    protected $guarded = [];
    protected $casts = [
        'id' => 'int',
        'sd_group_id' => 'int',
        'region_id' => 'int',
        'district_id' => 'int',
        'type' => 'string',
        'active' => 'bool',
        'managedRegionally' => 'bool',

        'name' => 'string',
        'description' => 'string',
        'scarf' => 'string',
        'physical_address' => 'string',

        'banking_details' => 'string',
        'website' => 'string',
        'related_social_links' => 'object', // Facebook/Twitter/Instagram/YouTube etc
        'google_maps' => 'string',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

}

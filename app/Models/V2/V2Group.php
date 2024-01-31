<?php

namespace App\Models\V2;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class V2Group extends Model
{
    protected $connection = 'sd_core';
    protected $table = 'groups';
    protected $guarded = [];
    protected $hidden = [];
    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'sdLiteOnly' => 'bool',
        'usesGoScan' => 'bool',
        'usesShop' => 'bool',
        'usesPayFees' => 'bool',
        'groupAccountID' => 'int',
        'scarf' => 'string',
        'groupTypeID' => 'int',
        'description' => 'string',
        'multiDen' => 'bool',
        'multiPack' => 'bool',
        'multiTroop' => 'bool',
        'multiCrew' => 'bool',
        'meerkatProgramType' => 'int',
        'cubProgramType' => 'int',
        'scoutProgramType' => 'int',
        'roverProgramType' => 'int',
        'amsOnly' => 'bool',
        'hasMeerkats' => 'bool',
        'hasCubs' => 'bool',
        'hasScouts' => 'bool',
        'hasRovers' => 'bool',
        'hasBranch1' => 'bool',
        'hasBranch2' => 'bool',
        'hasBranch3' => 'bool',
        'hasBranch4' => 'bool',
        'hasBranch5' => 'bool',
        'sendWeeklyMails' => 'bool',
        'assoc_to_district' => 'int',
        'assoc_to_region' => 'int',
        'roverAssocToGroup' => 'bool',
        'phys_address' => 'string',
        'postalAddress' => 'string',
        'postalCountryID' => 'int',
        'phys_country_id' => 'int',
        'bankingDetails' => 'string',
        'bankAccountName' => 'string',
        'bankName' => 'string',
        'branchName' => 'string',
        'branchCode' => 'string',
        'bankAccountNumber' => 'string',
        'invoiceNotes' => 'string',
        'facebook' => 'string',
        'twitter' => 'string',
        'website' => 'string',
        'email' => 'string',
        'googleplus' => 'string',
        'instagram' => 'string',
        'linkedin' => 'string',
        'pintrest' => 'string',
        'youtube' => 'string',
        'tumblr' => 'string',
        'googleMaps' => 'string',
        'gpsLat' => 'string',
        'gpsLon' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'active' => 'bool',
        'weatherID' => 'string',
        'weatherLocationName' => 'string',
        'managedRegionally' => 'bool',
        'canMoveToEntsha' => 'bool',
        'using20' => 'bool',
        'groupRegNr' => 'string',
        'censusDone' => 'bool',
        'groupLastUpdated' => 'datetime',
        'groupLastUpdatedBy' => 'int',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function scopeNotScoutingInSchools(Builder $query): void
    {
        $query->where('', 1);
        // Where group type .name != Schools Group
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(V2Region::class, 'assoc_to_region', 'id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(V2Region::class, 'assoc_to_district', 'id');
    }
}

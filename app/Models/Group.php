<?php

namespace App\Models;

use App\Enums\GroupTypes;
use App\Enums\ProgramTypes\ProgramCubsType;
use App\Enums\ProgramTypes\ProgramMeerkatsType;
use App\Enums\ProgramTypes\ProgramRoversType;
use App\Enums\ProgramTypes\ProgramScoutsType;
use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'groups';
    protected $guarded = [];
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
        'meerkatProgramType' => 'int', // This should be set on the section level
        'cubProgramType' => 'int', // This should be set on the section level
        'scoutProgramType' => 'int', // This should be set on the section level
        'roverProgramType' => 'int', // This should be set on the section level
        'amsOnly' => 'bool', // This is hardcoded to always be zero in SD
        'hasMeerkats' => 'bool',
        'hasCubs' => 'bool',
        'hasScouts' => 'bool',
        'hasRovers' => 'bool',
        'hasBranch1' => 'bool', // Can be removed - No impact to SD
        'hasBranch2' => 'bool', // Can be removed - No impact to SD
        'hasBranch3' => 'bool', // Can be removed - No impact to SD
        'hasBranch4' => 'bool', // Can be removed - No impact to SD
        'hasBranch5' => 'bool', // Can be removed - No impact to SD
        'sendWeeklyMails' => 'bool', // Can be removed - No impact to SD
        'assoc_to_district' => 'int',
        'assoc_to_region' => 'int',
        'roverAssocToGroup' => 'bool',  // Can be removed - No impact to SD
        'phys_address' => 'string',
        'postalAddress' => 'string',
        'postalCountryID' => 'int', // Deprecated - No Multi-country support
        'phys_country_id' => 'int', // Deprecated - No Multi-country support
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
        'canMoveToEntsha' => 'bool', // Deprecated - Entcha was 2019
        'using20' => 'bool', // Unknown - Seems to only be pulled in reports, but always true
        'groupRegNr' => 'string',
        'censusDone' => 'bool',
        'groupLastUpdated' => 'datetime', // This seems like a secondary modified date, for when child records are updated
        'groupLastUpdatedBy' => 'int', // This seems like a secondary modified date, for when child records are updated
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function scopeNotScoutingInSchools(Builder $query): void
    {
        $query->where('', 1);
        // Where group type .name != Schools V3Group
    }

    public function multiSections(): HasMany
    {
        return $this->hasMany(GroupsMulti::class, 'groupID', 'id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'assoc_to_region', 'id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'assoc_to_district', 'id');
    }

    public function groupTypeLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => GroupTypes::tryFrom($this->groupTypeID)?->getLabel()
        );
    }

    public function meerkatProgramTypeLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => ProgramMeerkatsType::tryFrom($this->meerkatProgramType)?->getLabel()
        );
    }

    public function cubProgramTypeLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => ProgramCubsType::tryFrom($this->cubProgramType)?->getLabel()
        );
    }

    public function scoutProgramTypeLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => ProgramScoutsType::tryFrom($this->scoutProgramType)?->getLabel()
        );
    }

    public function roverProgramTypeLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => ProgramRoversType::tryFrom($this->roverProgramType)?->getLabel()
        );
    }

    public function bankInfoShort(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->bankName ? ($this->bankName . ' - ' . $this->bankAccountNumber) : 'Missing Details'
        );
    }
}

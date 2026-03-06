<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupProgram extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_programs';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'programAreaName' => 'string',
        'multiID' => 'int',
        'denID' => 'int',
        'packID' => 'int',
        'troopID' => 'int',
        'crewID' => 'int',
        'programType' => 'int',
        'meerkatProgramTypeID' => 'int',
        'cubProgramTypeID' => 'int',
        'scoutProgramTypeID' => 'int',
        'roverProgramTypeID' => 'int',
        'responsibleScouter' => 'int',
        'dutyPatrol' => 'int',
        'title' => 'string',
        'description' => 'string',
        'date' => 'date',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'document' => 'string',
        'active' => 'int',
        'shared' => 'int',
        'sharedby' => 'int',
        'sharedDate' => 'date',
        'roverProgramType' => 'int',
        'online' => 'int',
        'onlineActive' => 'int',
        'onlineEndDate' => 'date',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'assocToRegion');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'assocToDistrict');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'assocToGroup');
    }

    public function responsibleScouter(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'responsibleScouter');
    }

    public function sharedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'sharedby');
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

    public function crew(): BelongsTo
    {
        return $this->belongsTo(GroupRoverCrew::class, 'crewID');
    }

    public function meerkatProgramType(): BelongsTo
    {
        return $this->belongsTo(SystemProgramTypesMeerkat::class, 'meerkatProgramTypeID');
    }

    public function cubProgramType(): BelongsTo
    {
        return $this->belongsTo(SystemProgramTypesCub::class, 'cubProgramTypeID');
    }

    public function scoutProgramType(): BelongsTo
    {
        return $this->belongsTo(SystemProgramTypesScout::class, 'scoutProgramTypeID');
    }

    public function roverProgramType(): BelongsTo
    {
        return $this->belongsTo(SystemProgramTypesRover::class, 'roverProgramTypeID');
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(GroupAttendance::class, 'programId', 'id');
    }

    public function onlineTasks(): HasMany
    {
        return $this->hasMany(GroupProgramsOnlineTask::class, 'programID', 'id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(GroupProgramsDocument::class, 'programID', 'id');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvancementScout extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'advancement_scouts';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'scoutProgramTypeID' => 'int',
        'scoutID' => 'int',
        'userID' => 'int',
        'themeID' => 'int',
        'advancementID' => 'int',
        'advancement2ID' => 'int',
        'advancementDate' => 'date',
        'notes' => 'string',
        'PDFLocation' => 'string',
        'latest' => 'int',
        'instructorsName' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'approvedDate' => 'datetime',
        'approvedBy' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function scout(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'scoutID');
    }

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

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'approvedBy');
    }

    public function scoutProgramType(): BelongsTo
    {
        return $this->belongsTo(SystemProgramTypesScout::class, 'scoutProgramTypeID');
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(SystemAdvancementScoutsSecondEntshaTheme::class, 'themeID');
    }

    public function advancement(): BelongsTo
    {
        return $this->belongsTo(SystemAdvancementScoutsLevel::class, 'advancementID');
    }

    public function advancementSecond(): BelongsTo
    {
        return $this->belongsTo(SystemAdvancementScoutsSecond::class, 'advancement2ID');
    }
}

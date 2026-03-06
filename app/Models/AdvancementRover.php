<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvancementRover extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'advancement_rovers';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'roverID' => 'int',
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
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function rover(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'roverID');
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

    public function theme(): BelongsTo
    {
        return $this->belongsTo(SystemAdvancementRoversChallenge::class, 'themeID');
    }

    public function advancement(): BelongsTo
    {
        return $this->belongsTo(SystemAdvancementRoversLevel::class, 'advancementID');
    }

    public function advancementSecond(): BelongsTo
    {
        return $this->belongsTo(SystemAdvancementRoversSecond::class, 'advancement2ID');
    }
}

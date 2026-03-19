<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PastTraining extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_training_past';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'trainingTypeID' => 'int',
        'courseName' => 'string',
        'courseNumber' => 'string',
        'completionDate' => 'date',
        'PDFLocation' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'validated' => 'int',
        'validatedDate' => 'datetime',
        'validatedby' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
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

    public function trainingType(): BelongsTo
    {
        return $this->belongsTo(AmsTrainingPastType::class, 'trainingTypeID');
    }

    public function validatedByUser(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'validatedby');
    }
}

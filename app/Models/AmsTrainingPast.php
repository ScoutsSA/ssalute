<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AmsTrainingPast extends Model
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

}

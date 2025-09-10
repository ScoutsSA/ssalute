<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AmsTrainingCourse extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_training_courses';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'courseType' => 'int',
        'assocToRegion' => 'int',
        'name' => 'string',
        'agendaPDFLocation' => 'string',
        'materialPDFLocation' => 'string',
        'nrOfDays' => 'int',
        'trainingSeats' => 'int',
        'maxBookings' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

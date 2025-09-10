<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AmsTrainingCoursesAnnualWarrantsAvailable extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_training_courses_annual_warrants_available';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'annualCourseID' => 'int',
        'warrantID' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

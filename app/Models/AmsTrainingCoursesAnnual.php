<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AmsTrainingCoursesAnnual extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_training_courses_annual';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'forAdultLeadersAndRovers' => 'int',
        'forParents' => 'int',
        'forScouts' => 'int',
        'assocToRegion' => 'int',
        'courseID' => 'string',
        'courseNumber' => 'string',
        'directorID' => 'int',
        'name' => 'string',
        'description' => 'string',
        'locationID' => 'int',
        'courseCost' => 'int',
        'bookingCutOffDate' => 'date',
        'startDate' => 'date',
        'endDate' => 'date',
        'previousQuali' => 'string',
        'maxBookings' => 'int',
        'warrantCourse' => 'int',
        'ical' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

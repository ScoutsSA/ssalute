<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class AmsTrainingCoursesAnnualBookingsTracking extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_training_courses_annual_bookings_tracking';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'bookingID' => 'int',
        'annualCourseID' => 'int',
        'userID' => 'int',
        'fromStatus' => 'int',
        'toStatus' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}

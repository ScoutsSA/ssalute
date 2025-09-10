<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AmsTrainingCoursesAnnualBooking extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_training_courses_annual_bookings';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'status' => 'int',
        'assocToRegion' => 'int',
        'bookingLocation' => 'string',
        'annualCourseID' => 'int',
        'userID' => 'int',
        'instructions' => 'string',
        'previousCourses' => 'string',
        'invoiceLocation' => 'string',
        'POPLocation' => 'string',
        'bugMailCount' => 'int',
        'active' => 'int',
        'completionConfirmed' => 'int',
        'userPIN' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

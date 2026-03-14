<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(AmsTrainingCoursesAnnualBooking::class, 'bookingID');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(AmsTrainingCoursesAnnual::class, 'annualCourseID');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmsTrainingCoursesAnnualBookingsNote extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_training_courses_annual_bookings_notes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'bookingID' => 'int',
        'annualCourseID' => 'int',
        'userID' => 'int',
        'note' => 'string',
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

    public function booking(): BelongsTo
    {
        return $this->belongsTo(AmsTrainingCoursesAnnualBooking::class, 'bookingID');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(AmsTrainingCoursesAnnual::class, 'annualCourseID');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmsTrainingCoursesAnnualBooking extends BaseModel
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'assocToRegion');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(AmsTrainingCoursesAnnual::class, 'annualCourseID');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(AmsTrainingCoursesAnnualBookingsNote::class, 'bookingID');
    }

    public function tracking(): HasMany
    {
        return $this->hasMany(AmsTrainingCoursesAnnualBookingsTracking::class, 'bookingID');
    }
}

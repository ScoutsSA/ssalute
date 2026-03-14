<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'assocToRegion');
    }

    public function director(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'directorID');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(AmsTrainingLocation::class, 'locationID');
    }

    public function dates(): HasMany
    {
        return $this->hasMany(AmsTrainingCoursesAnnualDate::class, 'courseID');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(AmsTrainingCoursesAnnualBooking::class, 'annualCourseID');
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(AmsTrainingCoursesAnnualAttendance::class, 'annualCourseID');
    }

    public function lecturers(): HasMany
    {
        return $this->hasMany(AmsTrainingCoursesAnnualLecturer::class, 'annualCourseID');
    }

    public function warrantsAvailable(): HasMany
    {
        return $this->hasMany(AmsTrainingCoursesAnnualWarrantsAvailable::class, 'annualCourseID');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmsTrainingCoursesAnnualAttendance extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_training_courses_annual_attendance';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'annualCourseID' => 'int',
        'dayID' => 'int',
        'dayDate' => 'date',
        'userID' => 'int',
        'attendance' => 'int',
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

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'assocToRegion');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(AmsTrainingCoursesAnnual::class, 'annualCourseID');
    }

    public function day(): BelongsTo
    {
        return $this->belongsTo(AmsTrainingCoursesAnnualDate::class, 'dayID');
    }
}

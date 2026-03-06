<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmsTrainingCoursesAnnualLecturer extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_training_courses_annual_lecturers';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'annualCourseID' => 'int',
        'lecturerID' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(AmsTrainingCoursesAnnual::class, 'annualCourseID');
    }

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'lecturerID');
    }
}

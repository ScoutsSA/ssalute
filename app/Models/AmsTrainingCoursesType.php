<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmsTrainingCoursesType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_training_courses_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'name' => 'string',
        'colour' => 'string',
        'active' => 'int',
    ];

    public function trainingCourses(): HasMany
    {
        return $this->hasMany(AmsTrainingCourse::class, 'courseType');
    }
}

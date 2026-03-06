<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmsTrainingLocation extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_training_locations';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'name' => 'string',
        'address' => 'string',
        'gpsLat' => 'string',
        'gpsLon' => 'string',
        'trainingSeats' => 'int',
        'contact' => 'string',
        'tel' => 'string',
        'cell' => 'string',
        'email' => 'string',
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

    public function courses(): HasMany
    {
        return $this->hasMany(AmsTrainingCoursesAnnual::class, 'locationID');
    }
}

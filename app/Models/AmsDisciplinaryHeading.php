<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmsDisciplinaryHeading extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_disciplinary_headings';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'reason' => 'string',
    ];

    public function offences(): HasMany
    {
        return $this->hasMany(AmsDisciplinaryOffence::class, 'headingID');
    }

    public function disciplinaryInfos(): HasMany
    {
        return $this->hasMany(AmsDisciplinaryInfo::class, 'disciplinaryHeadingID');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmsAwardHeading extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_award_headings';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'reason' => 'string',
    ];

    public function awardTypes(): HasMany
    {
        return $this->hasMany(AmsAwardType::class, 'headingID');
    }

    public function awards(): HasMany
    {
        return $this->hasMany(Award::class, 'awardHeadingID');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(AmsAwardApplication::class, 'awardHeadingID');
    }
}

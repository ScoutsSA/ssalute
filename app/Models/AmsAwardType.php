<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmsAwardType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_award_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'headingID' => 'int',
        'position' => 'int',
        'name' => 'string',
        'shortName' => 'string',
        'description' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function heading(): BelongsTo
    {
        return $this->belongsTo(AmsAwardHeading::class, 'headingID');
    }

    public function awards(): HasMany
    {
        return $this->hasMany(Award::class, 'awardTypeID');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(AmsAwardApplication::class, 'awardTypeID');
    }
}

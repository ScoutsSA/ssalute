<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmsDisciplinaryOffence extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_disciplinary_offences';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'headingID' => 'int',
        'offense' => 'string',
        'active' => 'int',
    ];

    public function heading(): BelongsTo
    {
        return $this->belongsTo(AmsDisciplinaryHeading::class, 'headingID');
    }
}

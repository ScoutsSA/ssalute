<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JamboreeBed extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_beds';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'subcampID' => 'int',
        'type' => 'int',
        'name' => 'string',
        'nrBeds' => 'int',
    ];

    public function subCamp(): BelongsTo
    {
        return $this->belongsTo(JamboreeSubCamp::class, 'subcampID');
    }
}

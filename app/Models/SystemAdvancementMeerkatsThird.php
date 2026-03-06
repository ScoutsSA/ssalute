<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemAdvancementMeerkatsThird extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_advancement_meerkats_third';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'advancmentID' => 'int',
        'secondID' => 'int',
        'challenge' => 'int',
        'theme' => 'int',
        'note' => 'string',
        'name' => 'string',
        'description' => 'string',
        'short' => 'string',
        'campingTask' => 'int',
        'badgeTask' => 'int',
        'active' => 'int',
    ];

    public function advancement(): BelongsTo
    {
        return $this->belongsTo(SystemAdvancementMeerkatsLevel::class, 'advancmentID');
    }

    public function advancementSecond(): BelongsTo
    {
        return $this->belongsTo(SystemAdvancementMeerkatsSecond::class, 'secondID');
    }
}

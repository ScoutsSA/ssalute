<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemFaq extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_faq';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'catID' => 'int',
        'targetID' => 'int',
        'q' => 'string',
        'a' => 'string',
        'active' => 'int',
        'position' => 'int',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SystemFaqCat::class, 'catID');
    }
}

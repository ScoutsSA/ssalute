<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupStarAward extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_star_awards';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'regionID' => 'int',
        'districtID' => 'int',
        'groupID' => 'int',
        'year' => 'int',
        'area' => 'int',
        'multiID' => 'int',
        'awardID' => 'int',
        'PDFLocation' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'regionID');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'districtID');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'groupID');
    }

    public function award(): BelongsTo
    {
        return $this->belongsTo(SystemStarAwardType::class, 'awardID');
    }
}

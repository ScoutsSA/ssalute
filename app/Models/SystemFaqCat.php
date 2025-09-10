<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemFaqCat extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_faq_cats';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'faqGroup' => 'int',
        'position' => 'int',
        'name' => 'string',
        'description' => 'string',
        'forNational' => 'int',
        'forRegion' => 'int',
        'forDistrict' => 'int',
        'forGroupAdults' => 'int',
        'forGroupParents' => 'int',
        'forGroupScouts' => 'int',
        'forGroupRovers' => 'int',
        'forAlumni' => 'int',
        'active' => 'int',
    ];

}

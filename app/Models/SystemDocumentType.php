<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class SystemDocumentType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_document_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'description' => 'string',
        'youth' => 'int',
    ];

}

<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class GroupProgramsDocument extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_programs_documents';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programID' => 'int',
        'name' => 'string',
        'PDFLocation' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

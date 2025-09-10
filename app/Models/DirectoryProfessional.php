<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class DirectoryProfessional extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'directory_professional';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'companyName' => 'string',
        'countryID' => 'int',
        'locationName' => 'string',
        'bio' => 'string',
        'skills' => 'string',
        'likes' => 'int',
        'facebook' => 'string',
        'linkedin' => 'string',
        'twitter' => 'string',
        'pintrest' => 'string',
        'googlePlus' => 'string',
        'website' => 'string',
        'contactPersonName' => 'string',
        'contactEmail' => 'string',
        'contactTel' => 'string',
        'active' => 'int',
        'approved' => 'int',
        'approvedBy' => 'int',
        'approvedDate' => 'datetime',
        'declined' => 'int',
        'declinedBy' => 'int',
        'declinedDate' => 'datetime',
        'declinedReason' => 'string',
        'declinedNotes' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

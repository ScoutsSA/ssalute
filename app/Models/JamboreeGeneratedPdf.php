<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class JamboreeGeneratedPdf extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_generated_pdfs';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'subCampID' => 'int',
        'troopID' => 'int',
        'busID' => 'int',
        'userID' => 'int',
        'type' => 'string',
        'PDFLocation' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}

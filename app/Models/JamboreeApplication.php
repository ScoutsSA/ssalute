<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;

class JamboreeApplication extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_application';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'active' => 'int',
        'jamboreeID' => 'int',
        'jamboreeNumber' => 'string',
        'stepComplete' => 'int',
        'step1Complete' => 'datetime',
        'step2Complete' => 'datetime',
        'step3Complete' => 'datetime',
        'step4Complete' => 'datetime',
        'step5Complete' => 'datetime',
        'step6Complete' => 'datetime',
        'step7Complete' => 'datetime',
        'step8Complete' => 'datetime',
        'step1notes' => 'string',
        'step2notes' => 'string',
        'step3notes' => 'string',
        'step4notes' => 'string',
        'step5notes' => 'string',
        'step6notes' => 'string',
        'step7notes' => 'string',
        'step8notes' => 'string',
        'currentGrade' => 'string',
        'advancementLevel' => 'string',
        'pltuAttendedYear' => 'string',
        'trainingAttended' => 'string',
        'previousNational' => 'string',
        'jamboreeAttended' => 'string',
        'jamboreeYear' => 'string',
        'capSize' => 'string',
        'tShirtSize' => 'string',
        'golfShirtSize' => 'string',
        'busRegionID' => 'int',
        'TravelingWithChildren' => 'int',
        'completed' => 'int',
        'gpsCheckDone' => 'int',
        'ConsentLocation' => 'string',
        'busInvoiceLocation' => 'string',
        'applicationApproved' => 'int',
        'applicationApprovedDate' => 'datetime',
        'applicationApprovedBy' => 'int',
        'declinedPosition' => 'int',
        'declinedPositionDate' => 'datetime',
        'declinedPositionBy' => 'int',
        'declinedReason' => 'string',
        'passportGenerated' => 'int',
        'startDate' => 'date',
        'endDate' => 'date',
        'nrOfDays' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

}

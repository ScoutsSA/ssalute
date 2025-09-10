<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class EventBookingSetupChange extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_booking_setup_changes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'name' => 'string',
        'description' => 'string',
        'gpsLat' => 'string',
        'gpsLon' => 'string',
        'costPerPerson' => 'int',
        'depositAmount' => 'int',
        'depositRequiredDate' => 'date',
        'MaxBookings' => 'int',
        'lastBookingDate' => 'date',
        'emailAddress' => 'string',
        'bankName' => 'string',
        'bankAccountHoldersName' => 'string',
        'banlBranchName' => 'string',
        'bankBranchCode' => 'string',
        'bankAccountNumber' => 'string',
        'paymentRederence' => 'string',
        'paymentInFullByDate' => 'date',
        'startAge' => 'int',
        'endAge' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}

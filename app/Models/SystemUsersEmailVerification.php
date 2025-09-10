<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class SystemUsersEmailVerification extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_users_email_verifications';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'emailAddress' => 'string',
        'emailFailedVerification' => 'int',
        'dateVerified' => 'datetime',
        'response' => 'string',
        'responseHeading' => 'string',
        'sentConfirmationEmail' => 'datetime',
        'subjectReceivedBack' => 'string',
        'messageReceivedBack' => 'string',
        'messageReceivedBackDate' => 'datetime',
        'active' => 'int',
        'created' => 'datetime',
    ];

}

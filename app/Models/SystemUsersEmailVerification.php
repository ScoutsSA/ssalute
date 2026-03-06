<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemUsersEmailVerification extends BaseModel
{
    public const UPDATED_AT = null;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }
}

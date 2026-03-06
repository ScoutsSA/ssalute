<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupWeeklyEmailsEmailed extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_weekly_emails_emailed';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToGroup' => 'int',
        'accountID' => 'int',
        'userID' => 'int',
        'programID' => 'int',
        'programDate' => 'date',
        'sentDate' => 'datetime',
        'created' => 'datetime',
        'createdby' => 'int',
        'mailType' => 'string',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'assocToGroup');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(GroupAccount::class, 'accountID');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(GroupProgram::class, 'programID');
    }
}

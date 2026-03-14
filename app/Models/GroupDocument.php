<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupDocument extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_documents';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'docType' => 'int',
        'docArea' => 'string',
        'assocToPerson' => 'int',
        'assocToAccount' => 'int',
        'assocToGroup' => 'int',
        'description' => 'string',
        'location' => 'string',
        'expiryDate' => 'date',
        'active' => 'int',
        'created' => 'date',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'assocToPerson');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(GroupAccount::class, 'assocToAccount');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'assocToGroup');
    }
}

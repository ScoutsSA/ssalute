<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicesPurchasedSpreadsheetsReceived extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'services_purchased_spreadsheets_received';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'groupID' => 'int',
        'receivedDate' => 'datetime',
        'location' => 'string',
        'addedBy' => 'int',
        'active' => 'int',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'groupID');
    }

    public function addedByUser(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'addedBy');
    }
}

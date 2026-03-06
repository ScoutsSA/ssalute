<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvancementNote extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'advancement_notes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'type' => 'int',
        'countryID' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'note' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'advancementFirstID' => 'int',
        'advancementSecondID' => 'int',
        'advancementThirdID' => 'int',
        'active' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'assocToGroup');
    }
}

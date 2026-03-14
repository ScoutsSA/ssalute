<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportChat extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'support_chats';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'supportID' => 'int',
        'userID' => 'int',
        'direction' => 'int',
        'chat' => 'string',
        'created' => 'datetime',
        'active' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function support(): BelongsTo
    {
        return $this->belongsTo(SupportChatsStart::class, 'supportID');
    }
}

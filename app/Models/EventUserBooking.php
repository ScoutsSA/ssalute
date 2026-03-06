<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventUserBooking extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_user_booking';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'status' => 'int',
        'userID' => 'int',
        'travelArrangements' => 'int',
        'accommodationArrangements' => 'int',
        'apparelOption' => 'int',
        'patrolID' => 'int',
        'canAdmin' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function patrol(): BelongsTo
    {
        return $this->belongsTo(EventUserBookingPatrol::class, 'patrolID');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(GroupEvent::class, 'eventID');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(EventUserBookingPayment::class, 'userID', 'userID')
            ->where('eventID', $this->eventID);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(EventUserBookingNote::class, 'userID', 'userID')
            ->where('eventID', $this->eventID);
    }
}

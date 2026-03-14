<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventCompetitionsGroupsParticipating extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competitions_groups_participating';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'teamID' => 'int',
        'internalCompetitionID' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function internalCompetition(): BelongsTo
    {
        return $this->belongsTo(EventCompetitionsInternalCompetition::class, 'internalCompetitionID');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(GroupEvent::class, 'eventID');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(EventCompetitionsGroupsAttending::class, 'teamID');
    }
}

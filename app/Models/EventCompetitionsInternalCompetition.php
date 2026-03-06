<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventCompetitionsInternalCompetition extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competitions_internal_competitions';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'name' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function scoringSheets(): HasMany
    {
        return $this->hasMany(EventCompetitionsScoringSheet::class, 'internalCompetitionID');
    }

    public function scoringAreas(): HasMany
    {
        return $this->hasMany(EventCompetitionsScoringArea::class, 'internalCompetitionID');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(EventCompetitionsQuestion::class, 'internalCompetitionID');
    }

    public function groupsParticipating(): HasMany
    {
        return $this->hasMany(EventCompetitionsGroupsParticipating::class, 'internalCompetitionID');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(GroupEvent::class, 'eventID');
    }
}

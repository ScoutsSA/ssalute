<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventCompetitionsScoringArea extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competitions_scoring_areas';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'internalCompetitionID' => 'int',
        'name' => 'string',
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

    public function questions(): HasMany
    {
        return $this->hasMany(EventCompetitionsQuestion::class, 'scoringAreaID');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(GroupEvent::class, 'eventID');
    }
}

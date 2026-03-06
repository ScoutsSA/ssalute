<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventCompetitionsScoring extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competitions_scoring';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'teamID' => 'int',
        'scoringAreaID' => 'int',
        'scoringSheetID' => 'int',
        'questionID' => 'int',
        'answerID' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedBy' => 'int',
        'notes' => 'string',
    ];

    public function scoringArea(): BelongsTo
    {
        return $this->belongsTo(EventCompetitionsScoringArea::class, 'scoringAreaID');
    }

    public function scoringSheet(): BelongsTo
    {
        return $this->belongsTo(EventCompetitionsScoringSheet::class, 'scoringSheetID');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(EventCompetitionsQuestion::class, 'questionID');
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(EventCompetitionsAnswer::class, 'answerID');
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

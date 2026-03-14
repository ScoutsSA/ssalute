<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventCompetitionsQuestion extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competitions_questions';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'internalCompetitionID' => 'int',
        'scoringAreaID' => 'int',
        'scoringSheetID' => 'int',
        'headingID' => 'int',
        'question' => 'string',
        'position' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function scoringArea(): BelongsTo
    {
        return $this->belongsTo(EventCompetitionsScoringArea::class, 'scoringAreaID');
    }

    public function scoringSheet(): BelongsTo
    {
        return $this->belongsTo(EventCompetitionsScoringSheet::class, 'scoringSheetID');
    }

    public function heading(): BelongsTo
    {
        return $this->belongsTo(EventCompetitionsScoringSheetsHeading::class, 'headingID');
    }

    public function internalCompetition(): BelongsTo
    {
        return $this->belongsTo(EventCompetitionsInternalCompetition::class, 'internalCompetitionID');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(EventCompetitionsAnswer::class, 'questionID');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(GroupEvent::class, 'eventID');
    }
}

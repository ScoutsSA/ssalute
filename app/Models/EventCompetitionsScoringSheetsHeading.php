<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventCompetitionsScoringSheetsHeading extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competitions_scoring_sheets_headings';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'eventID' => 'int',
        'internalCompetitionID' => 'int',
        'scoringSheetID' => 'int',
        'heading' => 'string',
        'position' => 'int',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedBy' => 'int',
    ];

    public function scoringSheet(): BelongsTo
    {
        return $this->belongsTo(EventCompetitionsScoringSheet::class, 'scoringSheetID');
    }

    public function internalCompetition(): BelongsTo
    {
        return $this->belongsTo(EventCompetitionsInternalCompetition::class, 'internalCompetitionID');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(GroupEvent::class, 'eventID');
    }
}

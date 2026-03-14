<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventCompetitionsScoringSheet extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'event_competitions_scoring_sheets';

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
        'startDate' => 'date',
        'startTime' => 'string',
        'endDate' => 'date',
        'endTime' => 'string',
        'usesGPS' => 'int',
        'pdf' => 'int',
        'registration' => 'int',
        'medicalScore' => 'int',
        'seaWorthynessScore' => 'int',
    ];

    public function internalCompetition(): BelongsTo
    {
        return $this->belongsTo(EventCompetitionsInternalCompetition::class, 'internalCompetitionID');
    }

    public function headings(): HasMany
    {
        return $this->hasMany(EventCompetitionsScoringSheetsHeading::class, 'scoringSheetID');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(EventCompetitionsQuestion::class, 'scoringSheetID');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(GroupEvent::class, 'eventID');
    }
}

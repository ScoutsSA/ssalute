<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JamboreeGeneratedPdf extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'jamboree_generated_pdfs';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'jamboreeID' => 'int',
        'subCampID' => 'int',
        'troopID' => 'int',
        'busID' => 'int',
        'userID' => 'int',
        'type' => 'string',
        'PDFLocation' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'userID');
    }

    public function troop(): BelongsTo
    {
        return $this->belongsTo(JamboreeTroop::class, 'troopID');
    }

    public function bus(): BelongsTo
    {
        return $this->belongsTo(JamboreeBusInfo::class, 'busID');
    }

    public function subCamp(): BelongsTo
    {
        return $this->belongsTo(JamboreeSubCamp::class, 'subCampID');
    }
}

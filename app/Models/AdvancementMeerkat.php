<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvancementMeerkat extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'advancement_meerkats';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'programType' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'meerkatID' => 'int',
        'userID' => 'int',
        'themeID' => 'int',
        'advancementID' => 'int',
        'advancementSecondID' => 'int',
        'advancementThirdID' => 'int',
        'notes' => 'string',
        'PDFLocation' => 'string',
        'advancementDate' => 'date',
        'latest' => 'int',
        'instructorsName' => 'string',
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

    public function meerkat(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'meerkatID');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'assocToRegion');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'assocToDistrict');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'assocToGroup');
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(SystemAdvancementMeerkatsChallenge::class, 'themeID');
    }

    public function advancement(): BelongsTo
    {
        return $this->belongsTo(SystemAdvancementMeerkatsLevel::class, 'advancementID');
    }

    public function advancementSecond(): BelongsTo
    {
        return $this->belongsTo(SystemAdvancementMeerkatsSecond::class, 'advancementSecondID');
    }

    public function advancementThird(): BelongsTo
    {
        return $this->belongsTo(SystemAdvancementMeerkatsThird::class, 'advancementThirdID');
    }
}

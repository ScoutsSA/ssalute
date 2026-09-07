<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmsLicenceType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_charge_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'position' => 'int',
        'name' => 'string',
        'forScouts' => 'int',
        'expiryYears' => 'int',
        'shortName' => 'string',
        'description' => 'string',
        'active' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
    ];

    public function licences(): HasMany
    {
        return $this->hasMany(AmsLicenceInfo::class, 'chargeTypeID');
    }

    /**
     * A licence of this type issued on the given date expires exactly this
     * many years later. Plain year arithmetic is used deliberately so a
     * 29 February issue date rolls to 1 March, matching the legacy PHP
     * DateTime::modify('+N years') behaviour in Scouts Digital.
     */
    public function expiryDateFor(CarbonInterface|string $issueDate): CarbonImmutable
    {
        return CarbonImmutable::parse($issueDate)->startOfDay()->addYears($this->expiryYears);
    }
}

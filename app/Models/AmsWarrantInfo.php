<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmsWarrantInfo extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_warrant_info';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'assocToRegion' => 'int',
        'assocToDistrict' => 'int',
        'assocToGroup' => 'int',
        'userID' => 'int',
        'roleID' => 'int',
        'warrantTypeID' => 'int',
        'warrantNr' => 'string',
        'warrantName' => 'string',
        'limited' => 'int',
        'appointment' => 'int',
        'PDFLocation' => 'string',
        'issueDate' => 'date',
        'expireDate' => 'date',
        'cancellationTypeID' => 'int',
        'cancelationNotes' => 'string',
        'expireEmailCount' => 'int',
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

    public function cancellationType(): BelongsTo
    {
        return $this->belongsTo(AmsWarrantCancellationType::class, 'cancellationTypeID');
    }

    public function warrantType(): BelongsTo
    {
        return $this->belongsTo(AmsWarrantType::class, 'warrantTypeID');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(SystemUserType::class, 'roleID');
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
}

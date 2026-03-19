<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmsDocumentType extends BaseModel
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'ams_document_types';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'countryID' => 'int',
        'name' => 'string',
        'description' => 'string',
        'aamForm' => 'int',
        'active' => 'int',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'documentTypeID');
    }
}

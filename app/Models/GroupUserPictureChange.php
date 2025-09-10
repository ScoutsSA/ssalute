<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;

class GroupUserPictureChange extends Model
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'group_user_picture_changes';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'userID' => 'int',
        'pictureLocation' => 'string',
        'created' => 'datetime',
        'createdby' => 'int',
    ];

}

<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;

class CustomDatabaseNotification extends BaseDatabaseNotification
{
    protected $table = 'ssalute_notifications';
}

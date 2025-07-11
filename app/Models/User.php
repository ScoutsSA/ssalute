<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\DB;

class User extends \Illuminate\Foundation\Auth\User
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_users';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'int',
        'oldID' => 'int',
        'username' => 'string',
        'password' => 'string',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function scopeWithPlainPassword(Builder $query): void
    {
        $query->addSelect(DB::raw('CAST(AES_DECRYPT(passwordNew,"' . config('auth.scouts_digital.authentication.encryption_key') . '") AS CHAR(50)) as scouts_digital_plain_text_password'));
    }

    public function getScoutsDigitalPlainTextPassword()
    {
        return $this->newQuery()->where('id', $this->id)->selectRaw('CAST(AES_DECRYPT(passwordNew,"' . config('auth.scouts_digital.authentication.encryption_key') . '") AS CHAR(50)) as scouts_digital_plain_text_password')->first()->scouts_digital_plain_text_password;
    }
}

<?php

namespace App\Models;

use App\Models\V2\V2SystemUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $guarded = [];
    protected $casts = [
        'sd_system_user_id' => 'integer',
        'ssa_number' => 'string',
        'active_user_ssa_role_id' => 'int',
        'is_active' => 'boolean',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',

        'password_changed_at' => 'datetime',
        'last_login_at' => 'datetime',

        'first_name' => 'string',
        'surname' => 'string',
        'phone_number' => 'string',
        'photo' => 'string',
        'thumbnail' => 'string',
        'id_number' => 'string',
        'id_verified_file' => 'string',
        'sex' => 'string',
        'race' => 'string',
        'date_of_birth' => 'date',
        'date_invested' => 'date',

        'address' => 'string',
        'language' => 'string',
        'medical_aid_name' => 'string',
        'medical_aid_number' => 'string',
        'medical_aid_principal_member' => 'string',
        'doctors_name' => 'string',
        'doctors_phone_number' => 'string',
        'allergies' => 'string',
        'medical_conditions' => 'string',
        'emergency_contact_name' => 'string',
        'emergency_contact_phone_number' => 'string',
        'emergency_contact_relationship' => 'string',
        'dietary_requirements' => 'string',
        'religion' => 'string',
        'features_flags' => 'object',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function ssaRoles(): BelongsToMany
    {
        return $this->belongsToMany(SsaRole::class)
            ->using(SsaRoleUser::class)
            ->withTimestamps();
    }

    public function warrants(): BelongsToMany
    {
        return $this->belongsToMany(Warrant::class, 'ssa_role_user', 'user_id', 'related_id')
            ->where('ssa_role_user.related_id', '=', 'Warrant')
            ->using(SsaRoleUser::class)
            ->withTimestamps();
    }

    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class, 'ssa_role_user', 'user_id', 'related_id')
            ->where('ssa_role_user.related_id', '=', 'Section')
            ->using(SsaRoleUser::class)
            ->withTimestamps();
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'ssa_role_user', 'user_id', 'related_id')
            ->where('ssa_role_user.related_id', '=', 'Group')
            ->using(SsaRoleUser::class)
            ->withTimestamps();
    }

    public function districts(): BelongsToMany
    {
        return $this->belongsToMany(District::class, 'ssa_role_user', 'user_id', 'related_id')
            ->where('ssa_role_user.related_id', '=', 'District')
            ->using(SsaRoleUser::class)
            ->withTimestamps();
    }

    public function regions(): BelongsToMany
    {
        return $this->belongsToMany(Region::class, 'ssa_role_user', 'user_id', 'related_id')
            ->where('ssa_role_user.related_id', '=', 'Region')
            ->using(SsaRoleUser::class)
            ->withTimestamps();
    }

    public function sdSystemUser(): HasOne
    {
        return $this->hasOne(V2SystemUser::class, 'id', 'sd_system_user_id');
    }
}

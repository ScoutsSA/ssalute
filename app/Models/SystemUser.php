<?php

namespace App\Models;

use App\Enums\UserBranchTypes;
use App\Enums\UserEnglishProficiency;
use App\Enums\UserRace;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Models\Concerns\IsAuditable;
use App\Models\Concerns\MightHaveCreatedBy;
use App\Models\Concerns\MightHaveModifiedBy;
use App\Providers\AppServiceProvider;
use App\Settings\GeneralSettings;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasDefaultTenant;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class SystemUser extends User implements Auditable, FilamentUser, HasDefaultTenant, HasTenants
{
    use HasFactory;
    use IsAuditable;
    use MightHaveCreatedBy;
    use MightHaveModifiedBy;
    use Notifiable;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_users';

    protected $guarded = [];

    protected $hidden = [
        'passwordNew',
        'uniquePIN',
    ];

    protected $casts = [
        'id' => 'int',
        'oldID' => 'int', // This was from pre-entsha
        'username' => 'string',
        'passwordNew' => 'string', // This needs to be swapped to a hashed password
        'lastPasswordChange' => 'datetime',
        'passwordChangedBy' => 'int',
        'lastLoginDate' => 'datetime',
        'startDate' => 'date',
        'first_name' => 'string',
        'otherName' => 'string',
        'surname' => 'string',
        'previousSurname' => 'string',
        'knownName' => 'string',
        'scoutName' => 'string',
        'photo' => 'string',
        'thumb' => 'string',
        'idNumber' => 'string',
        'IDBookLocation' => 'string',
        'passportNumber' => 'string',
        'passportCountry' => 'int',
        'partnersFullName' => 'string',
        'sex' => UserSex::class,
        'race' => UserRace::class,
        'dob' => 'date',
        'dateInvested' => 'date',
        'multiID' => 'int',
        'packID' => 'int',
        'troopID' => 'int',
        'dateToCubs' => 'datetime',
        'dateToScouts' => 'datetime',
        'scoutPatrolID' => 'int',
        'scoutPatrolTaskID' => 'int',
        'dateToRovers' => 'datetime',
        'phys_address' => 'string',
        'gpsLat' => 'string', // Can be removed - No impact to SD
        'gpsLon' => 'string', // Can be removed - No impact to SD
        'gpsAccuracy' => 'string', // Can be removed - No impact to SD
        'phys_country_id' => 'int', // Deprecated - No Multi-country support
        'postal_address' => 'string',
        'postal_country_id' => 'int', // Deprecated - No Multi-country support
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'user_type' => 'int', // Deprecated version of Primary Role
        'parentType' => 'int', // system_parent_types.id
        'active' => 'int',
        'dateDeactivated' => 'datetime',
        'deactivatedBy' => 'int',
        'assoc_to_account' => 'int',
        'assoc_to_group' => 'int', // Primary Group?
        'branch' => UserBranchTypes::class, // This should be attached to the GROUP or SECTION, not the user
        'assoc_to_district' => 'int',
        'assoc_to_region' => 'int',
        'trainingRegionName' => 'string', // Can be removed - No impact to SD
        'trainingDistrictName' => 'string', // Can be removed - No impact to SD
        'trainingGroupName' => 'string', // Can be removed - No impact to SD
        'language' => 'string', // Deprecated - This is added but never used
        'cellNr' => 'string',
        'officeNr' => 'string',
        'homeNr' => 'string',
        'faxNr' => 'string', // In 2025?
        'responsible_for_payment' => 'int', // This should probably be config on a parent role?
        'mustChangePassword' => 'int',
        'canLogon' => 'int',
        'medicalAidName' => 'string',
        'medicalAidNr' => 'string',
        'medicalAidPrincipalMember' => 'string',
        'doctorsName' => 'string',
        'doctorsPhone' => 'string',
        'allergies' => 'string',
        'allergiesInstructions' => 'string',
        'disabilities' => 'string',
        'disabilitiesInstructions' => 'string',
        'medicalConditions' => 'string',
        'medicalConditionsInstructions' => 'string',
        'currentMedication' => 'string',
        'emergencyContactName' => 'string',
        'emergencyContactCell' => 'string',
        'emergencyContactTel' => 'string',
        'emergencyContactRelationship' => 'string',
        'specialMealRequirements' => 'string',
        'religiousAffilliation' => 'string', // Should be merged with religion, religiousAffiliation and religiousBelief
        'school' => 'string',
        'religion' => 'string', // Should be merged with religiousAffilliation, religiousAffiliation and religiousBelief
        'religiousAffiliation' => 'string', // Should be merged with religion, religiousAffilliation and religiousBelief
        'hobbies' => 'string',
        'sports' => 'string',
        'interests' => 'string',
        'canAdmin' => 'int', // Can be removed - No impact to SD
        '100CharID' => 'string', // This is used as a type of remember_me cookie. If it's not set, things still work. A proper remember_me token should be used here
        'uniquePIN' => 'int', // Deprecated - This is added but never used
        'weeklyEmailUnsubscribe' => 'int', // Can be removed - No impact to SD
        'weeklyEmailUnsubscribeText' => 'string', // Can be removed - No impact to SD
        'weeklyEmailUnsubscribeDate' => 'datetime', // Can be removed - No impact to SD
        'logonEmailSent' => 'int', // Can be removed - No impact to SD
        'LogonEmailDate' => 'datetime', // Can be removed - No impact to SD
        'amsOnly' => 'int', // Deprecated - This is added but never used
        'amsRole' => 'int', // Deprecated - This seems to be a legacy of the old role system
        'homeLanguage' => 'int',
        'otherLanguage' => 'int',
        'otherLanguages' => 'string',
        'proficiencyInEnglish' => UserEnglishProficiency::class,
        'religiousBelief' => 'string',
        'highestEducation' => 'int',
        'nrOfChildrenBoys' => 'int',
        'nrOfChildrenGirls' => 'int',
        'occupation' => 'string',
        'typeOfEmployment' => 'string',
        'employer' => 'string',
        'maritalStatus' => 'int',
        'ref1Name' => 'string', // Can be removed - No impact to SD
        'ref1Address' => 'string', // Can be removed - No impact to SD
        'ref1Tel' => 'string', // Can be removed - No impact to SD
        'ref2Name' => 'string', // Can be removed - No impact to SD
        'ref2Address' => 'string', // Can be removed - No impact to SD
        'ref2Tel' => 'string', // Can be removed - No impact to SD
        'newsletterUnsubscribe' => 'int', // Can be removed - No impact to SD
        'newsletterUnsubscribeDate' => 'datetime', // Can be removed - No impact to SD
        'reportView' => 'int', // Can be removed - No impact to SD
        'roverGroupID' => 'int', // Can be removed - No impact to SD
        'roverGroupRoleID' => 'int', // Can be removed - No impact to SD
        'roverGroupAccountID' => 'int', // Can be removed - No impact to SD
        '24WSJ' => 'int', // Deprecated - World Scout Jamboree 2024
        '24WSJRole' => 'int', // Deprecated - World Scout Jamboree 2024
        '24wsjNotListedDistrict' => 'string', // Deprecated - World Scout Jamboree 2024
        '24wsjNotListedGroup' => 'string', // Deprecated - World Scout Jamboree 2024
        'SANJamb2017' => 'int', // Deprecated - South African National Jamboree 2017
        'SANJamb2017Role' => 'string', // Deprecated - South African National Jamboree 2017
        'sanJambNotListedRegion' => 'string', // Deprecated - South African National Jamboree 2017
        'sanJambNotListedDistrict' => 'string', // Deprecated - South African National Jamboree 2017
        'sanJambNotListedGroup' => 'string', // Deprecated - South African National Jamboree 2017
        'infoRedacted' => 'int',
        'SSANumber' => 'string', // Deprecated? Seems to be referenced as InternalNumber,
        'orphaned' => 'int',
        'vulnerable' => 'int',
        'sendAMSMail' => 'int', // Can be removed - No impact to SD
        'generalNotes' => 'string',
        'form29Generated' => 'int',
        'logonEmail' => 'int', // Feature Flag for if we should send an email when the user logs in
        'weeklyProgramEmail' => 'int',
        'profileChangesEmail' => 'int',
        'newsletterEmail' => 'int',
        'lowerStaffProfileChanges' => 'int',
        'loggedInTo20' => 'int', // Can be removed - No impact to SD
        'canLogonTo20' => 'int', // This is set in a few places but never seems to be used
        'adultRecruit' => 'int', // Deprecated - This seems to be a flag to send the user to a page where they must enter their AAM details
        'addedIn' => 'int', // Deprecated - This seems to have been a legacy flag, currently it's always hardcoded to 2 and the value is never read
        'canAdminElearning' => 'int', // Deprecated
        'canAdminElearningCourses' => 'int', // Deprecated
        'view' => 'int', // Unknown - searching for this is rather difficult
        'docsDeleted' => 'int', // If a user isn't active and has a dateDeactivated in the past, AdvancementPhotos and AdvancementDocuments are deleted permanently and this flag tracks if that's happened
        'takenSurvey' => 'int', // Deprecated
        'ddValue' => 'int', // This appears to be a per_page store, only used in a few ams adult management places
        'DSDHostelName' => 'string',
        'DSDTownshipName' => 'string',
        'DSDDisabled' => 'int',
    ];

    /*******************
     * Relationships
     *******************/

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(SystemUserType::class, 'system_users_other_roles', 'userID', 'roleID', 'id', 'id')
            ->using(SystemUsersOtherRole::class)
            ->withPivot(
                [
                    'id',
                    'regionID',
                    'superDistrictID',
                    'districtID',
                    'groupID',
                    'roleID',
                    'defaultRole',
                    'active',
                    'creationNotes',
                    'actionCountryID',
                    'actionRegionID',
                    'actionSuperDistrictID',
                    'actionDistrictID',
                    'actionGroupID',
                    'retired',
                    'resigned',
                    'suspended',
                    'multiID',
                    'created',
                    'createdby',
                    'modified',
                    'modifiedby',
                ]);
    }

    public function activeRoles(): BelongsToMany
    {
        return $this->roles()
            ->wherePivot('active', 1);
        /* There seems to be a lot of bad data here, the below query SHOULD be correct but it filters out too many records
        ->wherePivot('retired', 0)
        ->wherePivot('resigned', 0)
        ->wherePivot('suspended', 0)*/
    }

    public function pastRoles(): BelongsToMany
    {
        return $this->roles()
            ->wherePivot('active', 0);
        /* There seems to be a lot of bad data here, the below query SHOULD be correct but it filters out too many records
         ->where(function ($query) {
            $query->where('system_users_other_roles.retired', 1)
                ->orWhere('system_users_other_roles.resigned', 1)
                ->orWhere('system_users_other_roles.suspended', 1);
        })*/
    }

    public function roleAttachments(): HasMany
    {
        return $this->hasMany(SystemUsersOtherRole::class, 'userID', 'id');
    }

    public function activeRoleAttachments(): HasMany
    {
        return $this->roleAttachments()->where('active', 1);
    }

    public function inactiveRoleAttachments(): HasMany
    {
        return $this->roleAttachments()->where('active', 0);
    }

    public function warrants(): HasMany
    {
        return $this->hasMany(AmsWarrantInfo::class, 'userID', 'id');
    }

    public function activeWarrants(): HasMany
    {
        return $this->warrants()->where('active', 1);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'userID', 'id');
    }

    public function trainingHistory(): HasMany
    {
        return $this->hasMany(PastTraining::class, 'userID', 'id');
    }

    public function awards(): HasMany
    {
        return $this->hasMany(Award::class, 'userID', 'id');
    }

    public function performedAudits(): HasMany
    {
        return $this->hasMany(Audit::class, 'user_id');
    }

    public function policeClearances(): HasMany
    {
        return $this->hasMany(AmsPoliceClearance::class, 'userID', 'id');
    }

    public function pastService(): HasMany
    {
        return $this->hasMany(PastService::class, 'userID', 'id');
    }

    public function latestPoliceClearance(): HasOne
    {
        return $this->hasOne(AmsPoliceClearance::class, 'userID', 'id')
            ->latestOfMany('dateDone');
    }

    public function membershipCertificate(): HasOne
    {
        return $this->hasOne(MembershipCertificate::class, 'user_id');
    }

    public function licenceInfos(): HasMany
    {
        return $this->hasMany(AmsLicenceInfo::class, 'userID', 'id');
    }

    public function disciplinaryInfos(): HasMany
    {
        return $this->hasMany(AmsDisciplinaryInfo::class, 'userID', 'id');
    }

    public function criminalChecks(): HasMany
    {
        return $this->hasMany(AmsCriminalCheck::class, 'userID', 'id');
    }

    public function awardApplications(): HasMany
    {
        return $this->hasMany(AmsAwardApplication::class, 'userID', 'id');
    }

    public function warrantApplications(): HasMany
    {
        return $this->hasMany(AmsWarrantApplication::class, 'userID', 'id');
    }

    public function warrantExtensions(): HasMany
    {
        return $this->hasMany(AmsWarrantExtension::class, 'userID', 'id');
    }

    public function resignals(): HasMany
    {
        return $this->hasMany(AmsResignLeader::class, 'userID', 'id');
    }

    public function retirements(): HasMany
    {
        return $this->hasMany(AmsRetireLeader::class, 'userID', 'id');
    }

    public function suspensions(): HasMany
    {
        return $this->hasMany(AmsSuspendLeader::class, 'userID', 'id');
    }

    public function terminations(): HasMany
    {
        return $this->hasMany(AmsTerminateLeader::class, 'userID', 'id');
    }

    public function adultLeaderMoves(): HasMany
    {
        return $this->hasMany(AmsAdultLeaderMove::class, 'userID', 'id');
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(GroupAttendance::class, 'userId', 'id');
    }

    public function responsiblePrograms(): HasMany
    {
        return $this->hasMany(GroupProgram::class, 'responsibleScouter', 'id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'userID', 'id');
    }

    public function supportChats(): HasMany
    {
        return $this->hasMany(SupportChat::class, 'userID', 'id');
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportChatsStart::class, 'userID', 'id');
    }

    public function logging(): HasMany
    {
        return $this->hasMany(SystemUserLogging::class, 'userID', 'id');
    }

    public function pictureChanges(): HasMany
    {
        return $this->hasMany(GroupUserPictureChange::class, 'userID', 'id');
    }

    public function emergencyContacts(): HasMany
    {
        return $this->hasMany(SystemUsersEmergencyContact::class, 'userID', 'id');
    }

    public function maritalStatusInfo(): BelongsTo
    {
        return $this->belongsTo(AmsMaritalStatus::class, 'maritalStatus');
    }

    public function highestEducationInfo(): BelongsTo
    {
        return $this->belongsTo(AmsHighestEducation::class, 'highestEducation');
    }

    public function homeLanguageInfo(): BelongsTo
    {
        return $this->belongsTo(AmsLanguage::class, 'homeLanguage');
    }

    public function otherLanguageInfo(): BelongsTo
    {
        return $this->belongsTo(AmsLanguage::class, 'otherLanguage');
    }

    public function pack(): BelongsTo
    {
        return $this->belongsTo(GroupCubPack::class, 'packID');
    }

    public function troop(): BelongsTo
    {
        return $this->belongsTo(GroupScoutTroop::class, 'troopID');
    }

    public function scoutPatrol(): BelongsTo
    {
        return $this->belongsTo(GroupScoutsPatrolName::class, 'scoutPatrolID');
    }

    /*******************
     * Scopes
     *******************/
    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function scopeInactive(Builder $query): void
    {
        $query->where('active', 0);
    }

    public function scopeWithPlainPassword(Builder $query): void
    {
        $query->addSelect(DB::raw('CAST(AES_DECRYPT(passwordNew,"' . config('auth.scouts_digital.authentication.encryption_key') . '") AS CHAR(50)) as scouts_digital_plain_text_password'));
    }

    public function name(): Attribute // Note this is used for the Filament Name as well
    {
        return Attribute::make(
            get: fn () => (! blank($this->knownName) ? $this->knownName : $this->first_name) . ' ' . $this->surname,
        );
    }

    public function ssaId(): Attribute // Note this is used for the Filament Name as well
    {
        return Attribute::make(
            get: fn () => 'SSA ID-' . str_pad($this->id, 7, '0', STR_PAD_LEFT)
        );
    }

    /*******************
     * Functions
     *******************/
    public function getScoutsDigitalPlainTextPassword(): string
    {
        return $this->newQuery()->where('id', $this->id)->selectRaw('CAST(AES_DECRYPT(passwordNew,"' . config('auth.scouts_digital.authentication.encryption_key') . '") AS CHAR(50)) as scouts_digital_plain_text_password')->first()->scouts_digital_plain_text_password;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->isSuperAdmin(),
            'general' => $this->hasAnyActiveRole(),
            default => false,
        };
    }

    public function hasManagementRole(): bool
    {
        return $this->roleAttachments()
            ->where('active', 1)
            ->whereHas('role', fn ($q) => $q
                ->where('nationalRole', 1)
                ->orWhere('regionalRole', 1)
                ->orWhere('superDistrictRole', 1)
                ->orWhere('districtRole', 1)
            )
            ->exists();
    }

    public function hasAnyActiveRole(): bool
    {
        return $this->roleAttachments()
            ->where('active', 1)
            ->exists();
    }

    public function getTenants(Panel $panel): Collection
    {
        return match ($panel->getId()) {
            'general' => $this->roleAttachments()
                ->where('active', 1)
                ->with(['role', 'region', 'district', 'group'])
                ->get(),
            default => collect(),
        };
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->roleAttachments()
            ->where('id', $tenant->getKey())
            ->where('active', 1)
            ->exists();
    }

    public function getDefaultTenant(Panel $panel): ?Model
    {
        $tenants = $this->getTenants($panel);

        return $tenants->firstWhere('defaultRole', 1) ?? $tenants->first();
    }

    public function isSuperAdmin(): bool
    {
        if ($this->username === config('ssalute.superuser_email')) {
            return true;
        }
        if (in_array($this->id, resolve(GeneralSettings::class)->super_user_admin_list, false)) {
            return true;
        }

        return false;
    }

    public function canImpersonate()
    {
        return $this->isSuperAdmin();
    }

    public function canBeImpersonated()
    {
        return ! $this->isSuperAdmin();
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function setEncryptedPassword(string $plain): void
    {
        $key = config('auth.scouts_digital.authentication.encryption_key');

        DB::table($this->getTable())
            ->where($this->getKeyName(), $this->getKey())
            ->update([
                'passwordNew' => DB::raw("AES_ENCRYPT('{$plain}', '{$key}')"),
            ]);
    }

    /*******************
     * Password Reset
     *******************/
    public function getEmailForPasswordReset(): string
    {
        return $this->username;
    }

    public function routeNotificationForMail(): string
    {
        return $this->username;
    }

    /*******************
     * Attributes
     *******************/
    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => filled($value) ? UserTitle::tryFrom($value) : null,
            set: fn (mixed $value) => $value instanceof UserTitle ? $value->value : $value,
        );
    }
}

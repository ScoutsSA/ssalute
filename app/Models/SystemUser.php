<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use App\Settings\GeneralSettings;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;

class SystemUser extends User implements FilamentUser
{
    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_users';

    protected $guarded = [];

    protected $hidden = [
        'passwordNew',
        'uniquePIN',
    ];

    protected $casts = [
        'id' => 'int',
        'oldID' => 'int',
        'username' => 'string',
        'passwordNew' => 'string',
        'lastPasswordChange' => 'datetime',
        'passwordChangedBy' => 'int',
        'lastLoginDate' => 'datetime',
        'startDate' => 'date',
        'title' => 'string',
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
        'sex' => 'string',
        'race' => 'string',
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
        'gpsLat' => 'string',
        'gpsLon' => 'string',
        'gpsAccuracy' => 'string',
        'phys_country_id' => 'int',
        'postal_address' => 'string',
        'postal_country_id' => 'int',
        'created' => 'datetime',
        'createdby' => 'int',
        'modified' => 'datetime',
        'modifiedby' => 'int',
        'user_type' => 'int',
        'parentType' => 'int',
        'active' => 'int',
        'dateDeactivated' => 'datetime',
        'deactivatedBy' => 'int',
        'assoc_to_account' => 'int',
        'assoc_to_group' => 'int',
        'branch' => 'string',
        'assoc_to_district' => 'int',
        'assoc_to_region' => 'int',
        'trainingRegionName' => 'string',
        'trainingDistrictName' => 'string',
        'trainingGroupName' => 'string',
        'language' => 'string',
        'cellNr' => 'string',
        'officeNr' => 'string',
        'homeNr' => 'string',
        'faxNr' => 'string',
        'responsible_for_payment' => 'int',
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
        'religiousAffilliation' => 'string',
        'school' => 'string',
        'religion' => 'string',
        'religiousAffiliation' => 'string',
        'hobbies' => 'string',
        'sports' => 'string',
        'interests' => 'string',
        'canAdmin' => 'int',
        '100CharID' => 'string',
        'uniquePIN' => 'int',
        'weeklyEmailUnsubscribe' => 'int',
        'weeklyEmailUnsubscribeText' => 'string',
        'weeklyEmailUnsubscribeDate' => 'datetime',
        'logonEmailSent' => 'int',
        'LogonEmailDate' => 'datetime',
        'amsOnly' => 'int',
        'amsRole' => 'int',
        'homeLanguage' => 'int',
        'otherLanguage' => 'int',
        'otherLanguages' => 'string',
        'proficiencyInEnglish' => 'int',
        'religiousBelief' => 'string',
        'highestEducation' => 'int',
        'nrOfChildrenBoys' => 'int',
        'nrOfChildrenGirls' => 'int',
        'occupation' => 'string',
        'typeOfEmployment' => 'string',
        'employer' => 'string',
        'maritalStatus' => 'int',
        'ref1Name' => 'string',
        'ref1Address' => 'string',
        'ref1Tel' => 'string',
        'ref2Name' => 'string',
        'ref2Address' => 'string',
        'ref2Tel' => 'string',
        'newsletterUnsubscribe' => 'int',
        'newsletterUnsubscribeDate' => 'datetime',
        'reportView' => 'int',
        'roverGroupID' => 'int',
        'roverGroupRoleID' => 'int',
        'roverGroupAccountID' => 'int',
        '24WSJ' => 'int',
        '24WSJRole' => 'int',
        '24wsjNotListedDistrict' => 'string',
        '24wsjNotListedGroup' => 'string',
        'SANJamb2017' => 'int',
        'SANJamb2017Role' => 'string',
        'sanJambNotListedRegion' => 'string',
        'sanJambNotListedDistrict' => 'string',
        'sanJambNotListedGroup' => 'string',
        'infoRedacted' => 'int',
        'SSANumber' => 'string',
        'orphaned' => 'int',
        'vulnerable' => 'int',
        'sendAMSMail' => 'int',
        'generalNotes' => 'string',
        'form29Generated' => 'int',
        'logonEmail' => 'int',
        'weeklyProgramEmail' => 'int',
        'profileChangesEmail' => 'int',
        'newsletterEmail' => 'int',
        'lowerStaffProfileChanges' => 'int',
        'loggedInTo20' => 'int',
        'canLogonTo20' => 'int',
        'adultRecruit' => 'int',
        'addedIn' => 'int',
        'canAdminElearning' => 'int',
        'canAdminElearningCourses' => 'int',
        'view' => 'int',
        'docsDeleted' => 'int',
        'takenSurvey' => 'int',
        'ddValue' => 'int',
        'DSDHostelName' => 'string',
        'DSDTownshipName' => 'string',
        'DSDDisabled' => 'int',
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

    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->username === config('ssalute.superuser_email')) {
            return true;
        }
        if (in_array($this->id, resolve(GeneralSettings::class)->super_user_admin_list, false)) {
            return true;
        }

        return false;
    }

    public function name(): Attribute // Note this is used for the Filament Name as well
    {
        return Attribute::make(
            get: fn () => $this->first_name . ' ' . $this->surname,
        );
    }

    public function ssaId(): Attribute // Note this is used for the Filament Name as well
    {
        return Attribute::make(
            get: fn () => 'SSA ID-' . str_pad($this->id, 7, '0', STR_PAD_LEFT)
        );
    }
}

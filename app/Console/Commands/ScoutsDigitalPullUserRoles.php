<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\V2\V2SystemUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ScoutsDigitalPullUserRoles extends Command
{
    protected $signature = 'sd:pull-user-roles';
    protected $description = 'Pulls Users from Scouts Digital';

    public function handle()
    {
        Log::info('ScoutsDigitalPullUsers - Pulling Data...');
        $modelAddedCounter = 0;
        foreach (V2SystemUser::active()->inRandomOrder()->get() as $v2Model) {
            $newModel = User::firstOrCreate([
                'sd_system_user_id' => $v2Model->id, ],
                [
                    'ssa_number' => $v2Model->SSANumber,
                    'active_user_ssa_role_id' => null,
                    'is_active' => $v2Model->active,
                    'email' => $v2Model->username,
                    'email_verified_at' => null,
                    'password' => 'ToBeImmediatelyChanged',
                    'password_changed_at' => $v2Model->lastPasswordChange,
                    'last_login_at' => $v2Model->lastLoginDate,

                    'first_name' => $v2Model->first_name,
                    'surname' => $v2Model->surname,
                    'phone_number' => Str::of($v2Model->cellNr)->limit(20),
                    'photo' => $v2Model->photo,
                    'thumbnail' => $v2Model->thumb,
                    'id_number' => $v2Model->idNumber,
                    'id_verified_file' => null,
                    'sex' => $v2Model->sex,
                    'race' => $v2Model->race,
                    'date_of_birth' => ($v2Model->dob !== '0000-00-00' ? Carbon::parse($v2Model->dob) : null),
                    'date_invested' => $v2Model->dateInvested,

                    'address' => $v2Model->phys_address,
                    'language' => $v2Model->language,
                    'medical_aid_name' => $v2Model->medicalAidName,
                    'medical_aid_number' => $v2Model->medicalAidNr,
                    'medical_aid_principal_member' => $v2Model->medicalAidPrincipalMember,
                    'doctors_name' => $v2Model->doctorsName,
                    'doctors_phone_number' => Str::of($v2Model->doctorsPhone)->limit(20),
                    'allergies' => $v2Model->allergies,
                    'medical_conditions' => $v2Model->medicalConditions,
                    'emergency_contact_name' => $v2Model->emergencyContactName,
                    'emergency_contact_phone_number' => Str::of($v2Model->emergencyContactCell ?? $v2Model->emergencyContactTel)->limit(20),
                    'emergency_contact_relationship' => $v2Model->emergencyContactRelationship,
                    'dietary_requirements' => $v2Model->specialMealRequirements,
                    'religion' => $v2Model->religion ?? $v2Model->religiousAffilliation ?? $v2Model->religiousAffiliation ?? $v2Model->religiousBelief,
                ]);
            if ($newModel->wasRecentlyCreated) {
                $modelAddedCounter++;
                $newModel->update(['password' => Hash::make(V2SystemUser::where('id', $v2Model->getKey())->selectRaw('CAST(AES_DECRYPT(passwordNew,"' . config('auth.scouts_digital.authentication.encryption_key') . '") AS CHAR(50)) as scouts_digital_plain_text_password')->first()->scouts_digital_plain_text_password)]);
                Log::info('ScoutsDigitalPullUsers - Added new model', ['id' => $newModel->getKey(), 'name' => $newModel->name]);
            }
        }
        Log::info('ScoutsDigitalPullUsers - Finished Pulling data!', ['new_models_added' => $modelAddedCounter]);
    }
}

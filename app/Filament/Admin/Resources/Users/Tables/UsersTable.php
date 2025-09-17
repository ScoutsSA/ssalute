<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use App\Models\SystemUser;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use STS\FilamentImpersonate\Actions\Impersonate;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('id')
                    ->description(fn (SystemUser $model) => $model->ssa_id)
                    ->toggleable()
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('oldID')
                    ->label('oldID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('username')
                    ->label('username')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('lastPasswordChange')
                    ->label('lastPasswordChange')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('lastLoginDate')
                    ->label('lastLoginDate')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('startDate')
                    ->label('startDate')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('title')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('first_name')
                    ->label('first_name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('otherName')
                    ->label('otherName')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('surname')
                    ->label('surname')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('previousSurname')
                    ->label('previousSurname')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('knownName')
                    ->label('knownName')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('scoutName')
                    ->label('scoutName')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('photo')
                    ->label('photo')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('thumb')
                    ->label('thumb')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('idNumber')
                    ->label('idNumber')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('IDBookLocation')
                    ->label('IDBookLocation')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('passportNumber')
                    ->label('passportNumber')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('passportCountry')
                    ->label('passportCountry')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('partnersFullName')
                    ->label('partnersFullName')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('sex')
                    ->label('sex')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('race')
                    ->label('race')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('dob')
                    ->label('dob')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                TextColumn::make('dateInvested')
                    ->label('dateInvested')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                TextColumn::make('multiID')
                    ->label('multiID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('packID')
                    ->label('packID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('troopID')
                    ->label('troopID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dateToCubs')
                    ->label('dateToCubs')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('dateToScouts')
                    ->label('dateToScouts')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('scoutPatrolID')
                    ->label('scoutPatrolID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('scoutPatrolTaskID')
                    ->label('scoutPatrolTaskID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dateToRovers')
                    ->label('dateToRovers')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('gpsLat')
                    ->label('gpsLat')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('gpsLon')
                    ->label('gpsLon')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('gpsAccuracy')
                    ->label('gpsAccuracy')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('phys_country_id')
                    ->label('phys_country_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('postal_country_id')
                    ->label('postal_country_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created')
                    ->label('created')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('createdby')
                    ->label('createdby')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('modified')
                    ->label('modified')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('modifiedby')
                    ->label('modifiedby')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user_type')
                    ->label('user_type')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('parentType')
                    ->label('parentType')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('active')
                    ->label('active')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dateDeactivated')
                    ->label('dateDeactivated')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('deactivatedBy')
                    ->label('deactivatedBy')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('assoc_to_account')
                    ->label('assoc_to_account')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('assoc_to_group')
                    ->label('assoc_to_group')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('branch')
                    ->label('branch')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('assoc_to_district')
                    ->label('assoc_to_district')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('assoc_to_region')
                    ->label('assoc_to_region')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('trainingRegionName')
                    ->label('trainingRegionName')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('trainingDistrictName')
                    ->label('trainingDistrictName')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('trainingGroupName')
                    ->label('trainingGroupName')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('language')
                    ->label('language')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('cellNr')
                    ->label('cellNr')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('officeNr')
                    ->label('officeNr')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('homeNr')
                    ->label('homeNr')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('faxNr')
                    ->label('faxNr')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('responsible_for_payment')
                    ->label('responsible_for_payment')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('mustChangePassword')
                    ->label('mustChangePassword')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('canLogon')
                    ->label('canLogon')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('medicalAidName')
                    ->label('medicalAidName')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('medicalAidNr')
                    ->label('medicalAidNr')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('medicalAidPrincipalMember')
                    ->label('medicalAidPrincipalMember')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('doctorsName')
                    ->label('doctorsName')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('doctorsPhone')
                    ->label('doctorsPhone')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('allergies')
                    ->label('allergies')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('medicalConditions')
                    ->label('medicalConditions')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('emergencyContactName')
                    ->label('emergencyContactName')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('emergencyContactCell')
                    ->label('emergencyContactCell')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('emergencyContactTel')
                    ->label('emergencyContactTel')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('emergencyContactRelationship')
                    ->label('emergencyContactRelationship')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('religiousAffilliation')
                    ->label('religiousAffilliation')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('school')
                    ->label('school')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('religion')
                    ->label('religion')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('religiousAffiliation')
                    ->label('religiousAffiliation')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('canAdmin')
                    ->label('canAdmin')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('100CharID')
                    ->label('100CharID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('uniquePIN')
                    ->label('uniquePIN')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('weeklyEmailUnsubscribe')
                    ->label('weeklyEmailUnsubscribe')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('weeklyEmailUnsubscribeDate')
                    ->label('weeklyEmailUnsubscribeDate')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('logonEmailSent')
                    ->label('logonEmailSent')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('LogonEmailDate')
                    ->label('LogonEmailDate')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('amsOnly')
                    ->label('amsOnly')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('amsRole')
                    ->label('amsRole')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('homeLanguage')
                    ->label('homeLanguage')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('otherLanguage')
                    ->label('otherLanguage')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('proficiencyInEnglish')
                    ->label('proficiencyInEnglish')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('religiousBelief')
                    ->label('religiousBelief')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('highestEducation')
                    ->label('highestEducation')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nrOfChildrenBoys')
                    ->label('nrOfChildrenBoys')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nrOfChildrenGirls')
                    ->label('nrOfChildrenGirls')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('occupation')
                    ->label('occupation')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('typeOfEmployment')
                    ->label('typeOfEmployment')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('employer')
                    ->label('employer')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('maritalStatus')
                    ->label('maritalStatus')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ref1Name')
                    ->label('ref1Name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('ref1Tel')
                    ->label('ref1Tel')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('ref2Name')
                    ->label('ref2Name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('ref2Tel')
                    ->label('ref2Tel')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('newsletterUnsubscribe')
                    ->label('newsletterUnsubscribe')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('newsletterUnsubscribeDate')
                    ->label('newsletterUnsubscribeDate')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('reportView')
                    ->label('reportView')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('roverGroupID')
                    ->label('roverGroupID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('roverGroupRoleID')
                    ->label('roverGroupRoleID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('roverGroupAccountID')
                    ->label('roverGroupAccountID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('24WSJ')
                    ->label('24WSJ')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('24WSJRole')
                    ->label('24WSJRole')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('24wsjNotListedDistrict')
                    ->label('24wsjNotListedDistrict')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('24wsjNotListedGroup')
                    ->label('24wsjNotListedGroup')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('SANJamb2017')
                    ->label('SANJamb2017')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('SANJamb2017Role')
                    ->label('SANJamb2017Role')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('sanJambNotListedRegion')
                    ->label('sanJambNotListedRegion')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('sanJambNotListedDistrict')
                    ->label('sanJambNotListedDistrict')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('sanJambNotListedGroup')
                    ->label('sanJambNotListedGroup')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('infoRedacted')
                    ->label('infoRedacted')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('SSANumber')
                    ->label('SSANumber')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('orphaned')
                    ->label('orphaned')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('vulnerable')
                    ->label('vulnerable')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sendAMSMail')
                    ->label('sendAMSMail')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('form29Generated')
                    ->label('form29Generated')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('logonEmail')
                    ->label('logonEmail')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('weeklyProgramEmail')
                    ->label('weeklyProgramEmail')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('profileChangesEmail')
                    ->label('profileChangesEmail')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('newsletterEmail')
                    ->label('newsletterEmail')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lowerStaffProfileChanges')
                    ->label('lowerStaffProfileChanges')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('loggedInTo20')
                    ->label('loggedInTo20')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('canLogonTo20')
                    ->label('canLogonTo20')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('adultRecruit')
                    ->label('adultRecruit')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('addedIn')
                    ->label('addedIn')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('canAdminElearning')
                    ->label('canAdminElearning')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('canAdminElearningCourses')
                    ->label('canAdminElearningCourses')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('view')
                    ->label('view')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('docsDeleted')
                    ->label('docsDeleted')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('takenSurvey')
                    ->label('takenSurvey')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ddValue')
                    ->label('ddValue')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('DSDHostelName')
                    ->label('DSDHostelName')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('DSDTownshipName')
                    ->label('DSDTownshipName')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('DSDDisabled')
                    ->label('DSDDisabled')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Impersonate::make()
                    ->redirectTo(route('home')),
                Action::make('SD_Login')
                    ->label('Impersonate on SD')
                    ->action(function (SystemUser $record, Component $livewire) {
                        // This is a bit hacky
                        Log::info('Impersonate on SD action initiated', ['user_id' => Auth::id(), 'impersonating_username' => $record->username]);
                        $username = addslashes($record->username);
                        $password = addslashes($record->getScoutsDigitalPlainTextPassword());
                        $url = config('ssalute.scouts_digital_url') . '/includes/logon-action.php';

                        return $livewire->js("
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{$url}';
                            form.target = '_blank';

                            const usernameField = document.createElement('input');
                            usernameField.type = 'hidden';
                            usernameField.name = 'username';
                            usernameField.value = '{$username}';
                            form.appendChild(usernameField);

                            const passwordField = document.createElement('input');
                            passwordField.type = 'hidden';
                            passwordField.name = 'password';
                            passwordField.value = '{$password}';
                            form.appendChild(passwordField);

                            const termsField = document.createElement('input');
                            termsField.type = 'hidden';
                            termsField.name = 'agree';
                            termsField.value = '1';
                            form.appendChild(termsField);

                            document.body.appendChild(form);
                            form.submit();
                            setTimeout(() => {
                                if (document.body.contains(form)) {
                                    document.body.removeChild(form);
                                }
                            }, 100);
                        ");
                    }),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use App\Models\SystemUser;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\URL;
use STS\FilamentImpersonate\Actions\Impersonate;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->description(fn (SystemUser $model) => $model->ssa_id)
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('username')
                    ->label('Username/Email')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Name')
                    ->toggleable()
                    ->searchable(['first_name', 'surname']),

                ColumnGroup::make('Name Details', [
                    TextColumn::make('title')
                        ->label('Title')
                        ->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('first_name')
                        ->label('First Name')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('otherName')
                        ->label('Other Name')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('surname')
                        ->label('Surname')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('previousSurname')
                        ->label('Previous Surname')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('knownName')
                        ->label('Known Name')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('scoutName')
                        ->label('Scout Name')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                ]),

                ColumnGroup::make('Contact', [
                    TextColumn::make('cellNr')
                        ->label('Cell')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('officeNr')
                        ->label('Office')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('homeNr')
                        ->label('Home')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('faxNr')
                        ->label('Fax')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                ]),

                ColumnGroup::make('Dates', [
                    TextColumn::make('startDate')
                        ->label('Start Date')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->date()
                        ->sortable(),
                    TextColumn::make('dateInvested')
                        ->label('Date Invested')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->date()
                        ->sortable(),
                    TextColumn::make('dob')
                        ->label('Date of Birth')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->date()
                        ->sortable(),
                    TextColumn::make('lastLoginDate')
                        ->label('Last Login')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->dateTime()
                        ->sortable(),
                    TextColumn::make('lastPasswordChange')
                        ->label('Last Password Change')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->dateTime()
                        ->sortable(),
                    TextColumn::make('dateDeactivated')
                        ->label('Date Deactivated')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->dateTime()
                        ->sortable(),
                ]),

                ColumnGroup::make('Identity', [
                    TextColumn::make('SSANumber')
                        ->label('SSA Number')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('idNumber')
                        ->label('ID Number')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('passportNumber')
                        ->label('Passport')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('sex')
                        ->label('Sex')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->sortable(),
                    TextColumn::make('race')
                        ->label('Race')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->sortable(),
                ]),

                ColumnGroup::make('Association', [
                    TextColumn::make('assoc_to_region')
                        ->label('Region')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->numeric()
                        ->sortable(),
                    TextColumn::make('assoc_to_district')
                        ->label('District')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->numeric()
                        ->sortable(),
                    TextColumn::make('assoc_to_group')
                        ->label('Group')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->numeric()
                        ->sortable(),
                    TextColumn::make('branch')
                        ->label('Branch')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                ]),

                ColumnGroup::make('Account Status', [
                    TextColumn::make('active')
                        ->label('Active')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->numeric()
                        ->sortable(),
                    TextColumn::make('canLogon')
                        ->label('Can Logon')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->numeric()
                        ->sortable(),
                    TextColumn::make('user_type')
                        ->label('User Type')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->numeric()
                        ->sortable(),
                    TextColumn::make('parentType')
                        ->label('Parent Type')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->numeric()
                        ->sortable(),
                    TextColumn::make('deactivatedBy')
                        ->label('Deactivated By')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->numeric()
                        ->sortable(),
                ]),

                ColumnGroup::make('Medical', [
                    TextColumn::make('medicalAidName')
                        ->label('Medical Aid')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('medicalAidNr')
                        ->label('Medical Aid Nr')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('doctorsName')
                        ->label('Doctor')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('doctorsPhone')
                        ->label('Doctor Phone')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('allergies')
                        ->label('Allergies')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('medicalConditions')
                        ->label('Medical Conditions')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                ]),

                ColumnGroup::make('Emergency Contact', [
                    TextColumn::make('emergencyContactName')
                        ->label('Name')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('emergencyContactCell')
                        ->label('Cell')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('emergencyContactTel')
                        ->label('Tel')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('emergencyContactRelationship')
                        ->label('Relationship')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                ]),

                ColumnGroup::make('Personal', [
                    TextColumn::make('language')
                        ->label('Language')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('religiousBelief')
                        ->label('Religious Belief')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('maritalStatus')
                        ->label('Marital Status')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->numeric()
                        ->sortable(),
                    TextColumn::make('occupation')
                        ->label('Occupation')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('employer')
                        ->label('Employer')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('highestEducation')
                        ->label('Highest Education')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->numeric()
                        ->sortable(),
                    TextColumn::make('school')
                        ->label('School')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                    TextColumn::make('partnersFullName')
                        ->label('Partner')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->searchable(),
                ]),

                ColumnGroup::make('Audit', [
                    TextColumn::make('created')
                        ->label('Created')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->dateTime()
                        ->sortable(),
                    TextColumn::make('createdby')
                        ->label('Created By')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->numeric()
                        ->sortable(),
                    TextColumn::make('modified')
                        ->label('Modified')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->dateTime()
                        ->sortable(),
                    TextColumn::make('modifiedby')
                        ->label('Modified By')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->numeric()
                        ->sortable(),
                ]),
            ])
            ->deferFilters(false)
            ->deferColumnManager(false)
            ->filters([
                TernaryFilter::make('active'),
            ])
            ->recordActions([
                Impersonate::make()
                    ->redirectTo(fn (SystemUser $record): string => self::generalPanelUrl($record)),
                Action::make('SD_Login')
                    ->label('Impersonate on SD')
                    ->url(fn (SystemUser $record): string => URL::temporarySignedRoute(
                        'impersonate.scouts-digital',
                        now()->addSeconds(60),
                        ['user' => $record->id],
                    ))
                    ->openUrlInNewTab(),
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }

    private static function generalPanelUrl(SystemUser $user): string
    {
        $tenant = $user->getDefaultTenant(Filament::getPanel('general'));

        if ($tenant) {
            return Dashboard::getUrl(panel: 'general', tenant: $tenant);
        }

        return '/general';
    }
}

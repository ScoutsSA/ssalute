<?php

namespace App\Filament\Member\Resources\Profile\Pages;

use App\Enums\UserEnglishProficiency;
use App\Enums\UserRace;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Filament\Member\Resources\Profile\ProfileResource;
use App\Models\AmsHighestEducation;
use App\Models\AmsLanguage;
use App\Models\AmsMaritalStatus;
use App\Models\GroupUserPictureChange;
use App\Settings\FeatureSettings;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Js;
use Imagick;

class EditProfile extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ProfileResource::class;

    protected static ?string $title = 'Edit Profile';

    public ?array $data = [];

    protected string $view = 'filament.member.pages.edit-profile';

    public static function canAccess(array $parameters = []): bool
    {
        return resolve(FeatureSettings::class)->users_can_edit_profiles;
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $user = auth()->user();

        $this->form->fill([
            'new_photo' => $user->photo,
            'title' => $user->title,
            'first_name' => $user->first_name,
            'otherName' => $user->otherName,
            'surname' => $user->surname,
            'previousSurname' => $user->previousSurname,
            'knownName' => $user->knownName,
            'scoutName' => $user->scoutName,
            'sex' => $user->sex,
            'race' => $user->race,
            'dob' => $user->dob,
            'idNumber' => $user->idNumber,
            'passportNumber' => $user->passportNumber,
            'startDate' => $user->startDate,
            'dateInvested' => $user->dateInvested,
            'username' => $user->username,
            'cellNr' => $user->cellNr,
            'officeNr' => $user->officeNr,
            'homeNr' => $user->homeNr,
            'phys_address' => $user->phys_address,
            'postal_address' => $user->postal_address,
            'occupation' => $user->occupation,
            'typeOfEmployment' => $user->typeOfEmployment,
            'employer' => $user->employer,
            'maritalStatus' => $user->maritalStatus,
            'highestEducation' => $user->highestEducation,

            'hobbies' => $user->hobbies,
            'sports' => $user->sports,
            'interests' => $user->interests,
            'homeLanguage' => $user->homeLanguage,
            'otherLanguage' => $user->otherLanguage,
            'otherLanguages' => $user->otherLanguages,
            'proficiencyInEnglish' => $user->proficiencyInEnglish,
            'medicalAidName' => $user->medicalAidName,
            'medicalAidNr' => $user->medicalAidNr,
            'medicalAidPrincipalMember' => $user->medicalAidPrincipalMember,
            'doctorsName' => $user->doctorsName,
            'doctorsPhone' => $user->doctorsPhone,
            'allergies' => $user->allergies,
            'allergiesInstructions' => $user->allergiesInstructions,
            'disabilities' => $user->disabilities,
            'disabilitiesInstructions' => $user->disabilitiesInstructions,
            'medicalConditions' => $user->medicalConditions,
            'medicalConditionsInstructions' => $user->medicalConditionsInstructions,
            'currentMedication' => $user->currentMedication,
            'specialMealRequirements' => $user->specialMealRequirements,
            'emergencyContactName' => $user->emergencyContactName,
            'emergencyContactCell' => $user->emergencyContactCell,
            'emergencyContactTel' => $user->emergencyContactTel,
            'emergencyContactRelationship' => $user->emergencyContactRelationship,
        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Exclude username: users cannot change their login email here
        unset($data['username']);

        $user = auth()->user();

        // Handle photo upload — only process if the file changed
        $newPhoto = $data['new_photo'] ?? null;
        if ($newPhoto && $newPhoto !== $user->photo) {
            $this->processPhotoUpload($user, $newPhoto);
        }
        unset($data['new_photo']);

        $user->update($data);

        Notification::make()
            ->title('Profile saved')
            ->success()
            ->send();

        $baseUrl = ProfileResource::getUrl('view', ['record' => $user->id]);

        $this->js(
            'const params = new URLSearchParams(window.location.search);' .
            'let url = ' . Js::from($baseUrl) . ';' .
            'if (params.has(\'tab\')) url += \'?tab=\' + encodeURIComponent(params.get(\'tab\'));' .
            'window.location.href = url;'
        );
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make()
                    ->id('profile-tabs')
                    ->columnSpanFull()
                    ->persistTabInQueryString('tab')
                    ->tabs([
                        Tab::make('Photo')
                            ->icon(Heroicon::Camera)
                            ->visible(fn () => resolve(FeatureSettings::class)->users_can_upload_profile_photo)
                            ->schema([
                                Section::make('Profile Photo')
                                    ->collapsible()
                                    ->description('Upload a new profile photo. Accepted formats: JPEG, PNG. Max size: 50MB.')
                                    ->schema([
                                        FileUpload::make('new_photo')
                                            ->label('Photo')
                                            ->disk('legacy')
                                            ->directory('ssalute/profile-picture')
                                            ->image()
                                            ->imageEditor()
                                            ->maxSize(51200)
                                            ->acceptedFileTypes(['image/jpeg', 'image/png']),
                                    ]),
                            ]),

                        Tab::make('Personal')
                            ->icon(Heroicon::User)
                            ->schema([
                                Section::make('Name')
                                    ->collapsible()
                                    ->columns(3)
                                    ->schema([
                                        Select::make('title')
                                            ->options(UserTitle::class)
                                            ->placeholder('-'),
                                        TextInput::make('first_name')
                                            ->label('First Name'),
                                        TextInput::make('otherName')
                                            ->label('Other Name'),
                                        TextInput::make('surname'),
                                        TextInput::make('previousSurname')
                                            ->label('Previous Surname'),
                                        TextInput::make('knownName')
                                            ->label('Known As'),
                                        TextInput::make('scoutName')
                                            ->label('Scout Name'),
                                    ]),

                                Section::make('Details')
                                    ->collapsible()
                                    ->columns(3)
                                    ->schema([
                                        Select::make('sex')
                                            ->options(UserSex::class),
                                        Select::make('race')
                                            ->options(UserRace::class),
                                        DatePicker::make('dob')
                                            ->label('Date of Birth')
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->helperText('Contact an administrator to change your date of birth.'),
                                        TextInput::make('idNumber')
                                            ->label('ID Number')
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->helperText('Contact an administrator to change your ID number.'),
                                        TextInput::make('passportNumber')
                                            ->label('Passport Number')
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->helperText('Contact an administrator to change your passport number.'),
                                        DatePicker::make('startDate')
                                            ->label('Member Since'),
                                        DatePicker::make('dateInvested')
                                            ->label('Date Invested'),
                                    ]),
                            ]),

                        Tab::make('Contact')
                            ->icon(Heroicon::Phone)
                            ->schema([
                                Section::make('Contact Details')
                                    ->collapsible()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('username')
                                            ->label('Email / Username')
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->helperText('Contact an administrator to change your login email.'),
                                        TextInput::make('cellNr')
                                            ->label('Cell Number')
                                            ->tel(),
                                        TextInput::make('officeNr')
                                            ->label('Office Number')
                                            ->tel(),
                                        TextInput::make('homeNr')
                                            ->label('Home Number')
                                            ->tel(),
                                    ]),
                            ]),

                        Tab::make('Address')
                            ->icon(Heroicon::MapPin)
                            ->schema([
                                Section::make('Address')
                                    ->collapsible()
                                    ->columns(1)
                                    ->schema([
                                        Textarea::make('phys_address')
                                            ->label('Physical Address')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        Textarea::make('postal_address')
                                            ->label('Postal Address')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Background')
                            ->icon(Heroicon::Briefcase)
                            ->schema([
                                Section::make('Employment')
                                    ->collapsible()
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('occupation')
                                            ->label('Occupation'),
                                        TextInput::make('employer')
                                            ->label('Employer'),
                                        TextInput::make('typeOfEmployment')
                                            ->label('Employment Type'),
                                    ]),

                                Section::make('Personal Details')
                                    ->collapsible()
                                    ->columns(2)
                                    ->schema([
                                        Select::make('maritalStatus')
                                            ->label('Marital Status')
                                            ->options(fn () => AmsMaritalStatus::orderBy('name')->pluck('name', 'id'))
                                            ->placeholder('-'),
                                        Select::make('highestEducation')
                                            ->label('Highest Education')
                                            ->options(fn () => AmsHighestEducation::orderBy('name')->pluck('name', 'id'))
                                            ->placeholder('-'),
                                    ]),

                                Section::make('Personal Interests')
                                    ->collapsible()
                                    ->columns(2)
                                    ->schema([
                                        Textarea::make('hobbies')
                                            ->rows(2),
                                        Textarea::make('sports')
                                            ->rows(2),
                                        Textarea::make('interests')
                                            ->rows(2),
                                    ]),
                            ]),

                        Tab::make('Medical')
                            ->icon(Heroicon::Heart)
                            ->schema([
                                Section::make('Medical Aid')
                                    ->collapsible()
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('medicalAidName')
                                            ->label('Medical Aid Name'),
                                        TextInput::make('medicalAidNr')
                                            ->label('Medical Aid Number'),
                                        TextInput::make('medicalAidPrincipalMember')
                                            ->label('Principal Member'),
                                    ]),

                                Section::make('Doctor')
                                    ->collapsible()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('doctorsName')
                                            ->label("Doctor's Name"),
                                        TextInput::make('doctorsPhone')
                                            ->label("Doctor's Phone")
                                            ->tel(),
                                    ]),

                                Section::make('Health Information')
                                    ->collapsible()
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('allergies')
                                            ->label('Allergies'),
                                        Textarea::make('allergiesInstructions')
                                            ->label('Allergy Instructions')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        TextInput::make('disabilities')
                                            ->label('Disabilities'),
                                        Textarea::make('disabilitiesInstructions')
                                            ->label('Disability Instructions')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        TextInput::make('medicalConditions')
                                            ->label('Medical Conditions'),
                                        Textarea::make('medicalConditionsInstructions')
                                            ->label('Conditions Instructions')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        Textarea::make('currentMedication')
                                            ->label('Current Medication')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        TextInput::make('specialMealRequirements')
                                            ->label('Special Meal Requirements'),
                                    ]),
                            ]),

                        Tab::make('Languages')
                            ->icon(Heroicon::Language)
                            ->schema([
                                Section::make('Languages')
                                    ->collapsible()
                                    ->columns(2)
                                    ->schema([
                                        Select::make('homeLanguage')
                                            ->label('Home Language')
                                            ->options(fn () => AmsLanguage::orderBy('language')->pluck('language', 'id'))
                                            ->searchable()
                                            ->placeholder('-'),
                                        Select::make('otherLanguage')
                                            ->label('Other Language')
                                            ->options(fn () => AmsLanguage::orderBy('language')->pluck('language', 'id'))
                                            ->searchable()
                                            ->placeholder('-'),
                                        TextInput::make('otherLanguages')
                                            ->label('Additional Languages'),
                                        Select::make('proficiencyInEnglish')
                                            ->label('English Proficiency')
                                            ->options(UserEnglishProficiency::class)
                                            ->placeholder('-'),
                                    ]),
                            ]),

                        Tab::make('Emergency Contact')
                            ->icon(Heroicon::ExclamationTriangle)
                            ->schema([
                                Section::make('Emergency Contact')
                                    ->collapsible()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('emergencyContactName')
                                            ->label('Name'),
                                        TextInput::make('emergencyContactCell')
                                            ->label('Cell Number')
                                            ->tel(),
                                        TextInput::make('emergencyContactTel')
                                            ->label('Telephone')
                                            ->tel(),
                                        TextInput::make('emergencyContactRelationship')
                                            ->label('Relationship'),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->icon(Heroicon::Check)
                ->action(fn () => $this->save()),
            Action::make('cancel')
                ->label('Cancel')
                ->icon(Heroicon::XMark)
                ->color('gray')
                ->alpineClickHandler(
                    'const params = new URLSearchParams(window.location.search);' .
                    'let url = ' . Js::from(ProfileResource::getUrl('view', ['record' => $this->getRecord()])) . ';' .
                    'if (params.has(\'tab\')) url += \'?tab=\' + encodeURIComponent(params.get(\'tab\'));' .
                    'window.location.href = url;'
                ),
        ];
    }

    private function processPhotoUpload(\App\Models\SystemUser $user, string $uploadedPath): void
    {
        $legacyDisk = Storage::disk('legacy');

        $extension = pathinfo($uploadedPath, PATHINFO_EXTENSION) ?: 'jpg';
        $filename = 'PROFILE_IMAGE_' . $user->id . '_' . now()->format('Y-m-d_H-i-s') . '.' . $extension;
        $photoPath = 'ssalute/profile-picture/' . $filename;
        $thumbPath = 'ssalute/profile-picture-thumbnail/' . $filename;

        // Archive old photo and remove old thumbnail
        if ($user->photo) {
            $oldFilename = basename($user->photo);
            $historicPath = 'ssalute/historic-profile-picture/' . $oldFilename;

            if ($legacyDisk->exists($user->photo)) {
                $legacyDisk->move($user->photo, $historicPath);
            }

            if ($user->thumb && $legacyDisk->exists($user->thumb)) {
                $legacyDisk->delete($user->thumb);
            }

            GroupUserPictureChange::create([
                'userID' => $user->id,
                'pictureLocation' => $historicPath,
                'createdby' => $user->id,
            ]);
        }

        $absolutePath = $legacyDisk->path($uploadedPath);

        // Resize original to max 1000x1000 at 85% quality
        $image = new Imagick($absolutePath);
        $image->setImageCompressionQuality(85);
        $image->thumbnailImage(1000, 1000, true);
        $legacyDisk->put($photoPath, $image->getImageBlob());

        // Generate 80px tall thumbnail at 85% quality
        $image->thumbnailImage(0, 80);
        $legacyDisk->put($thumbPath, $image->getImageBlob());

        $image->clear();
        $image->destroy();

        // Clean up the raw upload (FileUpload stored it before processing)
        if ($uploadedPath !== $photoPath) {
            $legacyDisk->delete($uploadedPath);
        }

        $user->photo = $photoPath;
        $user->thumb = $thumbPath;
    }
}

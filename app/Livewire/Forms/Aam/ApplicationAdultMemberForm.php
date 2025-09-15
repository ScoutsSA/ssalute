<?php

namespace App\Livewire\Forms\Aam;

use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Mail\Forms\Aam\ApplicationAdultMembershipApplicantInitialEmail;
use App\Models\District;
use App\Models\Forms\ApplicationAdultMembershipRequest;
use App\Models\Group;
use App\Models\Region;
use App\Rules\ValidMsisdnRule;
use App\Settings\FormSettings;
use Carbon\Carbon;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class ApplicationAdultMemberForm extends Component implements HasSchemas
{
    use InteractsWithSchemas;
    use WithRateLimiting;

    public ?array $data = [];

    public bool $successfullyCompletedForm = false;

    public function render()
    {
        return view('forms.aam.aam_form')
            ->layout('layouts.livewire')
            ->layoutData([
                'title' => 'Ssalute - Check User Existence',
            ]);
    }

    public function mount(Request $request, FormSettings $formSettings): void
    {
        if (! $formSettings->aam_enabled) {
            abort(404);
        }

        $this->form->fill(['email' => $request->get('email', ''), 'has_south_african_id' => true]);

        // Testing Data
        /*$this->form->fill([
            'email' => 'no-reploy@scouts.org.za',
            'first_name' => 'Robert',
            'other_names' => 'Stephenson Smyth',
            'surname' => 'Baden-Powell',
            'nickname' => "M'hlala panzi",
            'title' => 'mr',
            'sex' => 'm',
            'has_south_african_id' => true,
            'id_number' => '9406295154082',
            'id_document_file' => 'JcHCu7v1qm709dKjBP4mvfeCV2IXem-metaU2VsZWN0aW9uXzAwMS5wbmc=-.png',
            'criminal_record_file' => 'JcHCu7v1qm709dKjBP4mvfeCV2IXem-metaU2VsZWN0aW9uXzAwMS5wbmc=-.png',
            'passport_country' => null,
            'passport_date_of_issue' => null,
            'date_of_birth' => Carbon::createFromFormat('ymd', substr('9406295154082', 0, 6))->format('Y-m-d'),
            'phone_number' => '0676943688',
            'residential_address' => '124 Belvedere Rd, Claremont, Cape Town, 7708',
            'emergency_contact_name' => 'Olave St Clair Baden-Powell',
            'emergency_contact_phone_number' => '0676943688',
            'region_id' => null,
            'district_id' => null,
            'group_id' => null,
        ]);*/
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Wizard::make([
                    Step::make('Contact Info')
                        ->description(fn (Get $get) => $get('email'))
                        ->schema([
                            TextInput::make('email')
                                ->email()
                                ->placeholder('example@scouts.org.za')
                                ->unique('system_users', 'username')
                                ->unique('forms_aam_requests', 'email')
                                ->validationMessages([
                                    'unique' => 'This email either has an account or already has an application pending.',
                                ])
                                ->maxLength(255)
                                ->columnSpan(1)
                                ->required(),
                            TextInput::make('phone_number')
                                ->placeholder('067 694 3688')
                                ->maxLength(255)
                                ->columnSpan(1)
                                ->rule(resolve(ValidMsisdnRule::class))
                                ->required(),
                        ]),
                    Step::make('Verification')
                        ->description(fn (Get $get) => $get('has_south_african_id') ? 'South African ID' : 'Passport Number')
                        ->schema([
                            Toggle::make('has_south_african_id')
                                ->label('South African ID')
                                ->live(onBlur: true)
                                ->helperText('Do you have a South African ID')
                                ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                    if ($state === false) {
                                        $set('date_of_birth', null);
                                    } else {
                                        $sa_id = $get('id_number');

                                        if (strlen($sa_id) < 6) {
                                            return;
                                        }
                                        $dateOfBirth = Carbon::createFromFormat('ymd', substr($sa_id, 0, 6))->format('Y-m-d');

                                        $set('date_of_birth', $dateOfBirth);
                                    }
                                }),
                            Fieldset::make('SA_ID')
                                ->label('South African ID')
                                ->visible(fn (Get $get) => $get('has_south_african_id') === true)
                                ->schema([
                                    TextInput::make('id_number')
                                        ->maxLength(255)
                                        ->length(13)
                                        ->numeric()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function (Set $set, $state) {
                                            if (strlen($state) < 6) {
                                                return;
                                            }

                                            $dateOfBirth = Carbon::createFromFormat('ymd', substr($state, 0, 6))->format('Y-m-d');

                                            $set('date_of_birth', $dateOfBirth);
                                        })
                                        ->required(),
                                    FileUpload::make('id_document_file')
                                        ->label('Upload a certified copy of your ID Card/Book')
                                        ->disk('forms_aam_id_document')
                                        ->validationMessages([
                                            'required' => 'You must upload a certified copy of your ID Card/Book.',
                                        ])
                                        ->required(),
                                ]),
                            Fieldset::make('Passport Number')
                                ->label('Passport Number')
                                ->visible(fn (Get $get) => $get('has_south_african_id') === false)
                                ->schema([
                                    TextInput::make('id_number')
                                        ->label('Passport Number')
                                        ->maxLength(255)
                                        ->required(),
                                    FileUpload::make('id_document_file')
                                        ->label('Upload a copy of your passport')
                                        ->disk('forms_aam_id_document')
                                        ->validationMessages([
                                            'required' => 'You must upload a certified copy of your Passport.',
                                        ])
                                        ->required(),
                                    TextInput::make('passport_country')
                                        ->label('Passport issued by which country?')
                                        ->maxLength(255)
                                        ->required(),
                                    DatePicker::make('passport_date_of_issue')
                                        ->label('Date of Issue?')
                                        ->displayFormat('Y/m/d')
                                        ->native(false)
                                        ->required(),

                                ]),
                            Fieldset::make('Police/Criminal Record')
                                ->label('Police/Criminal Record')
                                ->columns(1)
                                ->schema([
                                    FileUpload::make('criminal_record_file')
                                        ->label('Upload a copy of your Police or Criminal Clearance')
                                        ->validationMessages([
                                            'required' => 'You must upload a certified copy of your Criminal Clearance.',
                                        ])
                                        ->disk('forms_aam_criminal_record')
                                        ->required()
                                        ->columns(1),
                                ]),

                        ]),
                    Step::make('Personal Info')
                        ->description(fn (Get $get) => Arr::get(UserTitle::options(), $get('title') ?? '', null) . ' ' . $get('first_name') . ' ' . $get('surname'))
                        ->columns(2)
                        ->schema([
                            Select::make('title')
                                ->options(UserTitle::options())
                                ->placeholder('Mr/Ms/...')
                                ->searchable()
                                ->required(),
                            TextInput::make('first_name')
                                ->label('First Name')
                                ->placeholder('Jane')
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->required(),
                            TextInput::make('other_names')
                                ->label('Other Names')
                                ->helperText('Middle Name(s)')
                                ->placeholder('Example')
                                ->maxLength(255)
                                ->nullable(),
                            TextInput::make('surname')
                                ->placeholder('Doe')
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->required(),
                            TextInput::make('nickname')
                                ->helperText('What would you like to be called?')
                                ->placeholder('Janey')
                                ->maxLength(255)
                                ->required(),
                            Select::make('sex')
                                ->helperText('As per your ID/Passport')
                                ->options(UserSex::options())
                                ->searchable()
                                ->required(),
                            DatePicker::make('date_of_birth')
                                ->disabled(fn (Get $get) => $get('has_south_african_id') === true)
                                ->dehydrated(true)
                                ->native(false)
                                ->displayFormat('Y/m/d')
                                ->required(),
                            Textarea::make('residential_address')
                                ->placeholder('1 Example Road, Suburb, City, Province, Postal Code')
                                ->required(),
                        ]),
                    Step::make('Medical Information')
                        ->schema([
                            Textarea::make('medical_conditions')
                                ->label('Medical Conditions / Allergies')
                                ->placeholder('ADHD, Diabetes, allergies etc. Leave blank if none')
                                ->maxLength(255),
                            Fieldset::make('Medical Aid Information')
                                ->columns(3)
                                ->schema([
                                    TextInput::make('medical_aid_scheme_name')
                                        ->label('Scheme Name')
                                        ->placeholder('Discovery Health')
                                        ->maxLength(255),
                                    TextInput::make('medical_aid_number')
                                        ->label('Number')
                                        ->placeholder('11223344556677')
                                        ->maxLength(255),
                                    TextInput::make('medical_aid_principal_member')
                                        ->label('Principal Member')
                                        ->placeholder('Jane Doe')
                                        ->maxLength(255),
                                ]),
                        ]),
                    Step::make('Emergency & Privacy')
                        ->schema([
                            Fieldset::make('Emergency Contact')
                                ->schema([
                                    TextInput::make('emergency_contact_name')
                                        ->label('Emergency Contact Name')
                                        ->placeholder('Jane Doe')
                                        ->maxLength(255)
                                        ->required(),
                                    TextInput::make('emergency_contact_phone_number')
                                        ->label('Emergency Contact Phone Number')
                                        ->placeholder('067 694 3688')
                                        ->maxLength(255)
                                        ->rule(resolve(ValidMsisdnRule::class))
                                        ->required(),
                                ]),
                            Toggle::make('has_given_public_media_consent')
                                ->label('No / Yes')
                                ->required()
                                ->helperText(new HtmlString("
<p>SCOUTS South Africa has a legitimate interest to take and use photographs, or film and record audio/audio-visual clips at large public events and during Scout Group meetings and will not ask for consent.</p>
<p>Photographs that include 2 or more people in a public place or Scout venue, will be considered to be ‘public’ photographs. Unless you have already provided your consent (see below) we will ask for your verbal consent if: the photograph/audio-visual recording is of only you or it contains special personal information (like information about your health but excluding facial recognition).</p>
<p>You can ask us to delete the photograph at any time by using the process set out in our SCOUTS South Africa Privacy Notice, and we will delete the content or tell you why we did not delete it</p>
<ul>
    <li style='margin-left: 20px' class='list-disc'>Yes - I consent and authorise that any photo’s, statements, audio–visual recordings, video and sound bites taken, recorded, and collected from me during activities with SCOUTS South Africa may be used free of charge and at the discretion of SCOUTS South Africa as part of their marketing, communication, and fundraising campaigns. (You do not have to provide this consent, but by ticking the consent box you are helping SSA with fundraising, marketing, and communications. You can withdraw your consent at any time.)</li>
    <li style='margin-left: 20px' class='list-disc'>No - I do NOT CONSENT to the above regarding the use of photographs and audio/audio-visual recordings of me. I undertake the responsibility to inform the Scouter of this decision.</li>
</ul>
    ")),

                        ]),

                    Step::make('Consent')
                        ->schema([
                            Toggle::make('scouting_consent')
                                ->label('I accept the below')
                                ->required()
                                ->accepted()
                                ->validationMessages([
                                    'accepted' => 'You must accept before continuing.',
                                ])
                                ->helperText(new HtmlString("<ol>
<li>1. I accept the <a class='font-medium text-blue-600 underline dark:text-blue-500 hover:no-underline' href='https://www.scouts.org.za/about-us/values/'>values of Scouting</a> as set out in the Aim, Principles and Method.</li>
<li>2. I am prepared to make the Scout Promise.</li>
<li>3. I understand that anything I do with young people must be to help them achieve the Aim of Scouting.</li>
<li>4. I agree not to promote any beliefs, behaviours, or practices, which are not compatible with the values of Scouting.</li>
<li>5. I agree to work within the <a class='font-medium text-blue-600 underline dark:text-blue-500 hover:no-underline' href='https://www.scouts.org.za/ssa-constitution-policies/'>Organisational Rules and all Policies</a> of SCOUTS South Africa and its Member Code of Conduct.</li>
<li>6. I will participate in training within time frames laid down by SCOUTS South Africa.</li>
<li>7. I will attach a Criminal/Police Clearance Certificate or proof of payment thereof upon application for membership. SCOUTS South Africa has the right to request a new Criminal / Police Clearance Check at any time.</li>
<li>8. SCOUTS South Africa is required by Law to vet all adults against the sex offender’s database with the Department of Social Development. By signing this Application for Adult Membership form I give SCOUTS South Africa permission submit a Form 29 on my behalf using the certified ID attached.</li>
<li>9. I understand that because my voluntary work for SCOUTS South Africa may involve substantial contact with children (under 18 years), any criminal conviction involving minors which has been removed from my criminal record must still be disclosed by me.</li>
<li>10. I am not, to the best of my knowledge, the subject of any criminal investigation or awaiting the outcome of criminal proceedings against me and I will inform SCOUTS South Africa immediately if I become subject to this in the future.</li>
<li>11. I undertake to report to the District Commissioner/Regional Commissioner or Chief Commissioner, as appropriate, any changes in my circumstances that could affect my role and membership of SCOUTS South Africa.</li>
<li>12. I hereby acknowledge anyone entering the premises of SCOUTS South Africa does so entirely at their own risk. I agree not to hold SCOUTS South Africa liable for any loss or any damage of any kind, or any death of or injury to any person, whilst participating in any activities organised by or conducted by SCOUTS South Africa, even if the loss or death or injury is caused by the negligent act or omission of SCOUTS South Africa, its employees, agents, officers, contractors, or affiliates.</li>
<li>13. I hereby indemnify and hold harmless SCOUTS South Africa against all or any claims which may be made by any person against SCOUTS South Africa or its employees, agents, officers, contractors, affiliates, or any other person for any damage of whatever kind arising from the death or injury to any person whilst such person is or on any premises of SCOUTS South Africa or participating in any activity organised by or conducted by SCOUTS South Africa which was caused by me.</li>
<li>14. SCOUTS South Africa holds Public Liability insurance, but not Personal Injury insurance.</li>
<li>15. All SCOUTS South Africa members will receive service messages (e.g. opportunities, programme updates), emergency messages, and may receive some direct marketing regarding SCOUTS South Africa events and goods. SCOUTS South Africa will always give you the option to unsubscribe from direct marketing messages.</li>
<li>16. I have read the <a class='font-medium text-blue-600 underline dark:text-blue-500 hover:no-underline' href='https://www.scouts.org.za/wp-content/uploads/Privacy-notice-Jul2022F.pdf'>SCOUTS South Africa Privacy Notice</a> which sets out what my personal information will be used for and who it will</li>
be shared with.
<li>17. I have watched the <a class='font-medium text-blue-600 underline dark:text-blue-500 hover:no-underline' href='https://www.youtube.com/watch?v=5lNyx8JmZK8'>WOSM introductory Safe from Harm video</a>. See more: https://www.scout.org/safefromharm</li></ol>")),

                        ]),
                    Step::make('Group Details')
                        ->schema([
                            TextEntry::make('Who should we notify for your request?')
                                ->state('Please enter the region/district/group which is most accurate for you. This is so that we can notify the correct people of your request.'),

                            Select::make('region')
                                ->options(Region::active()->pluck('name', 'id')->toArray())
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('district', null);
                                    $set('group', null);
                                }),
                            Select::make('district')
                                ->options(function (Get $get): array {
                                    return Region::find($get('region'))?->districts()->active()->pluck('name', 'id')->toArray() ?? [];
                                })
                                ->placeholder('First Select a Region')
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('group', null);
                                }),
                            Select::make('group')
                                ->options(function (Get $get): array {
                                    if ($get('district') !== null) {
                                        return District::find($get('district'))?->groups()->active()->pluck('name', 'id')->toArray() ?? [];
                                    }
                                    if ($get('region') !== null) {
                                        return Region::find($get('region'))?->groups()->active()->pluck('name', 'id')->toArray() ?? [];
                                    }

                                    return [];
                                })
                                ->afterStateUpdated(function (Set $set, Get $get) {
                                    if ($get('district') === null) {
                                        $set('district', Group::find($get('group'))?->assoc_to_district);
                                    }
                                })
                                ->placeholder('First Select a Region')
                                ->searchable()
                                ->live(),

                        ]),
                ])
                    ->submitAction(new HtmlString(Blade::render('<x-filament::button type="submit" size="sm">Submit</x-filament::button>')))
                    ->skippable(true),
            ]);
    }

    public function create(): void
    {
        $this->validate();
        $formSettings = resolve(FormSettings::class);

        $this->successfullyCompletedForm = true;

        $state = $this->form->getState();

        $aam = ApplicationAdultMembershipRequest::create([
            'email' => $state['email'] ?? null,
            'first_name' => $state['first_name'] ?? null,
            'other_names' => $state['other_names'] ?? null,
            'surname' => $state['surname'] ?? null,
            'nickname' => $state['nickname'] ?? null,
            'title' => $state['title'] ?? null,
            'sex' => $state['sex'] ?? null,
            'has_south_african_id' => $state['has_south_african_id'] ?? null,
            'id_number' => $state['id_number'] ?? null,
            'id_document' => $state['id_document_file'] ?? null,
            'criminal_record' => $state['criminal_record_file'] ?? null,
            'date_of_birth' => $state['date_of_birth'] ?? null,
            'passport_country' => $state['passport_country'] ?? null,
            'passport_date_of_issue' => $state['passport_date_of_issue'] ?? null,
            'phone_number' => resolve(ValidMsisdnRule::class)->cleanMsisdn($state['phone_number']),
            'residential_address' => $state['residential_address'] ?? null,
            'medical_conditions' => $state['medical_conditions'] ?? null,
            'medical_aid_scheme_name' => $state['medical_aid_scheme_name'] ?? null,
            'medical_aid_number' => $state['medical_aid_number'] ?? null,
            'medical_aid_principal_member' => $state['medical_aid_principal_member'] ?? null,
            'emergency_contact_name' => $state['emergency_contact_name'] ?? null,
            'emergency_contact_phone_number' => resolve(ValidMsisdnRule::class)->cleanMsisdn($state['emergency_contact_phone_number']),
            'has_given_public_media_consent' => $state['has_given_public_media_consent'] ?? null,
            'region_id' => $state['region'] ?? null,
            'district_id' => $state['district'] ?? null,
            'group_id' => $state['group'] ?? null,
        ]);
        Notification::make()
            ->title('Application Created!')
            ->success()
            ->send();

        // Email applicant
        Mail::to($aam->email)->bcc($formSettings->aam_national_support_emails)->queue(new ApplicationAdultMembershipApplicantInitialEmail($aam));

        // Email NextInLine (Group/District/Region)
        if ($aam->region_id === null) {
            // National
            Mail::to($formSettings->aam_national_support_emails)->queue(new ApplicationAdultMembershipApplicantInitialEmail($aam));

            return;
        }

        /*        if ($aam->district_id === null) {
                    // Regional
                    // Users which have Adult Support (system_user_type=25)
                   # $adultSupportMembers = ^^;
                    if(!$adultSupportMembers)
                    {
                        // Regional Commissioner
                    }

                    Mail::cc($formSettings->aam_national_support_emails)->to($users)->queue(new ApplicationAdultMembershipApplicantInitialEmail($aam));
                    return;
                }

                if ($aam->group_id === null) {
                    // District
                    //  Users which have District Commissioner (system_user_type=3)
                    // cc in in Adult Support/RegionalCommissioner
                    Mail::cc($formSettings->aam_national_support_emails)->to($users)->queue(new ApplicationAdultMembershipApplicantInitialEmail($aam));
                    return;
                }

                // Group
                //  Users which have SGL Commissioner
                // cc in District Commissioner & Adult Support/RegionalCommissioner
                Mail::cc($formSettings->aam_national_support_emails)->to($users)->queue(new ApplicationAdultMembershipApplicantInitialEmail($aam));
                return;*/

        /**
         * ToDo - Handle Approval
         */
    }
}

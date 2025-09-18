<?php

namespace App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Schemas;

use App\Enums\Forms\Aam\AamStatuses;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Models\SystemUser;
use App\Rules\ValidMsisdnRule;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ApplicationAdultMembershipRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(['sm' => 2, 'md' => 4, 'lg' => 4])
            ->components([
                Section::make('Application Status')
                    ->compact()
                    ->columns(1)
                    ->columnSpanFull()
                    ->collapsible()
                    ->schema([
                        Select::make('status')
                            ->options(AamStatuses::class)
                            ->helperText('Changing this will not fire any workflows.')
                            ->required(),
                        Fieldset::make('Area')
                            ->columns(3)
                            ->schema([
                                Select::make('region_id')
                                    ->relationship('region', 'name'),
                                Select::make('district_id')
                                    ->relationship('district', 'name'),
                                Select::make('group_id')
                                    ->relationship('group', 'name'),
                            ]),
                    ]),

                Tabs::make('details')
                    ->columnSpanFull()
                    ->schema([
                        Tab::make('Contact Info')
                            ->columns(2)
                            ->schema([
                                TextInput::make('phone_number')
                                    ->rules([resolve(ValidMsisdnRule::class)])
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Email address')
                                    ->email()
                                    ->required(),
                            ]),
                        Tab::make('Personal Details')
                            ->columns(5)
                            ->schema([
                                Fieldset::make('Name')
                                    ->columns(3)
                                    ->columnSpanFull()
                                    ->schema([
                                        Select::make('title')
                                            ->options(UserTitle::class)
                                            ->required(),
                                        TextInput::make('first_name')
                                            ->required(),
                                        TextInput::make('other_names'),
                                        TextInput::make('surname')
                                            ->required(),
                                        TextInput::make('nickname'),
                                    ]),
                                Select::make('sex')
                                    ->options(UserSex::class)
                                    ->required(),
                                DatePicker::make('date_of_birth')
                                    ->required(),
                                Textarea::make('residential_address')
                                    ->columnSpan(3)
                                    ->required(),
                            ]),
                        Tab::make('Identification')
                            ->columns(3)
                            ->schema([
                                Toggle::make('has_south_african_id')
                                    ->label('Has South African ID')
                                    ->columnSpanFull()
                                    ->live()
                                    ->required(),
                                Fieldset::make('Passport Information')
                                    ->columnSpan(2)
                                    ->columns(['sm' => 2, 'md' => 3, 'lg' => 3])
                                    ->visible(fn (Get $get) => $get('has_south_african_id') === false)
                                    ->schema([
                                        TextInput::make('id_number')
                                            ->label('Passport Number')
                                            ->required(),
                                        TextInput::make('passport_country')
                                            ->label('Passport Issued By')
                                            ->required(),
                                        DatePicker::make('passport_date_of_issue')
                                            ->required(),
                                    ]),
                                Fieldset::make('ID Information')
                                    ->visible(fn (Get $get) => $get('has_south_african_id') === true)
                                    ->columnSpan(2)
                                    ->schema([
                                        TextInput::make('id_number')
                                            ->label('ID Number')
                                            ->columnSpanFull()
                                            ->required(),
                                    ]),
                                FileUpload::make('id_document')
                                    ->label(fn (Get $get) => $get('has_south_african_id') ? 'ID Document' : 'Passport Document')
                                    ->disk('forms_aam_id_document')
                                    ->downloadable()
                                    ->imagePreviewHeight('300')
                                    ->required(),
                            ]),
                        Tab::make('Clearance')
                            ->columns(1)
                            ->schema([
                                FileUpload::make('criminal_record')
                                    ->disk('forms_aam_criminal_record')
                                    ->imagePreviewHeight('300')
                                    ->downloadable()
                                    ->required(),
                            ]),
                        Tab::make('Medical')
                            ->columns(3)
                            ->schema([
                                Textarea::make('medical_conditions')
                                    ->columnSpanFull(),
                                TextInput::make('medical_aid_scheme_name'),
                                TextInput::make('medical_aid_number'),
                                TextInput::make('medical_aid_principal_member'),
                            ]),
                        Tab::make('Other')
                            ->columns(2)
                            ->schema([
                                TextInput::make('emergency_contact_name')
                                    ->required(),
                                TextInput::make('emergency_contact_phone_number')
                                    ->required()
                                    ->rules([resolve(ValidMsisdnRule::class)]),
                                Toggle::make('has_given_public_media_consent')
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Actioning')
                            ->columns(1)
                            ->schema([
                                TextEntry::make('Note')
                                    ->state('This should only be used when something has gone horribly wrong with the process and you need to add some context to the record. All other workflows should be done via the proper channels.')
                                    ->columnSpanFull(),
                                DateTimePicker::make('actioned_at'),
                                Select::make('actioned_by')
                                    ->relationship('actionedBy', 'name')
                                    ->searchable()
                                    ->helperText('Search via email or ID')
                                    ->getSearchResultsUsing(fn (string $search): array => SystemUser::query()
                                        ->where('username', 'like', "{$search}%")
                                        ->orWhere('id', '=', $search)
                                        ->limit(50)
                                        ->get()
                                        ->mapWithKeys(fn ($user) => [
                                            $user->id => "{$user->username} [{$user->name} - {$user->id}]",
                                        ])
                                        ->toArray())
                                    ->getOptionLabelsUsing(fn (array $values): array => SystemUser::whereIn('id', $values)
                                        ->get()
                                        ->mapWithKeys(fn ($user) => [
                                            $user->id => "{$user->username} [{$user->name} - {$user->id}]",
                                        ])
                                        ->toArray()
                                    ),
                                Textarea::make('actioned_notes_internal')
                                    ->columnSpanFull(),
                                Textarea::make('actioned_reason_external')
                                    ->columnSpanFull(),
                            ]),
                    ]),

            ]);
    }
}

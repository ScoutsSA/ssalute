<?php

namespace App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Schemas;

use App\Enums\Forms\Aam\AamStatuses;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ApplicationAdultMembershipRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('region_id')
                    ->relationship('region', 'name'),
                Select::make('district_id')
                    ->relationship('district', 'name'),
                Select::make('group_id')
                    ->relationship('group', 'name'),
                Select::make('status')
                    ->options(AamStatuses::class)
                    ->required(),
                TextInput::make('first_name'),
                TextInput::make('other_names'),
                TextInput::make('surname'),
                TextInput::make('nickname'),
                Select::make('title')
                    ->options(UserTitle::class)
                    ->required(),
                Select::make('sex')
                    ->options(UserSex::class)
                    ->required(),
                Toggle::make('has_south_african_id')
                    ->required(),
                TextInput::make('id_number')
                    ->required(),
                TextInput::make('id_document')
                    ->required(),
                TextInput::make('criminal_record')
                    ->required(),
                DatePicker::make('date_of_birth'),
                TextInput::make('passport_country'),
                TextInput::make('passport_date_of_issue'),
                TextInput::make('phone_number')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Textarea::make('residential_address')
                    ->columnSpanFull(),
                Textarea::make('medical_conditions')
                    ->columnSpanFull(),
                TextInput::make('medical_aid_scheme_name'),
                TextInput::make('medical_aid_number'),
                TextInput::make('medical_aid_principal_member'),
                TextInput::make('emergency_contact_name'),
                TextInput::make('emergency_contact_phone_number')
                    ->tel(),
                Toggle::make('has_given_public_media_consent')
                    ->required(),
                TextInput::make('action_slug')
                    ->required(),
                TextInput::make('view_slug')
                    ->required(),
                DateTimePicker::make('approved_at'),
                TextInput::make('approved_by')
                    ->numeric(),
                DateTimePicker::make('declined_at'),
                TextInput::make('declined_by')
                    ->numeric(),
                Textarea::make('declined_notes_internal')
                    ->columnSpanFull(),
                Textarea::make('declined_reason_external')
                    ->columnSpanFull(),
            ]);
    }
}

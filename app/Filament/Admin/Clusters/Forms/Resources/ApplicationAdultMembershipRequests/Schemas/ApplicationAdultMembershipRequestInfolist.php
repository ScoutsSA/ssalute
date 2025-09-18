<?php

namespace App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ApplicationAdultMembershipRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('region.name')
                    ->label('Region')
                    ->placeholder('-'),
                TextEntry::make('district.name')
                    ->label('District')
                    ->placeholder('-'),
                TextEntry::make('group.name')
                    ->label('Group')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('first_name')
                    ->placeholder('-'),
                TextEntry::make('other_names')
                    ->placeholder('-'),
                TextEntry::make('surname')
                    ->placeholder('-'),
                TextEntry::make('nickname')
                    ->placeholder('-'),
                TextEntry::make('title')
                    ->badge(),
                TextEntry::make('sex')
                    ->badge(),
                IconEntry::make('has_south_african_id')
                    ->boolean(),
                TextEntry::make('id_number'),
                TextEntry::make('id_document'),
                TextEntry::make('criminal_record'),
                TextEntry::make('date_of_birth')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('passport_country')
                    ->placeholder('-'),
                TextEntry::make('passport_date_of_issue')
                    ->placeholder('-'),
                TextEntry::make('phone_number'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('residential_address')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('medical_conditions')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('medical_aid_scheme_name')
                    ->placeholder('-'),
                TextEntry::make('medical_aid_number')
                    ->placeholder('-'),
                TextEntry::make('medical_aid_principal_member')
                    ->placeholder('-'),
                TextEntry::make('emergency_contact_name')
                    ->placeholder('-'),
                TextEntry::make('emergency_contact_phone_number')
                    ->placeholder('-'),
                IconEntry::make('has_given_public_media_consent')
                    ->boolean(),
                TextEntry::make('action_slug'),
                TextEntry::make('view_slug'),
                TextEntry::make('approved_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('approved_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('declined_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('declined_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('declined_notes_internal')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('declined_reason_external')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}

<?php

namespace App\Filament\General\Pages;

use App\Enums\UserSex;
use App\Enums\UserTitle;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ViewProfile extends Page
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::UserCircle;

    protected static ?string $navigationLabel = 'My Profile';

    protected static ?string $title = 'My Profile';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.general.pages.view-profile';

    public function infolist(Schema $schema): Schema
    {
        $user = auth()->user();

        return $schema
            ->record($user)
            ->components([
                Section::make('Personal Information')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('title')
                            ->formatStateUsing(fn ($state) => $state instanceof UserTitle ? $state->getLabel() : $state)
                            ->placeholder('-'),
                        TextEntry::make('first_name')
                            ->label('First Name')
                            ->placeholder('-'),
                        TextEntry::make('otherName')
                            ->label('Other Name')
                            ->placeholder('-'),
                        TextEntry::make('surname')
                            ->placeholder('-'),
                        TextEntry::make('knownName')
                            ->label('Known As')
                            ->placeholder('-'),
                        TextEntry::make('scoutName')
                            ->label('Scout Name')
                            ->placeholder('-'),
                        TextEntry::make('sex')
                            ->formatStateUsing(fn ($state) => $state instanceof UserSex ? $state->getLabel() : $state)
                            ->placeholder('-'),
                        TextEntry::make('dob')
                            ->label('Date of Birth')
                            ->date()
                            ->placeholder('-'),
                    ]),

                Section::make('Contact Details')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('username')
                            ->label('Email / Username')
                            ->placeholder('-'),
                        TextEntry::make('cellNr')
                            ->label('Cell Number')
                            ->placeholder('-'),
                        TextEntry::make('officeNr')
                            ->label('Office Number')
                            ->placeholder('-'),
                        TextEntry::make('homeNr')
                            ->label('Home Number')
                            ->placeholder('-'),
                    ]),

                Section::make('Address')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('phys_address')
                            ->label('Physical Address')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('postal_address')
                            ->label('Postal Address')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Emergency Contact')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('emergencyContactName')
                            ->label('Name')
                            ->placeholder('-'),
                        TextEntry::make('emergencyContactCell')
                            ->label('Cell Number')
                            ->placeholder('-'),
                        TextEntry::make('emergencyContactTel')
                            ->label('Telephone')
                            ->placeholder('-'),
                        TextEntry::make('emergencyContactRelationship')
                            ->label('Relationship')
                            ->placeholder('-'),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit Profile')
                ->icon(Heroicon::PencilSquare)
                ->url(fn () => EditProfile::getUrl()),
        ];
    }
}

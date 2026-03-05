<?php

namespace App\Filament\General\Pages;

use App\Enums\UserSex;
use App\Enums\UserTitle;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class EditProfile extends Page
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::PencilSquare;

    protected static ?string $title = 'Edit Profile';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    protected string $view = 'filament.general.pages.edit-profile';

    public function mount(): void
    {
        $user = auth()->user();

        $this->form->fill([
            'title' => $user->title,
            'first_name' => $user->first_name,
            'otherName' => $user->otherName,
            'surname' => $user->surname,
            'knownName' => $user->knownName,
            'scoutName' => $user->scoutName,
            'sex' => $user->sex,
            'dob' => $user->dob,
            'username' => $user->username,
            'cellNr' => $user->cellNr,
            'officeNr' => $user->officeNr,
            'homeNr' => $user->homeNr,
            'phys_address' => $user->phys_address,
            'postal_address' => $user->postal_address,
            'emergencyContactName' => $user->emergencyContactName,
            'emergencyContactCell' => $user->emergencyContactCell,
            'emergencyContactTel' => $user->emergencyContactTel,
            'emergencyContactRelationship' => $user->emergencyContactRelationship,
        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Exclude username — users cannot change their login email here
        unset($data['username']);

        auth()->user()->update($data);

        Notification::make()
            ->title('Profile saved')
            ->success()
            ->send();

        $this->redirect(ViewProfile::getUrl(panel: 'general', tenant: Filament::getTenant()));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Personal Information')
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
                        TextInput::make('knownName')
                            ->label('Known As'),
                        TextInput::make('scoutName')
                            ->label('Scout Name'),
                        Select::make('sex')
                            ->options(UserSex::class),
                        DatePicker::make('dob')
                            ->label('Date of Birth'),
                    ]),

                Section::make('Contact Details')
                    ->columns(3)
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

                Section::make('Address')
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

                Section::make('Emergency Contact')
                    ->columns(3)
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
                ->url(fn () => ViewProfile::getUrl(panel: 'general', tenant: Filament::getTenant())),
        ];
    }
}

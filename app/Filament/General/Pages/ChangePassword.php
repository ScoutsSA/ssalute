<?php

namespace App\Filament\General\Pages;

use App\Rules\CurrentPasswordUsingAuthProvider;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Validation\Rules\Password as PasswordRule;

class ChangePassword extends Page
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::Key;

    protected static ?string $title = 'Change Password';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    protected string $view = 'filament.general.pages.edit-profile';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function save(): void
    {
        $data = $this->form->getState();

        auth()->user()->setEncryptedPassword($data['password']);

        Notification::make()
            ->title('Password changed successfully')
            ->success()
            ->send();

        $this->form->fill();

        $this->redirect(ViewProfile::getUrl(panel: 'general', tenant: Filament::getTenant()));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Change Password')
                    ->description('Enter your current password and choose a new one.')
                    ->schema([
                        TextInput::make('current_password')
                            ->label('Current Password')
                            ->password()
                            ->revealable()
                            ->required()
                            ->rules([resolve(CurrentPasswordUsingAuthProvider::class)])
                            ->columnSpanFull(),
                        TextInput::make('password')
                            ->label('New Password')
                            ->password()
                            ->revealable()
                            ->required()
                            ->rules([PasswordRule::defaults()])
                            ->confirmed()
                            ->columnSpanFull(),
                        TextInput::make('password_confirmation')
                            ->label('Confirm New Password')
                            ->password()
                            ->revealable()
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Change Password')
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

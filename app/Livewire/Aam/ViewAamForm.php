<?php

namespace App\Livewire\Aam;

use App\Constants\AamStatuses;
use App\Constants\UserConstants;
use App\Mail\Aam\ApplicationAdultMembershipApplicantApprovedEmail;
use App\Mail\Aam\ApplicationAdultMembershipApplicantDeclinedEmail;
use App\Models\ApplicationAdultMembershipRequest;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ViewAamForm extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public ApplicationAdultMembershipRequest $aamRequest;

    public function mount(ApplicationAdultMembershipRequest $aamRequest = null)
    {
        $this->aamRequest = $aamRequest;
    }

    public function render()
    {
        return view('livewire.aam.view-aam-form');
    }

    public function aamInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->aamRequest)
            ->schema([
                Section::make('Application')
                    ->heading(fn (ApplicationAdultMembershipRequest $record) => 'Adult Application for Membership - ' . AamStatuses::STATUSES[$record->status] ?? $record->status)
                    ->columns(3)
                    ->schema([
                        Fieldset::make('Application Process')
                            ->visible(fn ($record) => $record->status !== AamStatuses::PENDING)
                            ->columns(5)
                            ->schema([
                                TextEntry::make('status')
                                    ->label('Application Status')
                                    ->badge()
                                    ->columnSpan(3)
                                    ->color(fn (string $state): string => match ($state) {
                                        AamStatuses::PENDING => 'gray',
                                        AamStatuses::APPROVED => 'success',
                                        AamStatuses::DECLINED => 'danger',
                                    })
                                    ->formatStateUsing(fn (string $state) => AamStatuses::STATUSES[$state] ?? $state),

                                TextEntry::make('approvedBy.name')
                                    ->label('Approved By')
                                    ->visible(fn ($record) => $record->status === AamStatuses::APPROVED),
                                TextEntry::make('approved_at')
                                    ->label('Approved At')
                                    ->dateTime()
                                    ->visible(fn ($record) => $record->status === AamStatuses::APPROVED),

                                TextEntry::make('declinedBy.name')
                                    ->label('Declined By')
                                    ->visible(fn ($record) => $record->status === AamStatuses::DECLINED),
                                TextEntry::make('declined_at')
                                    ->label('Declined At')
                                    ->dateTime()
                                    ->visible(fn ($record) => $record->status === AamStatuses::DECLINED),
                                TextEntry::make('declined_notes_internal')
                                    ->label('Declined Internal Notes')
                                    ->columnSpan(3)
                                    ->visible(fn ($record) => $record->status === AamStatuses::DECLINED),
                                TextEntry::make('declined_reason')
                                    ->label('Declined Reason')
                                    ->columnSpan(2)
                                    ->visible(fn ($record) => $record->status === AamStatuses::DECLINED),
                            ]),
                        Fieldset::make('pending_applicant')
                            ->label('Applicant')
                            ->visible(fn ($record) => $record->status === AamStatuses::PENDING)
                            ->schema([
                                TextEntry::make('status')
                                    ->label('Application Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        AamStatuses::PENDING => 'gray',
                                        AamStatuses::APPROVED => 'success',
                                        AamStatuses::DECLINED => 'danger',
                                    })
                                    ->formatStateUsing(fn (string $state) => AamStatuses::STATUSES[$state] ?? $state),
                                TextEntry::make('name'),
                                TextEntry::make('email'),
                                TextEntry::make('phone_number'),
                            ]),
                        Fieldset::make('actioned_applicant')
                            ->label('Applicant')
                            ->visible(fn ($record) => $record->status !== AamStatuses::PENDING)
                            ->columns(3)
                            ->schema([
                                TextEntry::make('name'),
                                TextEntry::make('email'),
                                TextEntry::make('phone_number'),
                            ]),
                    ])
                    ->headerActions([
                        Action::make('decline')
                            ->action($this->declineAction())
                            ->visible(fn ($record) => $record->status === AamStatuses::PENDING)
                            ->requiresConfirmation()
                            ->modalHeading('Decline Application?')
                            ->modalDescription('To decline an application you need to give a reason!')
                            ->modalSubmitActionLabel('Decline Application')

                            ->color(Color::Red)
                            ->form([
                                Textarea::make('declined_notes_internal')
                                    ->label('Internal Reason/notes')
                                    ->helperText("This won't be shared externally!"),

                                Textarea::make('declined_reason')
                                    ->required()
                                    ->helperText('This WILL be shared with the person!'),
                            ]),
                        Action::make('Approve')
                            ->action($this->approveAction())
                            ->visible(fn ($record) => $record->status === AamStatuses::PENDING)
                            ->requiresConfirmation()
                            ->modalHeading('Approve Application?')
                            ->modalDescription('Have you verified their information?')
                            ->modalSubmitActionLabel('Approve Application')
                            ->color(Color::Green)
                            ->modalIcon('heroicon-o-check-badge')
                            ->modalIconColor(Color::Green),

                    ]),

                Tabs::make()
                    ->tabs([
                        Tabs\Tab::make('Personal Details')
                            ->columns(3)
                            ->schema([
                                Fieldset::make('Name')
                                    ->columns(5)
                                    ->schema([
                                        TextEntry::make('title')
                                            ->formatStateUsing(fn (string $state) => UserConstants::TITLES[$state] ?? $state),
                                        TextEntry::make('first_name'),
                                        TextEntry::make('other_names'),
                                        TextEntry::make('surname'),
                                        TextEntry::make('nickname'),
                                    ]),
                                TextEntry::make('sex')
                                    ->formatStateUsing(fn (string $state) => UserConstants::SEX[$state] ?? $state),
                                TextEntry::make('date_of_birth')
                                    ->date(),
                                TextEntry::make('residential_address'),
                            ]),
                        Tabs\Tab::make('Identification')
                            ->schema([
                                Fieldset::make('Passport Information')
                                    ->columns(3)
                                    ->visible(fn (ApplicationAdultMembershipRequest $record) => $record->passport_country !== null)
                                    ->schema([
                                        TextEntry::make('id_number')
                                            ->label('Passport Number'),
                                        TextEntry::make('passport_country')
                                            ->label('Passport Issued By'),
                                        TextEntry::make('passport_date_of_issue')
                                            ->date(),
                                        ImageEntry::make('id_document')
                                            ->label('Passport Document')
                                            ->disk('aam_id_document')
                                            ->visibility('private')
                                            ->columnSpan(3),
                                    ]),
                                Fieldset::make('Passport Information')
                                    ->visible(fn (ApplicationAdultMembershipRequest $record) => $record->passport_country === null)
                                    ->schema([
                                        TextEntry::make('id_number')
                                            ->label('ID Number'),

                                        ImageEntry::make('id_document')
                                            ->label('ID Document')
                                            ->disk('aam_id_document')
                                            ->visibility('private'),
                                    ]),
                            ]),
                        Tabs\Tab::make('Clearance')
                            ->schema([
                                ImageEntry::make('criminal_record')
                                    ->label('Police/Criminal Record')
                                    ->disk('aam_criminal_record')
                                    ->visibility('private'),
                            ]),
                        Tabs\Tab::make('Medical')
                            ->schema([
                                TextEntry::make('medical_conditions')
                                    ->label('Medical Conditions/Allergens')
                                    ->helperText(fn (?string $state) => (is_null($state) ? 'No user input' : '')),
                                Fieldset::make('Medical Aid')
                                    ->columns(3)
                                    ->schema(
                                        [
                                            TextEntry::make('medical_aid_scheme_name')
                                                ->helperText(fn (?string $state) => (is_null($state) ? 'No user input' : '')),
                                            TextEntry::make('medical_aid_number')
                                                ->helperText(fn (?string $state) => (is_null($state) ? 'No user input' : '')),
                                            TextEntry::make('medical_aid_principal_member')
                                                ->helperText(fn (?string $state) => (is_null($state) ? 'No user input' : '')),
                                        ]),
                            ]),
                        Tabs\Tab::make('Other')
                            ->schema([
                                Fieldset::make('Emergency Contact')
                                    ->schema([
                                        TextEntry::make('emergency_contact_name'),
                                        TextEntry::make('emergency_contact_phone_number'),
                                    ]),
                                // Religion
                                // Race
                                IconEntry::make('has_given_public_media_consent')
                                    ->boolean(),

                            ]),
                    ]),

            ]);
    }

    public function approveAction()
    {
        return function () {
            Log::info('ViewAamForm - Approve Action', ['aamRequest' => $this->aamRequest->id, 'user' => auth()->id()]);
            $this->aamRequest->update([
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'status' => AamStatuses::APPROVED,
            ]);
            Notification::make()
                ->title('Application Approved')
                ->success()
                ->send();

            // Send off some emails
            Mail::to($this->aamRequest->email)->queue(new ApplicationAdultMembershipApplicantApprovedEmail($this->aamRequest));

            // create system_user and maybe a user on our end
        };
    }

    public function declineAction()
    {
        return function (array $data) {
            $this->aamRequest->update([
                'declined_by' => auth()->id(),
                'declined_at' => now(),
                'declined_notes_internal' => $data['declined_notes_internal'],
                'declined_reason' => $data['declined_reason'],
                'status' => AamStatuses::DECLINED,
            ]);
            Notification::make()
                ->title('The Application has been Declined!')
                ->warning()
                ->send();

            // Send off some emails
            Mail::to($this->aamRequest->email)->queue(new ApplicationAdultMembershipApplicantDeclinedEmail($this->aamRequest));
        };
    }
}

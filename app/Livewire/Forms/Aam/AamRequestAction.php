<?php

namespace App\Livewire\Forms\Aam;

use App\Enums\Forms\Aam\AamStatuses;
use App\Models\Forms\ApplicationAdultMembershipRequest;
use App\Settings\FormSettings;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class AamRequestAction extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ApplicationAdultMembershipRequest $aamRequest;

    public function mount(Request $request, ApplicationAdultMembershipRequest $aamRequest)
    {
        if (! resolve(FormSettings::class)->aam_enabled) {
            abort(404);
        }
        $this->aamRequest = $aamRequest;
    }

    public function render()
    {
        return view('forms.aam.aam_request_action')
            ->layoutData([
                'title' => 'AAM - Ssalute',
            ]);
    }

    public function aamInfolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->aamRequest)
            ->schema([
                Section::make('Application')
                    ->heading(fn (ApplicationAdultMembershipRequest $record) => 'Adult Application for Membership')
                    ->headerActions([
                        Action::make('decline')
                            ->action($this->declineAction())
                            ->visible(fn ($record) => $record->status === AamStatuses::PENDING)
                            ->requiresConfirmation()
                            ->modalHeading('Decline Application?')
                            ->modalDescription('To decline an application you need to give a reason!')
                            ->modalSubmitActionLabel('Decline Application')
                            ->color(Color::Red)
                            ->schema([
                                Textarea::make('declined_notes_internal')
                                    ->label('Internal Reason/notes')
                                    ->helperText("This won't be shared externally!"),
                                Textarea::make('declined_reason_external')
                                    ->label('External Reason')
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

                    ])
                    ->schema([
                        Fieldset::make('Application Information')
                            ->columns(['sm' => 2, 'md' => 4, 'lg' => 4, 'xl' => 4])
                            ->schema([
                                TextEntry::make('name'),
                                TextEntry::make('email'),
                                TextEntry::make('phone_number'),
                                TextEntry::make('status')
                                    ->label('Application Status')
                                    ->badge(),

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
                                TextEntry::make('declined_reason_external')
                                    ->label('Declined Reason')
                                    ->visible(fn ($record) => $record->status === AamStatuses::DECLINED),
                            ]),
                    ]),

                Tabs::make()
                    ->persistTabInQueryString()
                    ->tabs([
                        Tab::make('Personal Details')
                            ->columns(2)
                            ->schema([
                                Fieldset::make('Name')
                                    ->columns(['sm' => 2, 'md' => 3, 'lg' => 5, 'xl' => 5])
                                    ->columnSpanFull()
                                    ->schema([
                                        TextEntry::make('title'),
                                        TextEntry::make('first_name'),
                                        TextEntry::make('other_names'),
                                        TextEntry::make('surname'),
                                        TextEntry::make('nickname'),
                                    ]),
                                TextEntry::make('sex'),
                                TextEntry::make('date_of_birth')
                                    ->date(),
                                TextEntry::make('residential_address')
                                    ->html()
                                    ->formatStateUsing(fn ($state) => nl2br(e((string) $state)))
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Identification')
                            ->columns(2)
                            ->schema([
                                Fieldset::make('Passport Information')
                                    ->columns(['sm' => 2, 'md' => 3, 'lg' => 3])
                                    ->visible(fn (ApplicationAdultMembershipRequest $record) => $record->passport_country !== null)
                                    ->schema([
                                        TextEntry::make('id_number')
                                            ->label('Passport Number'),
                                        TextEntry::make('passport_country')
                                            ->label('Passport Issued By'),
                                        TextEntry::make('passport_date_of_issue')
                                            ->date(),
                                    ]),
                                Fieldset::make('ID Information')
                                    ->visible(fn (ApplicationAdultMembershipRequest $record) => $record->passport_country === null)

                                    ->schema([
                                        TextEntry::make('id_number')
                                            ->label('ID Number'),
                                    ]),
                                ImageEntry::make('id_document')
                                    ->label(fn (ApplicationAdultMembershipRequest $record) => $record->passport_country === null ? 'ID Document' : 'Passport Document')
                                    ->disk('forms_aam_id_document')
                                    ->columnSpan(1),
                            ]),
                        Tab::make('Clearance')
                            ->schema([
                                ImageEntry::make('criminal_record')
                                    ->label('Police/Criminal Record')
                                    ->disk('forms_aam_criminal_record')
                                    ->visibility('private'),
                            ]),
                        Tab::make('Medical')
                            ->schema([
                                TextEntry::make('medical_conditions')
                                    ->label('Medical Conditions/Allergens'),
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
                        Tab::make('Other')
                            ->columns(3)
                            ->schema([
                                Fieldset::make('Emergency Contact')
                                    ->columnSpan(2)
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
                'declined_reason_external' => $data['declined_reason_external'],
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

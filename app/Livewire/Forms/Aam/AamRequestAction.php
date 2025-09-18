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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class AamRequestAction extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ApplicationAdultMembershipRequest $aamRequest;

    public static function getAamRequestSchema(bool $withInternalReason = false, $withActions = false): array
    {
        $actions = $withActions ? self::getHeaderActions() : [];

        return [
            Section::make('Application')
                ->secondary()
                ->heading(fn (ApplicationAdultMembershipRequest $record) => 'Adult Application for Membership')
                ->headerActions($actions)
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

                            TextEntry::make('actionedBy.name')
                                ->label('Actioned By')
                                ->visible(fn ($record) => $record->status !== AamStatuses::PENDING),
                            TextEntry::make('actioned_at')
                                ->label('Actioned At')
                                ->dateTime()
                                ->visible(fn ($record) => $record->status !== AamStatuses::PENDING),
                            TextEntry::make('actioned_notes_internal')
                                ->label('Notes (Internal)')
                                ->visible(fn ($record) => ($record->status !== AamStatuses::PENDING) && $withInternalReason === true),
                            TextEntry::make('actioned_reason_external')
                                ->label('Reasoning (External)')
                                ->visible(fn ($record) => $record->status !== AamStatuses::PENDING),

                        ]),
                ]),

            Section::make('Information')
                ->secondary()
                ->schema(
                    [

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
                                            ->visible(fn (ApplicationAdultMembershipRequest $record) => $record->has_south_african_id === false)
                                            ->schema([
                                                TextEntry::make('id_number')
                                                    ->label('Passport Number'),
                                                TextEntry::make('passport_country')
                                                    ->label('Passport Issued By'),
                                                TextEntry::make('passport_date_of_issue')
                                                    ->date(),
                                            ]),
                                        Fieldset::make('ID Information')
                                            ->visible(fn (ApplicationAdultMembershipRequest $record) => $record->has_south_african_id === true)
                                            ->schema([
                                                TextEntry::make('id_number')
                                                    ->label('ID Number'),
                                            ]),
                                        ImageEntry::make('id_document')
                                            ->label(fn (ApplicationAdultMembershipRequest $record) => $record->has_south_african_id ? 'ID Document' : 'Passport Document')
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
                    ]),

        ];
    }

    public static function getHeaderActions(): array
    {
        return [
            Action::make('decline')
                ->action(fn (AamRequestAction $livewire, array $data) => $livewire->declineAction($data))
                ->visible(fn ($record) => $record->status === AamStatuses::PENDING)
                ->requiresConfirmation()
                ->modalHeading('Decline Application?')
                ->modalDescription('To decline an application you need to give a reason!')
                ->modalSubmitActionLabel('Decline Application')
                ->color(Color::Red)
                ->schema([
                    Textarea::make('actioned_notes_internal')
                        ->label('Internal notes'),
                    Textarea::make('actioned_reason_external')
                        ->label('External Reason')
                        ->placeholder('Unfortunately we are unable to accept your application at this time due to your background checks.')
                        ->required()
                        ->helperText('This WILL be shared with the person!'),
                ]),
            Action::make('Approve')
                ->action(fn (AamRequestAction $livewire, array $data) => $livewire->approveAction($data))
                ->visible(fn ($record) => $record->status === AamStatuses::PENDING)
                ->requiresConfirmation()
                ->modalHeading('Approve Application?')
                ->modalDescription('Have you verified their information?')
                ->modalSubmitActionLabel('Approve Application')
                ->color(Color::Green)
                ->schema([
                    Textarea::make('actioned_notes_internal')

                        ->label('Internal notes'),
                    Textarea::make('actioned_reason_external')
                        ->label('External Reason/Note')
                        ->placeholder('Welcome to the Scouting family!')
                        ->helperText('Do you want to share a note or anything with the new Adult?'),
                ])
                ->modalIcon('heroicon-o-check-badge')
                ->modalIconColor(Color::Green),

        ];
    }

    public function mount(Request $request, ApplicationAdultMembershipRequest $aamRequest)
    {
        if (! resolve(FormSettings::class)->aam_enabled) {
            abort(404);
        }

        // This authorization check should probably move to a policy or gate
        /** @var Collection $aamRequest->scoutersWhoCanApprove */
        if ($aamRequest->scoutersWhoCanApprove->doesntContain('id', Auth::id()) && ! Auth::user()->isSuperAdmin()) {
            abort(403, 'You do not have permission to view this AAM form');
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
            ->schema(self::getAamRequestSchema(withInternalReason: true, withActions: true));
    }

    public function approveAction(array $data)
    {
        Log::info('ViewAamForm - Approve Action', ['aamRequest' => $this->aamRequest->id, 'user' => auth()->id()]);

        $this->aamRequest->approve(
            actionedBy: auth()->user(),
            externalReason: $data['actioned_reason_external'],
            internalNotes: $data['actioned_notes_internal'],
        );
        Notification::make()
            ->title('Application Approved')
            ->success()
            ->send();

    }

    public function declineAction(array $data)
    {
        Log::info('ViewAamForm - Decline Action', ['aamRequest' => $this->aamRequest->id, 'user' => auth()->id()]);
        $this->aamRequest->decline(
            actionedBy: auth()->user(),
            externalReason: $data['actioned_reason_external'],
            internalNotes: $data['actioned_notes_internal'],
        );
        Notification::make()
            ->title('The Application has been Declined!')
            ->danger()
            ->send();
    }
}

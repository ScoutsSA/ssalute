<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
use App\Models\AmsAdultLeaderMove;
use App\Models\AmsResignLeader;
use App\Models\AmsResignReason;
use App\Models\AmsRetireLeader;
use App\Models\AmsRetireReason;
use App\Models\AmsSuspendLeader;
use App\Models\AmsSuspendReason;
use App\Models\AmsTerminateLeader;
use App\Models\AmsTerminateReason;
use App\Models\District;
use App\Models\Group;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use STS\FilamentImpersonate\Actions\Impersonate;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        /** @var SystemUser $record */
        $record = $this->getRecord();

        return [
            EditAction::make(),
            Impersonate::make()
                ->record($record)
                ->redirectTo(function () use ($record): string {
                    $tenant = $record->getDefaultTenant(Filament::getPanel('general'));

                    return $tenant ? Dashboard::getUrl(panel: 'general', tenant: $tenant) : '/general';
                }),
            Action::make('SD_Login')
                ->label('Impersonate on SD')
                ->icon(Heroicon::ArrowTopRightOnSquare)
                ->color('gray')
                ->url(fn (): string => URL::temporarySignedRoute(
                    'impersonate.scouts-digital',
                    now()->addSeconds(60),
                    ['user' => $record->id],
                ))
                ->openUrlInNewTab(),

            Action::make('activate')
                ->label('Activate')
                ->icon(Heroicon::CheckCircle)
                ->color('success')
                ->visible(fn () => $record->active === 0)
                ->requiresConfirmation()
                ->modalHeading('Activate Member')
                ->modalDescription("Are you sure you want to reactivate {$record->name}? This will set the user as active and re-enable login.")
                ->action(function () use ($record): void {
                    $record->update([
                        'active' => 1,
                        'canLogon' => 1,
                        'dateDeactivated' => null,
                        'deactivatedBy' => null,
                    ]);

                    Notification::make()
                        ->title("{$record->name} has been activated")
                        ->success()
                        ->send();
                }),

            ActionGroup::make([
                Action::make('move')
                    ->label('Move')
                    ->icon(Heroicon::ArrowsRightLeft)
                    ->color('gray')
                    ->visible(fn () => $record->active === 1)
                    ->modalHeading('Move Member')
                    ->modalDescription("Move {$record->name} from one role/location to another. This creates a move record and updates the specified role attachment.")
                    ->schema([
                        Select::make('roleAttachmentId')
                            ->label('Role to Move')
                            ->options(function () use ($record) {
                                return $record->activeRoleAttachments()
                                    ->with('role')
                                    ->get()
                                    ->mapWithKeys(fn (SystemUsersOtherRole $a) => [
                                        $a->id => ($a->role?->name ?? 'Unknown') . ' — ' . $a->roleAttachmentScopedLabel,
                                    ]);
                            })
                            ->required()
                            ->columnSpanFull(),
                        Select::make('toPosition')
                            ->label('New Role Type')
                            ->options(fn () => SystemUserType::active()->orderBy('position')->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('toGroup')
                            ->label('New Group')
                            ->options(fn () => Group::where('active', 1)->orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->placeholder('None'),
                        Select::make('toDistrict')
                            ->label('New District')
                            ->options(fn () => District::orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->placeholder('None'),
                        DatePicker::make('effectiveDate')
                            ->label('Effective Date')
                            ->required()
                            ->default(now()),
                    ])
                    ->action(function (array $data) use ($record): void {
                        $this->processMove($record, $data);
                    }),

                Action::make('resign')
                    ->label('Resign')
                    ->icon(Heroicon::ArrowRightOnRectangle)
                    ->color('warning')
                    ->visible(fn () => $record->active === 1)
                    ->modalHeading('Resign Member')
                    ->modalDescription("Record a resignation for {$record->name}. This will deactivate the member and mark all active role attachments as resigned.")
                    ->schema([
                        DatePicker::make('resignDate')
                            ->label('Resignation Date')
                            ->required()
                            ->default(now()),
                        Select::make('resignReasonID')
                            ->label('Reason')
                            ->options(AmsResignReason::pluck('reason', 'id'))
                            ->required()
                            ->searchable(),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3),
                    ])
                    ->action(function (array $data) use ($record): void {
                        $this->processResignation($record, $data);
                    }),

                Action::make('retire')
                    ->label('Retire')
                    ->icon(Heroicon::GiftTop)
                    ->color('info')
                    ->visible(fn () => $record->active === 1)
                    ->modalHeading('Retire Member')
                    ->modalDescription("Record a retirement for {$record->name}. This will deactivate the member and mark all active role attachments as retired.")
                    ->schema([
                        DatePicker::make('retiredDate')
                            ->label('Retirement Date')
                            ->required()
                            ->default(now()),
                        Select::make('retiredReasonID')
                            ->label('Reason')
                            ->options(AmsRetireReason::pluck('reason', 'id'))
                            ->required()
                            ->searchable(),
                    ])
                    ->action(function (array $data) use ($record): void {
                        $this->processRetirement($record, $data);
                    }),

                Action::make('suspend')
                    ->label('Suspend')
                    ->icon(Heroicon::NoSymbol)
                    ->color('danger')
                    ->visible(fn () => $record->active === 1)
                    ->modalHeading('Suspend Member')
                    ->modalDescription("Suspend {$record->name}. This will mark all active role attachments as suspended and disable login.")
                    ->schema([
                        DatePicker::make('suspendDate')
                            ->label('Suspension Date')
                            ->required()
                            ->default(now()),
                        Select::make('suspenReasonID')
                            ->label('Reason')
                            ->options(AmsSuspendReason::pluck('reason', 'id'))
                            ->required()
                            ->searchable(),
                    ])
                    ->action(function (array $data) use ($record): void {
                        $this->processSuspension($record, $data);
                    }),

                Action::make('unsuspend')
                    ->label('Unsuspend')
                    ->icon(Heroicon::LockOpen)
                    ->color('success')
                    ->visible(function () use ($record) {
                        return $record->activeRoleAttachments()
                            ->where('suspended', 1)
                            ->exists();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Unsuspend Member')
                    ->modalDescription("Remove the suspension from {$record->name}. This will clear the suspended flag on all role attachments and re-enable login.")
                    ->action(function () use ($record): void {
                        $this->processUnsuspension($record);
                    }),

                Action::make('terminate')
                    ->label('Terminate')
                    ->icon(Heroicon::XCircle)
                    ->color('danger')
                    ->visible(fn () => $record->active === 1)
                    ->modalHeading('Terminate Member')
                    ->modalDescription("Terminate {$record->name}. This is a serious action — the member will be fully deactivated and all roles will be marked inactive.")
                    ->schema([
                        DatePicker::make('terminateDate')
                            ->label('Termination Date')
                            ->required()
                            ->default(now()),
                        Select::make('terminateReasonID')
                            ->label('Reason')
                            ->options(AmsTerminateReason::pluck('reason', 'id'))
                            ->required()
                            ->searchable(),
                    ])
                    ->requiresConfirmation()
                    ->action(function (array $data) use ($record): void {
                        $this->processTermination($record, $data);
                    }),
            ])
                ->label('Member Actions')
                ->icon(Heroicon::EllipsisVertical)
                ->color('gray'),
        ];
    }

    private function processResignation(SystemUser $record, array $data): void
    {
        DB::transaction(function () use ($record, $data): void {
            AmsResignLeader::create([
                'userID' => $record->id,
                'resignDate' => $data['resignDate'],
                'resignReasonID' => $data['resignReasonID'],
                'countryID' => 196,
                'assocToRegion' => $record->assoc_to_region ?? 0,
                'assocToDistrict' => $record->assoc_to_district ?? 0,
                'assocToGroup' => $record->assoc_to_group ?? 0,
                'created' => now(),
                'createdby' => auth()->id(),
            ]);

            $record->activeRoleAttachments()->update([
                'active' => 0,
                'resigned' => 1,
            ]);

            $record->update([
                'active' => 0,
                'canLogon' => 0,
                'dateDeactivated' => now(),
                'deactivatedBy' => auth()->id(),
            ]);
        });

        Notification::make()
            ->title("{$record->name} has been resigned")
            ->success()
            ->send();
    }

    private function processRetirement(SystemUser $record, array $data): void
    {
        DB::transaction(function () use ($record, $data): void {
            AmsRetireLeader::create([
                'userID' => $record->id,
                'retiredDate' => $data['retiredDate'],
                'retiredReasonID' => $data['retiredReasonID'],
                'countryID' => 196,
                'assocToRegion' => $record->assoc_to_region ?? 0,
                'assocToDistrict' => $record->assoc_to_district ?? 0,
                'assocToGroup' => $record->assoc_to_group ?? 0,
                'created' => now(),
                'createdby' => auth()->id(),
            ]);

            $record->activeRoleAttachments()->update([
                'active' => 0,
                'retired' => 1,
            ]);

            $record->update([
                'active' => 0,
                'canLogon' => 0,
                'dateDeactivated' => now(),
                'deactivatedBy' => auth()->id(),
            ]);
        });

        Notification::make()
            ->title("{$record->name} has been retired")
            ->success()
            ->send();
    }

    private function processSuspension(SystemUser $record, array $data): void
    {
        DB::transaction(function () use ($record, $data): void {
            AmsSuspendLeader::create([
                'userID' => $record->id,
                'suspendDate' => $data['suspendDate'],
                'suspenReasonID' => $data['suspenReasonID'],
                'countryID' => 196,
                'assocToRegion' => $record->assoc_to_region ?? 0,
                'assocToDistrict' => $record->assoc_to_district ?? 0,
                'assocToGroup' => $record->assoc_to_group ?? 0,
                'created' => now(),
                'createdby' => auth()->id(),
            ]);

            $record->activeRoleAttachments()->update([
                'suspended' => 1,
            ]);

            $record->update([
                'canLogon' => 0,
            ]);
        });

        Notification::make()
            ->title("{$record->name} has been suspended")
            ->warning()
            ->send();
    }

    private function processUnsuspension(SystemUser $record): void
    {
        DB::transaction(function () use ($record): void {
            $record->activeRoleAttachments()
                ->where('suspended', 1)
                ->update([
                    'suspended' => 0,
                ]);

            $latestSuspension = AmsSuspendLeader::where('userID', $record->id)
                ->whereNull('unsuspendDate')
                ->latest('id')
                ->first();

            if ($latestSuspension) {
                $latestSuspension->update([
                    'unsuspendDate' => now(),
                    'unsuspendedby' => auth()->id(),
                ]);
            }

            $record->update([
                'canLogon' => 1,
            ]);
        });

        Notification::make()
            ->title("{$record->name} has been unsuspended")
            ->success()
            ->send();
    }

    private function processTermination(SystemUser $record, array $data): void
    {
        DB::transaction(function () use ($record, $data): void {
            AmsTerminateLeader::create([
                'userID' => $record->id,
                'terminateDate' => $data['terminateDate'],
                'terminateReasonID' => $data['terminateReasonID'],
                'countryID' => 196,
                'assocToRegion' => $record->assoc_to_region ?? 0,
                'assocToDistrict' => $record->assoc_to_district ?? 0,
                'assocToGroup' => $record->assoc_to_group ?? 0,
                'created' => now(),
                'createdby' => auth()->id(),
            ]);

            $record->activeRoleAttachments()->update([
                'active' => 0,
            ]);

            $record->update([
                'active' => 0,
                'canLogon' => 0,
                'dateDeactivated' => now(),
                'deactivatedBy' => auth()->id(),
            ]);
        });

        Notification::make()
            ->title("{$record->name} has been terminated")
            ->danger()
            ->send();
    }

    private function processMove(SystemUser $record, array $data): void
    {
        $roleAttachment = $record->roleAttachments()->find($data['roleAttachmentId']);

        if (! $roleAttachment) {
            Notification::make()
                ->title('Role attachment not found')
                ->danger()
                ->send();

            return;
        }

        DB::transaction(function () use ($record, $roleAttachment, $data): void {
            AmsAdultLeaderMove::create([
                'userID' => $record->id,
                'fromPosition' => $roleAttachment->roleID,
                'ToPosition' => $data['toPosition'],
                'fromGroup' => $roleAttachment->groupID ?? 0,
                'toGroup' => $data['toGroup'] ?? 0,
                'fromDistrict' => $roleAttachment->districtID ?? 0,
                'toDistrict' => $data['toDistrict'] ?? 0,
                'effectiveDate' => $data['effectiveDate'],
                'countryID' => 196,
                'assocToRegion' => $roleAttachment->regionID ?? $record->assoc_to_region ?? 0,
                'created' => now(),
                'createdby' => auth()->id(),
            ]);

            $roleAttachment->update([
                'roleID' => $data['toPosition'],
                'groupID' => $data['toGroup'] ?? $roleAttachment->groupID,
                'districtID' => $data['toDistrict'] ?? $roleAttachment->districtID,
            ]);
        });

        Notification::make()
            ->title("{$record->name} has been moved successfully")
            ->success()
            ->send();
    }
}

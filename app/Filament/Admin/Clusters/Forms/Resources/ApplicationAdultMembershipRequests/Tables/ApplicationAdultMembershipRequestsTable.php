<?php

namespace App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Tables;

use App\Models\Forms\ApplicationAdultMembershipRequest;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ApplicationAdultMembershipRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderableColumns()
            ->recordUrl(fn ($record) => route('forms.aam.action', ['aamRequest' => $record->action_slug]), shouldOpenInNewTab: true)
            ->deferColumnManager(false)
            ->defaultSort('updated_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('region.name')
                    ->label('Area')
                    ->description(fn (ApplicationAdultMembershipRequest $record) => $record->locationName)
                    ->toggleable(),
                TextColumn::make('status')
                    ->visible(fn (ListRecords $livewire) => $livewire->activeTab === 'all')
                    ->badge()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->sortable(['surname', 'first_name'])
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('nextInLineScouter')
                    ->label('Next in line Scouter')
                    ->state(fn (ApplicationAdultMembershipRequest $record) => $record->nextInLineScouter->name ?? 'N/A')
                    ->tooltip('This is determined from the relevant SGL->DC->RTC-AS->NationalChair-AS')
                    ->visible(fn (ListRecords $livewire) => in_array($livewire->activeTab, ['pending', 'all']))
                    ->toggleable(),
                TextColumn::make('scoutersWhoCanApprove')
                    ->label('Approval Scouters')
                    ->badge()
                    ->state(fn (ApplicationAdultMembershipRequest $record) => $record->scoutersWhoCanApprove->pluck('name')->toArray() ?? ['N/A'])
                    ->tooltip('This is the full "teams" of scouters in the chain SGL->[DC,DCGM,DCM]->[RTC-AS,RAS-TM, RAS-TMG]->NationalChair-AS')
                    ->listWithLineBreaks()
                    ->visible(fn (ListRecords $livewire) => in_array($livewire->activeTab, ['pending', 'all']))
                    ->toggleable(),
                TextColumn::make('actioned_at')
                    ->dateTime()
                    ->sortable()
                    ->visible(fn (ListRecords $livewire) => $livewire->activeTab !== 'pending')
                    ->toggleable(),
                TextColumn::make('actionedBy.name')
                    ->numeric()
                    ->sortable()
                    ->visible(fn (ListRecords $livewire) => $livewire->activeTab !== 'pending')
                    ->toggleable(),

                TextColumn::make('actioned_notes_internal')
                    ->label('Actioned notes (internal)')
                    ->visible(fn (ListRecords $livewire) => $livewire->activeTab !== 'pending')
                    ->toggleable(),
                TextColumn::make('actioned_reason_external')
                    ->label('Actioned reasoned (external)')
                    ->visible(fn (ListRecords $livewire) => $livewire->activeTab !== 'pending')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('ViewApprovalPage')
                    ->label('Approval Page')
                    ->button()
                    ->url(fn ($record) => route('forms.aam.action', ['aamRequest' => $record->action_slug]), shouldOpenInNewTab: true),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('Resend Initial Emails')
                        ->requiresConfirmation()
                        ->modalDescription('This will only resend if the selected email is in the correct state')
                        ->successNotificationTitle('Emails have been queued for sending')
                        ->visible(fn (ListRecords $livewire) => in_array($livewire->activeTab, ['pending', 'all']))
                        ->action(fn (Collection $records) => $records->each->sendEmailsInitial()),

                    BulkAction::make('Resend Approval Email')
                        ->requiresConfirmation()
                        ->modalDescription('This will only resend if the selected email is in the correct state')
                        ->successNotificationTitle('Emails have been queued for sending')
                        ->visible(fn (ListRecords $livewire) => in_array($livewire->activeTab, ['approved', 'all']))
                        ->action(fn (Collection $records) => $records->each->sendEmailsApproved()),

                    BulkAction::make('Resend Rejection Email')
                        ->requiresConfirmation()
                        ->modalDescription('This will only resend if the selected email is in the correct state')
                        ->successNotificationTitle('Emails have been queued for sending')
                        ->visible(fn (ListRecords $livewire) => in_array($livewire->activeTab, ['declined', 'all']))
                        ->action(fn (Collection $records) => $records->each->sendEmailsDeclined()),
                ]),
            ]);
    }
}

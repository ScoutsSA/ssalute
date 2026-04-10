<?php

namespace App\Filament\Member\Resources\Profile\RelationManagers;

use App\Mail\Profile\ReportIssueEmail;
use App\Services\FileUrlService;
use App\Services\NextInLineService;
use App\Settings\FeatureSettings;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;

class UserWarrantsRelationManager extends RelationManager
{
    protected static string $relationship = 'warrants';

    protected static ?string $title = 'Warrants';

    protected static ?string $modelLabel = 'warrant';

    protected static ?string $pluralModelLabel = 'warrants';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Warrant Details')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('warrantNr')
                            ->label('Warrant Number')
                            ->badge()
                            ->color('primary'),
                        TextEntry::make('warrantName')
                            ->label('Name')
                            ->placeholder('-'),
                        TextEntry::make('warrantType.name')
                            ->label('Type')
                            ->placeholder('-'),
                        TextEntry::make('role.name')
                            ->label('Role')
                            ->placeholder('-'),
                        TextEntry::make('issueDate')
                            ->label('Issued')
                            ->date(),
                        TextEntry::make('expireDate')
                            ->label('Expires')
                            ->date()
                            ->placeholder('-'),
                        TextEntry::make('active')
                            ->label('Status')
                            ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'danger'),
                        TextEntry::make('PDFLocation')
                            ->label('Document')
                            ->formatStateUsing(fn ($state) => $state ? 'View Document' : null)
                            ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                            ->openUrlInNewTab()
                            ->badge()
                            ->color('primary')
                            ->placeholder('-'),
                    ]),
            ]);
    }

    public function getTabs(): array
    {
        return [
            'active' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', 1)),
            'inactive' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', 0)),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('warrantName')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('warrantNr')
                    ->label('Warrant #')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('warrantName')
                    ->label('Name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('warrantType.name')
                    ->label('Type')
                    ->toggleable(),
                TextColumn::make('issueDate')
                    ->label('Issued')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('expireDate')
                    ->label('Expires')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('PDFLocation')
                    ->label('Document')
                    ->formatStateUsing(fn ($state) => $state ? 'View' : null)
                    ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                    ->openUrlInNewTab()
                    ->badge()
                    ->color('primary')
                    ->placeholder('-')
                    ->toggleable(),
            ])
            ->headerActions([
                Action::make('requestMissingWarrant')
                    ->label('Request Missing Warrant')
                    ->icon(Heroicon::ExclamationTriangle)
                    ->color('warning')
                    ->visible(fn () => resolve(FeatureSettings::class)->users_can_report_issues)
                    ->modalHeading('Report a Missing Warrant')
                    ->modalDescription('Let us know about a warrant that is missing from your profile. This will be sent to your next in line scouter, or to the national adult support team.')
                    ->schema([
                        Textarea::make('description')
                            ->label('Describe the missing warrant')
                            ->required()
                            ->default("I believe I am missing a warrant from my warrant profile.\n\nWarrant type: \nExpected role: \nApproximate issue date: \nAdditional details: ")
                            ->rows(8)
                            ->columnSpanFull(),
                        ToggleButtons::make('send_to_national')
                            ->label('Send to')
                            ->options(function () {
                                $nextInLine = app(NextInLineService::class)->resolve(Filament::getTenant());
                                $name = $nextInLine ? trim("{$nextInLine->first_name} {$nextInLine->surname}") : null;
                                $label = $name ? 'Next in Line Scouter - ' . (mb_strlen($name) > 15 ? mb_substr($name, 0, 15) . '...' : $name) : 'Next in Line Scouter';

                                return [
                                    false => $label,
                                    true => 'National Adult Support Team',
                                ];
                            })
                            ->icons([
                                false => Heroicon::UserGroup,
                                true => Heroicon::BuildingOffice2,
                            ])
                            ->colors([
                                false => 'primary',
                                true => 'danger',
                            ])
                            ->default(false)
                            ->helperText('Please only escalate to the National Adult Support Team if your next in line scouter has been unable to help.')
                            ->columnSpanFull(),
                    ])
                    ->action(function (array $data): void {
                        $reporter = auth()->user();
                        $tenant = Filament::getTenant();
                        $service = app(NextInLineService::class);

                        if ($data['send_to_national']) {
                            $to = $service->resolveNationalSupportEmails();
                        } else {
                            $scouters = $service->resolveAll($tenant);
                            $to = $scouters->isEmpty()
                                ? $service->resolveNationalSupportEmails()
                                : $scouters->map(fn ($u) => $u->username)->filter()->all();
                        }

                        $to = array_filter($to, fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL));

                        if (empty($to)) {
                            Notification::make()
                                ->title('No valid email recipients found')
                                ->danger()
                                ->send();

                            return;
                        }

                        Mail::to($to)
                            ->cc($reporter->username)
                            ->send(new ReportIssueEmail($reporter, $data['description'], (bool) $data['send_to_national']));

                        Notification::make()
                            ->title('Missing warrant reported successfully')
                            ->success()
                            ->send();
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}

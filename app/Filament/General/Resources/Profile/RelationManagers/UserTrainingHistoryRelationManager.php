<?php

namespace App\Filament\General\Resources\Profile\RelationManagers;

use App\Models\AmsTrainingPastType;
use App\Services\FileUrlService;
use App\Settings\FeatureSettings;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserTrainingHistoryRelationManager extends RelationManager
{
    protected static string $relationship = 'trainingHistory';

    protected static ?string $title = 'Training History';

    protected static ?string $modelLabel = 'training record';

    protected static ?string $pluralModelLabel = 'training records';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Training Details')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('trainingType.name')
                            ->label('Type')
                            ->placeholder('-'),
                        TextEntry::make('courseName')
                            ->label('Course Name')
                            ->placeholder('-'),
                        TextEntry::make('courseNumber')
                            ->label('Course Number')
                            ->placeholder('-'),
                        TextEntry::make('completionDate')
                            ->label('Completed')
                            ->date()
                            ->placeholder('-'),
                        TextEntry::make('PDFLocation')
                            ->label('Certificate')
                            ->formatStateUsing(fn ($state) => $state ? 'View Certificate' : null)
                            ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                            ->openUrlInNewTab()
                            ->badge()
                            ->color('primary')
                            ->placeholder('-'),
                    ]),

                Section::make('Validation')
                    ->collapsed()
                    ->columns(3)
                    ->icon(fn ($record) => $record->validated ? 'heroicon-o-check-circle' : 'heroicon-o-clock')
                    ->iconColor(fn ($record) => $record->validated ? 'success' : 'warning')
                    ->description(fn ($record) => $record->validated
                        ? 'Validated by ' . ($record->validatedByUser?->name ?? 'Unknown') . ' on ' . ($record->validatedDate?->format('Y/m/d') ?? '-')
                        : 'Not validated')
                    ->schema([
                        TextEntry::make('validated')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn ($state) => $state ? 'Validated' : 'Pending')
                            ->color(fn ($state) => $state ? 'success' : 'warning'),
                        TextEntry::make('validatedByUser.name')
                            ->label('Validated By')
                            ->placeholder('-'),
                        TextEntry::make('validatedDate')
                            ->label('Validated On')
                            ->date()
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
            ->recordTitleAttribute('courseName')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('courseName')
                    ->label('Course')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('courseNumber')
                    ->label('Number')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('trainingType.name')
                    ->label('Type')
                    ->toggleable(),
                TextColumn::make('completionDate')
                    ->label('Completed')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('validated')
                    ->label('Validated')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
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
                CreateAction::make()
                    ->label('Add Training')
                    ->icon('heroicon-o-plus')
                    ->visible(fn () => resolve(FeatureSettings::class)->users_can_add_past_training)
                    ->modalDescription('A Scout\'s honour is to be trusted.')
                    ->schema([
                        TextEntry::make('VerificationRequired')
                            ->hiddenLabel()
                            ->state('Note: Any training added will be verified and confirmed by your regional or national training team.'),
                        Select::make('trainingTypeID')
                            ->label('Training Type')
                            ->options(fn () => AmsTrainingPastType::where('active', 1)->pluck('name', 'id'))
                            ->searchable(),
                        TextInput::make('courseName')
                            ->label('Course Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('courseNumber')
                            ->label('Course Number')
                            ->maxLength(255),
                        DatePicker::make('completionDate')
                            ->label('Completion Date'),
                        FileUpload::make('PDFLocation')
                            ->label('Certificate / Document')
                            ->disk('legacy')
                            ->directory('ssalute/training')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(51200),
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        $user = auth()->user();
                        $tenant = Filament::getTenant();

                        $data['userID'] = $user->id;
                        $data['countryID'] = $tenant->countryID ?? 196;
                        $data['assocToRegion'] = $tenant->regionID;
                        $data['assocToDistrict'] = $tenant->districtID;
                        $data['assocToGroup'] = $tenant->groupID;
                        $data['active'] = 1;
                        $data['validated'] = 0;
                        $data['createdby'] = $user->id;

                        return $data;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}

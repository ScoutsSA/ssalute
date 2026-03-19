<?php

namespace App\Filament\General\Resources\Profile\RelationManagers;

use App\Models\AmsAwardHeading;
use App\Models\AmsAwardType;
use App\Services\FileUrlService;
use App\Settings\FeatureSettings;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserAwardsRelationManager extends RelationManager
{
    protected static string $relationship = 'awards';

    protected static ?string $title = 'Awards';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Award Details')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('heading.reason')
                            ->label('Category')
                            ->placeholder('-'),
                        TextEntry::make('awardType.name')
                            ->label('Award')
                            ->placeholder('-'),
                        TextEntry::make('awardDate')
                            ->label('Date')
                            ->date()
                            ->placeholder('-'),
                        TextEntry::make('active')
                            ->label('Status')
                            ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'danger'),
                        TextEntry::make('PDFLocation')
                            ->label('Certificate')
                            ->formatStateUsing(fn ($state) => $state ? 'View Certificate' : null)
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
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('awardType.name')
                    ->label('Award')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('heading.reason')
                    ->label('Category')
                    ->toggleable(),
                TextColumn::make('awardDate')
                    ->label('Date')
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
                CreateAction::make()
                    ->label('Add Award')
                    ->icon('heroicon-o-plus')
                    ->visible(fn () => resolve(FeatureSettings::class)->users_can_add_awards)
                    ->modalDescription('A Scout\'s honour is to be trusted.')
                    ->form([
                        Select::make('awardHeadingID')
                            ->label('Award Category')
                            ->options(fn () => AmsAwardHeading::pluck('reason', 'id'))
                            ->required()
                            ->searchable()
                            ->live(),
                        Select::make('awardTypeID')
                            ->label('Award')
                            ->options(fn (Get $get) => AmsAwardType::query()
                                ->when($get('awardHeadingID'), fn ($q, $headingId) => $q->where('headingID', $headingId))
                                ->where('active', 1)
                                ->pluck('name', 'id'))
                            ->required()
                            ->searchable(),
                        DatePicker::make('awardDate')
                            ->label('Award Date'),
                        FileUpload::make('PDFLocation')
                            ->label('Certificate / Document')
                            ->disk('legacy')
                            ->directory('ssalute/awards')
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
                        $data['createdby'] = $user->id;

                        return $data;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}

<?php

namespace App\Filament\General\Resources\Profile\RelationManagers;

use App\Models\AmsPastServiceType;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
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
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserPastServiceRelationManager extends RelationManager
{
    protected static string $relationship = 'pastService';

    protected static ?string $title = 'Past Service';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Service Details')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('serviceType.name')
                            ->label('Service Type')
                            ->placeholder('-'),
                        TextEntry::make('startDate')
                            ->label('Start Date')
                            ->date()
                            ->placeholder('-'),
                        TextEntry::make('endDate')
                            ->label('End Date')
                            ->date()
                            ->placeholder('-'),
                        TextEntry::make('otherRegionName')
                            ->label('Region')
                            ->placeholder('-'),
                        TextEntry::make('otherDistrictName')
                            ->label('District')
                            ->placeholder('-'),
                        TextEntry::make('otherGroupName')
                            ->label('Group')
                            ->placeholder('-'),
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
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('serviceType.name')
                    ->label('Service Type')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('startDate')
                    ->label('Start Date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('endDate')
                    ->label('End Date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('otherRegionName')
                    ->label('Region')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('otherDistrictName')
                    ->label('District')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('otherGroupName')
                    ->label('Group')
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
                IconColumn::make('active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Past Service')
                    ->icon('heroicon-o-plus')
                    ->visible(fn () => resolve(FeatureSettings::class)->users_can_add_past_service)
                    ->modalDescription('A Scout\'s honour is to be trusted.')
                    ->form([
                        Select::make('pastServiceType')
                            ->label('Service Type')
                            ->options(fn () => AmsPastServiceType::pluck('name', 'id'))
                            ->required()
                            ->searchable(),
                        DatePicker::make('startDate')
                            ->label('Start Date')
                            ->required(),
                        DatePicker::make('endDate')
                            ->label('End Date'),
                        Grid::make(3)
                            ->schema([
                                Select::make('_group')
                                    ->label('Group')
                                    ->options(fn () => Group::where('active', 1)->orderBy('name')->pluck('name', 'id'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (?string $state, Set $set): void {
                                        if ($state) {
                                            $group = Group::find($state);
                                            if ($group) {
                                                $set('_district', $group->assoc_to_district);
                                                $set('_region', $group->assoc_to_region);
                                            }
                                        }
                                    }),
                                Select::make('_district')
                                    ->label('District')
                                    ->options(fn () => District::where('active', 1)->orderBy('name')->pluck('name', 'id'))
                                    ->searchable()
                                    ->live()
                                    ->required(fn (Get $get): bool => filled($get('_group')))
                                    ->afterStateUpdated(function (?string $state, Set $set): void {
                                        if ($state) {
                                            $district = District::find($state);
                                            if ($district) {
                                                $set('_region', $district->regionID);
                                            }
                                        }
                                    }),
                                Select::make('_region')
                                    ->label('Region')
                                    ->options(fn () => Region::where('active', 1)->orderBy('name')->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(fn (Get $get): bool => filled($get('_group')) || filled($get('_district'))),
                            ]),
                        FileUpload::make('PDFLocation')
                            ->label('Supporting Document')
                            ->disk('legacy')
                            ->directory('ssalute/past-service')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(51200),
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        $user = auth()->user();
                        $tenant = Filament::getTenant();

                        $data['otherGroupName'] = isset($data['_group']) ? Group::find($data['_group'])?->name : null;
                        $data['otherDistrictName'] = isset($data['_district']) ? District::find($data['_district'])?->name : null;
                        $data['otherRegionName'] = isset($data['_region']) ? Region::find($data['_region'])?->name : null;
                        unset($data['_group'], $data['_district'], $data['_region']);

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

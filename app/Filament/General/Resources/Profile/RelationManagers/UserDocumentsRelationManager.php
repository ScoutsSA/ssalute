<?php

namespace App\Filament\General\Resources\Profile\RelationManagers;

use App\Models\AmsDocumentType;
use App\Services\FileUrlService;
use App\Settings\FeatureSettings;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
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

class UserDocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Documents';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Document Details')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('description')
                            ->label('Description')
                            ->placeholder('-'),
                        TextEntry::make('documentType.name')
                            ->label('Document Type')
                            ->placeholder('-'),
                        TextEntry::make('active')
                            ->label('Status')
                            ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'danger'),
                        TextEntry::make('created')
                            ->label('Uploaded')
                            ->date()
                            ->placeholder('-'),
                        TextEntry::make('PDFLocation')
                            ->label('File')
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
            ->recordTitleAttribute('description')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('documentType.name')
                    ->label('Type')
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
                IconColumn::make('active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created')
                    ->label('Uploaded')
                    ->date()
                    ->sortable()
                    ->toggleable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Document')
                    ->icon('heroicon-o-plus')
                    ->visible(fn () => resolve(FeatureSettings::class)->users_can_add_documents)
                    ->form([
                        Select::make('documentTypeID')
                            ->label('Document Type')
                            ->options(fn () => AmsDocumentType::where('active', 1)->pluck('name', 'id'))
                            ->required()
                            ->searchable(),
                        TextInput::make('description')
                            ->label('Description')
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('PDFLocation')
                            ->label('Document')
                            ->disk('legacy')
                            ->directory('ssalute/documents')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
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

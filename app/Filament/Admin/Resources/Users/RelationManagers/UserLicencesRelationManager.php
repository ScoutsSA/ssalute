<?php

namespace App\Filament\Admin\Resources\Users\RelationManagers;

use App\Filament\Admin\Clusters\AMS\Resources\Licences\Schemas\LicenceForm;
use App\Filament\Admin\Resources\Users\RelationManagers\Concerns\FillsOwnerScopeOnCreate;
use App\Models\AmsLicenceInfo;
use App\Models\AmsLicenceType;
use App\Services\FileUrlService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserLicencesRelationManager extends RelationManager
{
    use FillsOwnerScopeOnCreate;

    protected static string $relationship = 'licenceInfos';

    protected static ?string $title = 'Licences';

    protected static ?string $modelLabel = 'licence';

    protected static ?string $pluralModelLabel = 'licences';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('chargeTypeID')
                    ->label('Licence Type')
                    ->relationship('licenceType', 'name')
                    ->getOptionLabelFromRecordUsing(fn (AmsLicenceType $record): string => "{$record->name} (#{$record->id})")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Get $get, Set $set) => LicenceForm::fillExpiryDate($get, $set)),
                TextInput::make('chargeNr')
                    ->label('Licence Number')
                    ->required()
                    ->maxLength(225),
                DatePicker::make('issueDate')
                    ->label('Issue Date')
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Get $get, Set $set) => LicenceForm::fillExpiryDate($get, $set)),
                DatePicker::make('expireDate')
                    ->label('Expiry Date')
                    ->required()
                    ->helperText('Filled in from the licence type validity when you pick a type and issue date. You can override it.'),
                Toggle::make('active')
                    ->label('Active')
                    ->default(true)
                    ->inline(false),
                FileUpload::make('PDFLocation')
                    ->label('Document')
                    ->disk('legacy')
                    ->directory('ssalute/licences')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->maxSize(51200),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('licenceType.name')
                    ->label('Licence Type')
                    ->state(fn (AmsLicenceInfo $record): ?string => $record->licenceType ? "{$record->licenceType->name} (#{$record->chargeTypeID})" : null)
                    ->placeholder('-'),
                TextEntry::make('chargeNr')
                    ->label('Licence Number')
                    ->placeholder('-'),
                TextEntry::make('issueDate')
                    ->label('Issue Date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('expireDate')
                    ->label('Expiry Date')
                    ->date()
                    ->placeholder('-'),
                IconEntry::make('active')
                    ->label('Active')
                    ->boolean(),
                TextEntry::make('PDFLocation')
                    ->label('Document')
                    ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                    ->openUrlInNewTab()
                    ->placeholder('-'),
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
            ->recordTitleAttribute('chargeNr')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('licenceType.name')
                    ->label('Licence Type')
                    ->state(fn (AmsLicenceInfo $record): ?string => $record->licenceType ? "{$record->licenceType->name} (#{$record->chargeTypeID})" : null)
                    ->placeholder('-')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('chargeNr')
                    ->label('Licence #')
                    ->searchable()
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
                    ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('issueDate', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(fn (array $data): array => $this->withOwnerScope($data)),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

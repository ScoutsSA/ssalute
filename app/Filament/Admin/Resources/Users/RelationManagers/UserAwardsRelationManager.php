<?php

namespace App\Filament\Admin\Resources\Users\RelationManagers;

use App\Filament\Admin\Resources\Users\RelationManagers\Concerns\FillsOwnerScopeOnCreate;
use App\Models\AmsAwardHeading;
use App\Models\AmsAwardType;
use App\Models\Award;
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
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserAwardsRelationManager extends RelationManager
{
    use FillsOwnerScopeOnCreate;

    protected static string $relationship = 'awards';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('awardTypeID')
                    ->label('Award Type')
                    ->relationship('awardType', 'name')
                    ->getOptionLabelFromRecordUsing(fn (AmsAwardType $record): string => "{$record->name} (#{$record->id})")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Set $set, ?int $state) => $set('awardHeadingID', AmsAwardType::find($state)?->headingID)),
                Select::make('awardHeadingID')
                    ->label('Award Heading')
                    ->relationship('heading', 'reason')
                    ->getOptionLabelFromRecordUsing(fn (AmsAwardHeading $record): string => "{$record->reason} (#{$record->id})")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText('Filled in from the award type. You can override it.'),
                DatePicker::make('awardDate')
                    ->label('Award Date')
                    ->required(),
                FileUpload::make('PDFLocation')
                    ->label('Document')
                    ->disk('legacy')
                    ->directory('ssalute/awards')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->maxSize(51200),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('awardType.name')
                    ->label('Award Type')
                    ->state(fn (Award $record): ?string => $record->awardType ? "{$record->awardType->name} (#{$record->awardTypeID})" : null)
                    ->placeholder('-'),
                TextEntry::make('heading.reason')
                    ->label('Heading')
                    ->state(fn (Award $record): ?string => $record->heading ? "{$record->heading->reason} (#{$record->awardHeadingID})" : null)
                    ->placeholder('-'),
                TextEntry::make('awardDate')
                    ->label('Award Date')
                    ->date(),
                TextEntry::make('PDFLocation')
                    ->label('Document')
                    ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                    ->openUrlInNewTab(),
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
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('awardType.name')
                    ->label('Award')
                    ->state(fn (Award $record): ?string => $record->awardType ? "{$record->awardType->name} (#{$record->awardTypeID})" : null)
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('heading.reason')
                    ->label('Heading')
                    ->state(fn (Award $record): ?string => $record->heading ? "{$record->heading->reason} (#{$record->awardHeadingID})" : null)
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('awardDate')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                IconColumn::make('active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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

<?php

namespace App\Filament\Admin\Resources\Users\RelationManagers;

use App\Filament\Admin\Resources\Users\RelationManagers\Concerns\FillsOwnerScopeOnCreate;
use App\Models\AmsDocumentType;
use App\Models\Document;
use App\Services\FileUrlService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserDocumentsRelationManager extends RelationManager
{
    use FillsOwnerScopeOnCreate;

    protected static string $relationship = 'documents';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('description')
                    ->label('Description')
                    ->required()
                    ->maxLength(255),
                Select::make('documentTypeID')
                    ->label('Document Type')
                    ->relationship('documentType', 'name')
                    ->getOptionLabelFromRecordUsing(fn (AmsDocumentType $record): string => "{$record->name} (#{$record->id})")
                    ->searchable()
                    ->preload()
                    ->required(),
                FileUpload::make('PDFLocation')
                    ->label('Document')
                    ->disk('legacy')
                    ->directory('ssalute/documents')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(51200)
                    ->required(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('description')
                    ->label('Description'),
                TextEntry::make('documentType.name')
                    ->label('Document Type')
                    ->state(fn (Document $record): ?string => $record->documentType ? "{$record->documentType->name} (#{$record->documentTypeID})" : null)
                    ->placeholder('-'),
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
            ->recordTitleAttribute('description')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('description')
                    ->label('Description')
                    ->searchable(),
                TextColumn::make('documentType.name')
                    ->label('Type')
                    ->state(fn (Document $record): ?string => $record->documentType ? "{$record->documentType->name} (#{$record->documentTypeID})" : null)
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('PDFLocation')
                    ->label('Document')
                    ->url(fn ($state) => $state ? app(FileUrlService::class)->url($state) : null)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true),
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

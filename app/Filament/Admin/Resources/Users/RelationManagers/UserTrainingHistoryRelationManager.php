<?php

namespace App\Filament\Admin\Resources\Users\RelationManagers;

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
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserTrainingHistoryRelationManager extends RelationManager
{
    protected static string $relationship = 'trainingHistory';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('courseName')
                    ->label('Course Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('courseNumber')
                    ->label('Course Number')
                    ->maxLength(255),
                Select::make('trainingTypeID')
                    ->label('Training Type')
                    ->relationship('trainingType', 'typeName'),
                DatePicker::make('completionDate')
                    ->label('Completion Date'),
                FileUpload::make('PDFLocation')
                    ->label('Certificate / Document')
                    ->disk('legacy')
                    ->directory('ssalute/training')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->maxSize(51200),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('courseName')
                    ->label('Course Name'),
                TextEntry::make('courseNumber')
                    ->label('Course Number'),
                TextEntry::make('trainingType.typeName')
                    ->label('Training Type'),
                TextEntry::make('completionDate')
                    ->label('Completion Date')
                    ->date(),
                IconEntry::make('validated')
                    ->label('Validated')
                    ->boolean(),
                TextEntry::make('validatedByUser.name')
                    ->label('Validated By'),
                TextEntry::make('validatedDate')
                    ->label('Validated On')
                    ->dateTime(),
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
            ->recordTitleAttribute('courseName')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('courseName')
                    ->label('Course')
                    ->searchable(),
                TextColumn::make('courseNumber')
                    ->label('Course #')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('trainingType.typeName')
                    ->label('Type')
                    ->toggleable(),
                TextColumn::make('completionDate')
                    ->label('Completed')
                    ->date()
                    ->sortable(),
                IconColumn::make('validated')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('validatedByUser.name')
                    ->label('Validated By')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
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

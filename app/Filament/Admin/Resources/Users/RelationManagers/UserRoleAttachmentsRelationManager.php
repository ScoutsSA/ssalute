<?php

namespace App\Filament\Admin\Resources\Users\RelationManagers;

use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUserType;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserRoleAttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'roleAttachments';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Role Assignment')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        Select::make('roleID')
                            ->label('Role Type')
                            ->options(fn () => SystemUserType::active()->orderBy('position')->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->columnSpanFull(),
                        Select::make('regionID')
                            ->label('Region')
                            ->options(fn () => Region::orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->placeholder('None'),
                        Select::make('districtID')
                            ->label('District')
                            ->options(fn () => District::orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->placeholder('None'),
                        Select::make('groupID')
                            ->label('Group')
                            ->options(fn () => Group::where('active', 1)->orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->placeholder('None'),
                        Toggle::make('defaultRole')
                            ->label('Default / Primary Role')
                            ->helperText('Set this as the user\'s default role.')
                            ->default(false),
                    ]),

                Section::make('Status')
                    ->collapsible()
                    ->columns(3)
                    ->schema([
                        Toggle::make('active')
                            ->label('Active')
                            ->default(true),
                        Toggle::make('retired')
                            ->label('Retired')
                            ->default(false),
                        Toggle::make('resigned')
                            ->label('Resigned')
                            ->default(false),
                        Toggle::make('suspended')
                            ->label('Suspended')
                            ->default(false),
                    ]),

                Textarea::make('creationNotes')
                    ->label('Notes')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Role')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('role.name')
                            ->label('Role Type'),
                        TextEntry::make('roleTypeName')
                            ->label('Level')
                            ->badge()
                            ->color('primary'),
                        TextEntry::make('region.name')
                            ->label('Region')
                            ->placeholder('-'),
                        TextEntry::make('district.name')
                            ->label('District')
                            ->placeholder('-'),
                        TextEntry::make('group.name')
                            ->label('Group')
                            ->placeholder('-'),
                        IconEntry::make('defaultRole')
                            ->label('Default Role')
                            ->boolean(),
                    ]),

                Section::make('Status')
                    ->collapsible()
                    ->columns(4)
                    ->schema([
                        IconEntry::make('active')
                            ->boolean(),
                        IconEntry::make('retired')
                            ->boolean(),
                        IconEntry::make('resigned')
                            ->boolean(),
                        IconEntry::make('suspended')
                            ->boolean(),
                    ]),

                TextEntry::make('creationNotes')
                    ->label('Notes')
                    ->placeholder('-')
                    ->columnSpanFull(),

                Fieldset::make('Audit')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created')
                            ->label('Created')
                            ->dateTime(),
                        TextEntry::make('createdBy.name')
                            ->label('Created By')
                            ->placeholder('-'),
                        TextEntry::make('modified')
                            ->label('Modified')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('modifiedBy.name')
                            ->label('Modified By')
                            ->placeholder('-'),
                    ]),
            ]);
    }

    public function getTabs(): array
    {
        return [
            'active' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('system_users_other_roles.active', true)),
            'inactive' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('system_users_other_roles.active', false)),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->deferFilters(false)
            ->deferColumnManager(false)
            ->columns([
                TextColumn::make('id')
                    ->label('Attachment ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('role.id')
                    ->label('Role ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('role.name')
                    ->description(fn ($record) => $record->defaultRole ? 'Primary Role' : '')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('roleTypeName')
                    ->label('Level')
                    ->badge()
                    ->color('primary')
                    ->toggleable(),
                TextColumn::make('roleAttachmentScopedLabel')
                    ->label('Scope')
                    ->toggleable(),
                IconColumn::make('defaultRole')
                    ->label('Default')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('retired')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('resigned')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('suspended')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('creationNotes')
                    ->label('Notes')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created')
                    ->label('Since')
                    ->date()
                    ->sortable()
                    ->toggleable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['created'] = now();
                        $data['createdby'] = auth()->id();

                        return $data;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('makePrimary')
                    ->label('Make Primary')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => ! $record->defaultRole && $record->active)
                    ->action(function ($record): void {
                        // Clear default on all other role attachments for this user
                        $this->getOwnerRecord()->roleAttachments()->update(['defaultRole' => 0]);

                        // Set this one as default
                        $record->update(['defaultRole' => 1]);

                        Notification::make()
                            ->title('Primary role updated')
                            ->success()
                            ->send();
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

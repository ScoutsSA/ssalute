<?php

namespace App\Filament\Admin\Resources\Roles\RelationManagers;

use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RoleRoleAttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'roleAttachments';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
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
            ->columns([
                TextColumn::make('id')
                    ->label('Attachment ID')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('user.id')
                    ->label('User ID')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->description(fn ($record) => $record->defaultRole ? 'Primary Role' : '')
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('defaultRole')
                    ->label('Is Default Role')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('roleAttachmentScopedLabel')
                    ->label('Role Scoped To')
                    ->toggleable(),
                IconColumn::make('user.active')
                    ->label('User is Active')
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
                    ->label('Creation Notes')
                    ->toggleable(),

                TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->description(fn ($record) => $record->created)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('modifiedBy.name')
                    ->label('Modified By')
                    ->description(fn ($record) => $record->modified)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->recordActions([
                ViewAction::make(),
                ViewAction::make('View User')
                    ->label('View User')
                    ->url(fn ($record) => UserResource::getUrl('view', ['record' => $record->userID])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}

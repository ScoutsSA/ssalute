<?php

namespace App\Filament\Admin\Clusters\Area\RelationManagers;

use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RoleAttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'roleAttachments';

    protected static ?string $title = 'Roles';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User & Role')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('User'),
                        TextEntry::make('role.name')
                            ->label('Role'),
                        TextEntry::make('roleTypeName')
                            ->label('Level')
                            ->badge()
                            ->color('primary'),
                        IconEntry::make('defaultRole')
                            ->label('Default Role')
                            ->boolean(),
                        TextEntry::make('region.name')
                            ->label('Region')
                            ->placeholder('-'),
                        TextEntry::make('district.name')
                            ->label('District')
                            ->placeholder('-'),
                        TextEntry::make('group.name')
                            ->label('Group')
                            ->placeholder('-'),
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
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.name')
                    ->label('User')
                    ->description(fn ($record) => $record->user?->username)
                    ->searchable(['first_name', 'surname', 'username', 'id'])
                    ->toggleable(),
                IconColumn::make('user.active')
                    ->label('User Active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('role.name')
                    ->label('Role')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('roleTypeName')
                    ->label('Level')
                    ->badge()
                    ->color('primary')
                    ->toggleable(),
                TextColumn::make('region.name')
                    ->label('Region')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('district.name')
                    ->label('District')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('group.name')
                    ->label('Group')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('defaultRole')
                    ->label('Default')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                TextColumn::make('created')
                    ->label('Since')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordUrl(fn ($record) => UserResource::getUrl('view', ['record' => $record->userID]))
            ->filters([
                SelectFilter::make('role')
                    ->relationship('role', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('district')
                    ->relationship('district', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('group')
                    ->relationship('group', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([])
            ->recordActions([
                ViewAction::make(),
                Action::make('view_user')
                    ->label('View User')
                    ->icon('heroicon-o-user')
                    ->url(fn ($record) => UserResource::getUrl('view', ['record' => $record->userID])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}

<?php

namespace App\Filament\Member\Resources\Profile\RelationManagers;

use App\Models\SystemUsersOtherRole;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserRolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roleAttachments';

    protected static ?string $title = 'Roles';

    protected static ?string $modelLabel = 'Role';

    protected static ?string $pluralModelLabel = 'Roles';

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

                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        if ($record->suspended) {
                            return 'Suspended';
                        }
                        if ($record->resigned) {
                            return 'Resigned';
                        }
                        if ($record->retired) {
                            return 'Retired';
                        }

                        return $record->active ? 'Active' : 'Inactive';
                    })
                    ->color(fn (string $state) => match ($state) {
                        'Active' => 'success',
                        'Retired' => 'warning',
                        'Resigned', 'Suspended' => 'danger',
                        default => 'gray',
                    }),

                TextEntry::make('creationNotes')
                    ->label('Notes')
                    ->placeholder('-')
                    ->columnSpanFull(),

                Fieldset::make('Dates')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created')
                            ->label('Created')
                            ->dateTime(),
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
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('role.name')
                    ->label('Role')
                    ->description(fn ($record) => $record->roleAttachmentScopedLabel)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('roleTypeName')
                    ->label('Level')
                    ->badge()
                    ->color('primary')
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
                TextColumn::make('created')
                    ->label('Since')
                    ->date()
                    ->sortable()
                    ->toggleable(),
            ])
            ->recordActions([
                Action::make('setDefault')
                    ->label('Set as Default')
                    ->icon(Heroicon::Star)
                    ->color('warning')
                    ->visible(fn (SystemUsersOtherRole $record) => $record->active && ! $record->defaultRole)
                    ->requiresConfirmation()
                    ->modalHeading('Change Default Role')
                    ->modalDescription(fn (SystemUsersOtherRole $record) => "Set \"{$record->role?->name}\" as your default role?")
                    ->action(function (SystemUsersOtherRole $record): void {
                        $user = auth()->user();

                        $user->activeRoleAttachments()
                            ->where('defaultRole', 1)
                            ->update(['defaultRole' => 0]);

                        $record->update(['defaultRole' => 1]);

                        Notification::make()
                            ->title('Default role updated')
                            ->success()
                            ->send();
                    }),
                ViewAction::make(),
            ]);
    }
}

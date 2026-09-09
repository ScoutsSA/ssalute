<?php

namespace App\Filament\Admin\Resources\Users;

use App\Filament\Admin\RelationManagers\AuditsRelationManager;
use App\Filament\Admin\Resources\Users\Pages\EditUser;
use App\Filament\Admin\Resources\Users\Pages\ListUsers;
use App\Filament\Admin\Resources\Users\Pages\ViewUser;
use App\Filament\Admin\Resources\Users\RelationManagers\UserAwardsRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserDocumentsRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserLicencesRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserMovesRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserPastServiceRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserPoliceClearancesRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserResignationsRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserRetirementsRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserRoleAttachmentsRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserSuspensionsRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserTerminationsRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserTrainingHistoryRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserWarrantsRelationManager;
use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use App\Filament\Admin\Resources\Users\Schemas\UserInfolist;
use App\Filament\Admin\Resources\Users\Tables\UsersTable;
use App\Models\SystemUser;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class UserResource extends Resource
{
    protected static ?string $model = SystemUser::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static ?string $recordTitleAttribute = 'username';
    protected static ?string $pluralLabel = 'Users';
    protected static string|UnitEnum|null $navigationGroup = 'Users';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    /**
     * Global search matches each word of the query against any of these, so "John Roux" finds a
     * member whose first name is John and surname is Roux. `name` is an accessor and cannot be
     * searched directly. The ID number is included because admins reconcile members by it.
     *
     * @return array<string>
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['first_name', 'surname', 'knownName', 'username', 'idNumber'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        /** @var SystemUser $record */
        return "{$record->name} (#{$record->id})";
    }

    /**
     * @return array<string, string>
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var SystemUser $record */
        return array_filter([
            'Username' => $record->username,
            'Region' => $record->homeRegion ? "{$record->homeRegion->name} (#{$record->assoc_to_region})" : null,
            'Group' => $record->homeGroup ? "{$record->homeGroup->name} (#{$record->assoc_to_group})" : null,
        ]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['homeRegion', 'homeGroup']);
    }

    public static function getRelations(): array
    {
        return [
            UserRoleAttachmentsRelationManager::class,
            UserWarrantsRelationManager::class,
            UserLicencesRelationManager::class,
            UserTrainingHistoryRelationManager::class,
            UserAwardsRelationManager::class,
            UserDocumentsRelationManager::class,
            UserPoliceClearancesRelationManager::class,
            UserPastServiceRelationManager::class,
            UserResignationsRelationManager::class,
            UserRetirementsRelationManager::class,
            UserSuspensionsRelationManager::class,
            UserTerminationsRelationManager::class,
            UserMovesRelationManager::class,
            AuditsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}

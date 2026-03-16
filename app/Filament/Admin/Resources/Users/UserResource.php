<?php

namespace App\Filament\Admin\Resources\Users;

use App\Filament\Admin\RelationManagers\AuditsRelationManager;
use App\Filament\Admin\Resources\Users\Pages\EditUser;
use App\Filament\Admin\Resources\Users\Pages\ListUsers;
use App\Filament\Admin\Resources\Users\Pages\ViewUser;
use App\Filament\Admin\Resources\Users\RelationManagers\UserAwardsRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserDocumentsRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserPastServiceRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserPoliceClearancesRelationManager;
use App\Filament\Admin\Resources\Users\RelationManagers\UserRoleAttachmentsRelationManager;
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

    public static function getRelations(): array
    {
        return [
            UserRoleAttachmentsRelationManager::class,
            UserWarrantsRelationManager::class,
            UserTrainingHistoryRelationManager::class,
            UserAwardsRelationManager::class,
            UserDocumentsRelationManager::class,
            UserPoliceClearancesRelationManager::class,
            UserPastServiceRelationManager::class,
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

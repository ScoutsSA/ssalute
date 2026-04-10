<?php

namespace App\Filament\General\Resources\Profile;

use App\Filament\General\Resources\Profile\Pages\EditProfile;
use App\Filament\General\Resources\Profile\Pages\MembershipCertificate;
use App\Filament\General\Resources\Profile\Pages\ViewProfile;
use App\Filament\General\Resources\Profile\RelationManagers\UserAwardsRelationManager;
use App\Filament\General\Resources\Profile\RelationManagers\UserDocumentsRelationManager;
use App\Filament\General\Resources\Profile\RelationManagers\UserLicencesRelationManager;
use App\Filament\General\Resources\Profile\RelationManagers\UserPastServiceRelationManager;
use App\Filament\General\Resources\Profile\RelationManagers\UserPoliceClearancesRelationManager;
use App\Filament\General\Resources\Profile\RelationManagers\UserRolesRelationManager;
use App\Filament\General\Resources\Profile\RelationManagers\UserTrainingHistoryRelationManager;
use App\Filament\General\Resources\Profile\RelationManagers\UserWarrantsRelationManager;
use App\Filament\General\Resources\Profile\Schemas\ProfileInfolist;
use App\Models\SystemUser;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProfileResource extends Resource
{
    protected static ?string $model = SystemUser::class;

    protected static bool $isScopedToTenant = false;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'profile';

    protected static ?string $label = 'Profile';

    protected static ?string $pluralLabel = 'Profile';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('id', auth()->id());
    }

    public static function getIndexUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null, bool $routeBindingAware = true): string
    {
        return static::getUrl('view', ['record' => auth()->id()], $isAbsolute, $panel, $tenant);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProfileInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            UserRolesRelationManager::class,
            UserWarrantsRelationManager::class,
            UserTrainingHistoryRelationManager::class,
            UserAwardsRelationManager::class,
            UserDocumentsRelationManager::class,
            UserPoliceClearancesRelationManager::class,
            UserLicencesRelationManager::class,
            UserPastServiceRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'view' => ViewProfile::route('/{record}'),
            'edit' => EditProfile::route('/{record}/edit'),
            'membership-certificate' => MembershipCertificate::route('/{record}/membership-certificate'),
        ];
    }
}

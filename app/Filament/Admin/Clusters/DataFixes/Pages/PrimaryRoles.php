<?php

namespace App\Filament\Admin\Clusters\DataFixes\Pages;

use App\Services\SystemFixes\EnsureEachUserHasOnlyOnePrimaryRole;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class PrimaryRoles extends FindingsPage
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::UserCircle;

    protected static ?string $navigationLabel = 'Primary Roles';

    protected static ?string $title = 'Members whose primary role needs reconciling';

    protected static ?int $navigationSort = 4;

    public static function fix(): string
    {
        return EnsureEachUserHasOnlyOnePrimaryRole::class;
    }

    protected static function subject(): string
    {
        return 'members';
    }
}

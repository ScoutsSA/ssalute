<?php

namespace App\Filament\Admin\Clusters\DataFixes\Pages;

use App\Services\SystemFixes\EnsureYouthMemberIdsAreInSync;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class YouthMemberIds extends FindingsPage
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::Identification;

    protected static ?string $navigationLabel = 'Youth Member Ids';

    protected static ?string $title = 'Youth records whose member ids disagree';

    protected static ?int $navigationSort = 3;

    public static function fix(): string
    {
        return EnsureYouthMemberIdsAreInSync::class;
    }

    protected static function subject(): string
    {
        return 'youth records';
    }
}

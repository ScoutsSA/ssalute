<?php

namespace App\Filament\Admin\Clusters\DataFixes\Pages;

use App\Services\SystemFixes\RepairLegacyEntityEncoding;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class LegacyEntityEncoding extends FindingsPage
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::CodeBracketSquare;

    protected static ?string $navigationLabel = 'Legacy Encoding';

    protected static ?string $title = 'Legacy text showing leftover encoding';

    protected static ?int $navigationSort = 5;

    public static function fix(): string
    {
        return RepairLegacyEntityEncoding::class;
    }

    protected static function subject(): string
    {
        return 'values with leftover encoding';
    }
}

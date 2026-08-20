<?php

namespace App\Filament\Admin\Clusters\DataFixes\Pages;

use App\Services\SystemFixes\EnsureLegacyValuesAreCanonical;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class LegacyValues extends FindingsPage
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::Sparkles;

    protected static ?string $navigationLabel = 'Legacy Values';

    protected static ?string $title = 'Legacy values needing review';

    protected static ?int $navigationSort = 1;

    public static function fix(): string
    {
        return EnsureLegacyValuesAreCanonical::class;
    }

    protected static function subject(): string
    {
        return 'unrecognised values';
    }
}

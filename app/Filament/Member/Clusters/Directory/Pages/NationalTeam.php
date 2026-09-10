<?php

namespace App\Filament\Member\Clusters\Directory\Pages;

use App\Enums\DirectoryLevel;
use App\Models\SystemUsersOtherRole;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class NationalTeam extends DirectoryTeamPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Flag;

    protected static ?int $navigationSort = 1;

    /**
     * Legacy never shows a cell number for these national office holders (National
     * Administrator, CEO, Chief Commissioner, Chief Scout), whatever the member's own settings.
     *
     * @var array<int>
     */
    private const array ROLE_IDS_WITHOUT_CELL_NUMBER = [50, 51, 218, 219];

    protected static function level(): DirectoryLevel
    {
        return DirectoryLevel::National;
    }

    protected function scopeFilters(SystemUsersOtherRole $tenant): array
    {
        return [];
    }

    protected function scopeColumns(): array
    {
        return [];
    }

    protected function cellNumberHiddenFor(SystemUsersOtherRole $record): bool
    {
        return in_array($record->roleID, self::ROLE_IDS_WITHOUT_CELL_NUMBER, true);
    }
}

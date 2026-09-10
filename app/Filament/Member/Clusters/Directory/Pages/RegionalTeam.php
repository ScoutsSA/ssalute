<?php

namespace App\Filament\Member\Clusters\Directory\Pages;

use App\Enums\DirectoryLevel;
use App\Models\SystemUsersOtherRole;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class RegionalTeam extends DirectoryTeamPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::GlobeEuropeAfrica;

    protected static ?int $navigationSort = 2;

    protected static function level(): DirectoryLevel
    {
        return DirectoryLevel::Regional;
    }

    protected function scopeFilters(SystemUsersOtherRole $tenant): array
    {
        return [
            SelectFilter::make('region')
                ->label('Region')
                ->relationship('region', 'name', fn (Builder $query): Builder => $query->where('active', 1)->orderBy('position'))
                ->default($tenant->effectiveRegionId())
                ->searchable()
                ->preload(),
        ];
    }

    protected function scopeColumns(): array
    {
        return [
            TextColumn::make('region.name')
                ->label('Region')
                ->placeholder('-')
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    protected function scopeRelations(): array
    {
        return ['region'];
    }
}

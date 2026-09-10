<?php

namespace App\Filament\Member\Clusters\Directory\Pages;

use App\Enums\DirectoryLevel;
use App\Models\Region;
use App\Models\SystemUsersOtherRole;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class DistrictTeam extends DirectoryTeamPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Map;

    protected static ?int $navigationSort = 3;

    protected static function level(): DirectoryLevel
    {
        return DirectoryLevel::District;
    }

    protected function scopeFilters(SystemUsersOtherRole $tenant): array
    {
        return [
            SelectFilter::make('district')
                ->label('District')
                ->relationship('district', 'name', fn (Builder $query): Builder => $query->where('active', 1)->orderBy('name'))
                ->default($tenant->effectiveDistrictId())
                ->searchable()
                ->preload(),
            SelectFilter::make('region')
                ->label('Region')
                ->options(fn () => Region::query()->where('active', 1)->orderBy('position')->pluck('name', 'id'))
                ->query(fn (Builder $query, array $data): Builder => $query->when(
                    filled($data['value'] ?? null),
                    fn (Builder $query): Builder => $query->whereHas('district', fn (Builder $query): Builder => $query->where('regionID', $data['value'])),
                ))
                ->searchable(),
        ];
    }

    protected function scopeColumns(): array
    {
        return [
            TextColumn::make('district.name')
                ->label('District')
                ->placeholder('-')
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('district.region.name')
                ->label('Region')
                ->placeholder('-')
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    protected function scopeRelations(): array
    {
        return ['district.region'];
    }
}

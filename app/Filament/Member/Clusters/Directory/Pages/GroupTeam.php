<?php

namespace App\Filament\Member\Clusters\Directory\Pages;

use App\Enums\DirectoryLevel;
use App\Models\District;
use App\Models\SystemUsersOtherRole;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Group teams list adult leader roles only (groupRole and adultLeaderRole flags), matching the
 * legacy "group adult leaders" pages rather than the legacy "my group" page, which listed every
 * role in the group including youth and parents.
 */
class GroupTeam extends DirectoryTeamPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;

    protected static ?int $navigationSort = 4;

    protected static function level(): DirectoryLevel
    {
        return DirectoryLevel::Group;
    }

    protected function scopeFilters(SystemUsersOtherRole $tenant): array
    {
        return [
            SelectFilter::make('group')
                ->label('Group')
                ->relationship('group', 'name', fn (Builder $query): Builder => $query->where('active', 1)->orderBy('name'))
                ->default($tenant->effectiveGroupId())
                ->searchable(),
            SelectFilter::make('district')
                ->label('District')
                ->options(fn () => District::query()->where('active', 1)->orderBy('name')->pluck('name', 'id'))
                ->query(fn (Builder $query, array $data): Builder => $query->when(
                    filled($data['value'] ?? null),
                    fn (Builder $query): Builder => $query->whereHas('group', fn (Builder $query): Builder => $query->where('assoc_to_district', $data['value'])),
                ))
                ->searchable(),
        ];
    }

    protected function scopeColumns(): array
    {
        return [
            TextColumn::make('group.name')
                ->label('Group')
                ->placeholder('-')
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('group.district.name')
                ->label('District')
                ->placeholder('-')
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('group.region.name')
                ->label('Region')
                ->placeholder('-')
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    protected function scopeRelations(): array
    {
        return ['group.district', 'group.region'];
    }
}

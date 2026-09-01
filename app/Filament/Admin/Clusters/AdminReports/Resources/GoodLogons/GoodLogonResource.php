<?php

namespace App\Filament\Admin\Clusters\AdminReports\Resources\GoodLogons;

use App\Filament\Admin\Clusters\AdminReports\AdminReportsCluster;
use App\Filament\Admin\Clusters\AdminReports\Resources\GoodLogons\Pages\ListGoodLogons;
use App\Listeners\RecordSuccessfulLogin;
use App\Models\AdminGoodLogon;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GoodLogonResource extends Resource
{
    protected static ?string $model = AdminGoodLogon::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowRightEndOnRectangle;

    protected static ?string $navigationLabel = 'Logins';

    protected static ?string $modelLabel = 'login';

    protected static ?string $pluralModelLabel = 'logins';

    protected static ?string $slug = 'logins';

    protected static ?string $cluster = AdminReportsCluster::class;

    protected static ?int $navigationSort = 20;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['role', 'group', 'district', 'region']))
            ->defaultPaginationPageOption(25)
            ->description('Database table: admin_good_logons. Every successful login: legacy Scouts Digital sessions write here from its logon handling, and Ssalute sessions are recorded by the login listener.')
            ->defaultSort('date', 'desc')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('username')->searchable()->sortable(),
                TextColumn::make('date')->dateTime('Y/m/d H:i')->sortable(),
                TextColumn::make('fromSD')
                    ->label('Source')
                    ->badge()
                    ->formatStateUsing(fn (?int $state): string => match ((int) $state) {
                        RecordSuccessfulLogin::FROM_SSALUTE => 'Ssalute',
                        default => 'Scouts Digital',
                    })
                    ->color(fn (?int $state): string => (int) $state === RecordSuccessfulLogin::FROM_SSALUTE ? 'success' : 'gray')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('ip')->label('IP')->searchable()->toggleable(),
                TextColumn::make('role.name')
                    ->label('Role')
                    ->state(fn (AdminGoodLogon $record): string => $record->role ? "{$record->role->name} (#{$record->roleID})" : '-')
                    ->toggleable(),
                TextColumn::make('group.name')
                    ->label('Group')
                    ->state(fn (AdminGoodLogon $record): string => $record->group ? "{$record->group->name} (#{$record->groupID})" : '-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('district.name')
                    ->label('District')
                    ->state(fn (AdminGoodLogon $record): string => $record->district ? "{$record->district->name} (#{$record->districtID})" : '-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('region.name')
                    ->label('Region')
                    ->state(fn (AdminGoodLogon $record): string => $record->region ? "{$record->region->name} (#{$record->regionID})" : '-')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('usingMobile')->label('Mobile')->boolean()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('userAgent')->label('User Agent')->limit(60)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('countryID')->label('Country ID')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('date')
                    ->schema([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['from'] ?? null, fn (Builder $query, string $from) => $query->whereDate('date', '>=', $from))
                        ->when($data['until'] ?? null, fn (Builder $query, string $until) => $query->whereDate('date', '<=', $until))),
                SelectFilter::make('fromSD')
                    ->label('Source')
                    ->options([
                        RecordSuccessfulLogin::FROM_SSALUTE => 'Ssalute',
                        2 => 'Scouts Digital',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGoodLogons::route('/'),
        ];
    }
}

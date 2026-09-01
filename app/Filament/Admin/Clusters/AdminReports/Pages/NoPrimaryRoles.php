<?php

namespace App\Filament\Admin\Clusters\AdminReports\Pages;

use App\Filament\Admin\Clusters\AdminReports\AdminReportsCluster;
use App\Filament\Admin\Clusters\DataFixes\Pages\PrimaryRoles;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Models\SystemUser;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Active members with no active primary role, following the legacy report's
 * definition. The nightly primary-role fix promotes a primary for anybody who
 * still holds an active role, so what remains here is mostly members with no
 * active role at all, which no automated fix will ever repair.
 */
class NoPrimaryRoles extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $cluster = AdminReportsCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserMinus;

    protected static ?string $navigationLabel = 'No Primary Roles';

    protected static ?string $title = 'Members without a primary role';

    protected static ?int $navigationSort = 30;

    protected string $view = 'filament.admin.clusters.admin-reports.report';

    protected Width|string|null $maxContentWidth = Width::Full;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => SystemUser::query()
                ->where('active', 1)
                ->whereDoesntHave('roleAttachments', fn (Builder $query) => $query
                    ->where('defaultRole', 1)
                    ->where('active', 1))
                ->withCount(['roleAttachments as active_roles_count' => fn (Builder $query) => $query->where('active', 1)]))
            ->defaultPaginationPageOption(25)
            ->description('Active members with no active primary role. Members who still hold an active role are promoted automatically by the nightly primary-role fix (see the Primary Roles worklist); the rest have no active role at all and need a human decision.')
            ->columns([
                TextColumn::make('name')
                    ->label('Member')
                    ->state(fn (SystemUser $record): string => "{$record->name} (#{$record->id})")
                    ->searchable(['first_name', 'surname', 'username'])
                    ->url(fn (SystemUser $record): string => UserResource::getUrl('view', ['record' => $record])),
                TextColumn::make('username')->searchable()->toggleable(),
                TextColumn::make('active_roles_count')
                    ->label('Active Roles')
                    ->sortable(),
                TextColumn::make('homeRegion.name')
                    ->label('Region')
                    ->state(fn (SystemUser $record): string => $record->homeRegion ? "{$record->homeRegion->name} (#{$record->assoc_to_region})" : '-')
                    ->toggleable(),
                TextColumn::make('homeDistrict.name')
                    ->label('District')
                    ->state(fn (SystemUser $record): string => $record->homeDistrict ? "{$record->homeDistrict->name} (#{$record->assoc_to_district})" : '-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('homeGroup.name')
                    ->label('Group')
                    ->state(fn (SystemUser $record): string => $record->homeGroup ? "{$record->homeGroup->name} (#{$record->assoc_to_group})" : '-')
                    ->toggleable(),
                TextColumn::make('created')->dateTime('Y/m/d H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('primaryRolesWorklist')
                ->label('Primary Roles worklist')
                ->icon(Heroicon::WrenchScrewdriver)
                ->url(PrimaryRoles::getUrl()),
        ];
    }
}

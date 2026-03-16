<?php

namespace App\Filament\Admin\Clusters\Settings\Pages;

use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Filament\Concerns\AuditsSettings;
use App\Models\SystemUser;
use App\Models\SystemUserType;
use App\Settings\GeneralSettings;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageGeneralSettings extends SettingsPage
{
    use AuditsSettings;

    protected static string|null|BackedEnum $navigationIcon = Heroicon::Cog8Tooth;

    protected static string $settings = GeneralSettings::class;

    protected static ?string $navigationLabel = 'General Settings';

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 2;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make()
                    ->columns(1)
                    ->persistTabInQueryString()
                    ->columnSpanFull()
                    ->schema(
                        [
                            Tab::make('BackOffice Panel')
                                ->schema([
                                    Select::make('super_user_admin_list')
                                        ->label('Super User Admin List')
                                        ->multiple()
                                        ->searchable()
                                        ->options([])
                                        ->getSearchResultsUsing(fn (string $search): array => SystemUser::query()
                                            ->where('username', 'like', "{$search}%")
                                            ->orWhere('id', '=', $search)
                                            ->limit(50)
                                            ->get()
                                            ->mapWithKeys(fn ($user) => [
                                                $user->id => "{$user->username} [{$user->name} - {$user->id}]",
                                            ])
                                            ->toArray())
                                        ->getOptionLabelsUsing(fn (array $values): array => SystemUser::whereIn('id', $values)
                                            ->get()
                                            ->mapWithKeys(fn ($user) => [
                                                $user->id => "{$user->username} [{$user->name} - {$user->id}]",
                                            ])
                                            ->toArray()
                                        )
                                        ->helperText('List of users who should have super admin access to the BackOffice panel. Search via username or ID.')
                                        ->columnSpanFull(),
                                ]),

                            Tab::make('National Support')
                                ->schema([
                                    Select::make('national_support_role_ids')
                                        ->label('National Adult Support Roles')
                                        ->multiple()
                                        ->options(fn () => SystemUserType::active()->orderBy('position')->pluck('name', 'id'))
                                        ->helperText('Users who hold any of these roles (with an active role attachment) will be considered part of the National Adult Support Team. They will receive issue reports escalated to the national level.')
                                        ->columnSpanFull(),
                                ]),

                            Tab::make('System Issue Support')
                                ->schema([
                                    Toggle::make('system_issue_support_enabled')
                                        ->label('Enable System Issue Reporting')
                                        ->helperText('When enabled, users will see a "Report System Issue" option in the user menu.')
                                        ->live()
                                        ->columnSpanFull(),
                                    Select::make('system_issue_support_user_ids')
                                        ->label('System Issue Support Users')
                                        ->multiple()
                                        ->searchable()
                                        ->options([])
                                        ->getSearchResultsUsing(fn (string $search): array => SystemUser::query()
                                            ->where('username', 'like', "{$search}%")
                                            ->orWhere('id', '=', $search)
                                            ->limit(50)
                                            ->get()
                                            ->mapWithKeys(fn ($user) => [
                                                $user->id => "{$user->username} [{$user->name} - {$user->id}]",
                                            ])
                                            ->toArray())
                                        ->getOptionLabelsUsing(fn (array $values): array => SystemUser::whereIn('id', $values)
                                            ->get()
                                            ->mapWithKeys(fn ($user) => [
                                                $user->id => "{$user->username} [{$user->name} - {$user->id}]",
                                            ])
                                            ->toArray()
                                        )
                                        ->helperText('Users who will receive system issue reports submitted via the general panel user menu. Search via username or ID.')
                                        ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('system_issue_support_enabled'))
                                        ->columnSpanFull(),
                                ]),

                            Tab::make('Next In Line')
                                ->schema([
                                    TextEntry::make('next_in_line_info')
                                        ->hiddenLabel()
                                        ->state('These options determine who receives issue report emails. Based on the reporter\'s role, we pick the most relevant Group/District/Regional contact. If no match is found, the National role is used as a catch-all.')
                                        ->columnSpanFull(),
                                    TextEntry::make('next_in_line_note')
                                        ->hiddenLabel()
                                        ->state('This should ideally be an individual role, not a group. This is the first person who will be directly contacted to assist the user.')
                                        ->columnSpanFull(),
                                    Select::make('next_in_line_role_national')
                                        ->label('National Role (and Catch All)')
                                        ->options(fn () => SystemUserType::active()->orderBy('position')->pluck('name', 'id'))
                                        ->helperText("We'd recommend your National Chair for Adult Support")
                                        ->searchable()
                                        ->columnSpanFull(),
                                    Select::make('next_in_line_role_regional')
                                        ->label('Regional Role')
                                        ->options(fn () => SystemUserType::active()->orderBy('position')->pluck('name', 'id'))
                                        ->helperText("We'd recommend your Regional Team Coordinator: Adult Support")
                                        ->searchable()
                                        ->columnSpanFull(),
                                    Select::make('next_in_line_role_district')
                                        ->label('District Role')
                                        ->options(fn () => SystemUserType::active()->orderBy('position')->pluck('name', 'id'))
                                        ->helperText("We'd recommend your District Commissioner")
                                        ->searchable()
                                        ->columnSpanFull(),
                                    Select::make('next_in_line_role_group')
                                        ->label('Group Role')
                                        ->options(fn () => SystemUserType::active()->orderBy('position')->pluck('name', 'id'))
                                        ->helperText("We'd recommend your Scout Group Leader")
                                        ->searchable()
                                        ->columnSpanFull(),
                                ]),
                        ]),
            ]);
    }
}

<?php

namespace App\Filament\Admin\Clusters\Settings\Pages;

use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Filament\Concerns\AuditsSettings;
use App\Models\SystemUser;
use App\Models\SystemUserType;
use App\Settings\FeatureSettings;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageFeatureSettings extends SettingsPage
{
    use AuditsSettings;

    protected static string|null|BackedEnum $navigationIcon = Heroicon::Flag;

    protected static string $settings = FeatureSettings::class;

    protected static ?string $navigationLabel = 'Feature Flags';

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 1;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                Tabs::make('Feature Flags')
                    ->persistTabInQueryString()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('User Settings')
                            ->icon(Heroicon::User)
                            ->schema([
                                Section::make('Profile')
                                    ->description('Control what users can do with their profile.')
                                    ->collapsible()
                                    ->schema([
                                        Toggle::make('users_can_edit_profiles')
                                            ->label('Users can edit profiles')
                                            ->helperText('Allow users to edit their own profile information.'),
                                        Toggle::make('users_can_add_past_training')
                                            ->label('Users can add past training')
                                            ->helperText('Allow users to add past training records.'),
                                        Section::make('Files')
                                            ->collapsible()
                                            ->schema([
                                                Toggle::make('users_can_upload_profile_photo')
                                                    ->label('Users can upload profile photo')
                                                    ->helperText('Allow users to upload or change their profile photo.'),
                                                Toggle::make('users_can_add_documents')
                                                    ->label('Users can add documents')
                                                    ->helperText('Allow users to add documents to their profile.'),
                                                Toggle::make('users_can_add_past_service')
                                                    ->label('Users can add past service')
                                                    ->helperText('Allow users to add past service records.'),
                                                Toggle::make('users_can_add_awards')
                                                    ->label('Users can add awards')
                                                    ->helperText('Allow users to add award records.'),
                                            ]),
                                    ]),
                                Section::make('General Navigation')
                                    ->collapsible()
                                    ->schema([
                                        Toggle::make('users_can_browse_areas')
                                            ->label('Users can browse areas')
                                            ->helperText('Allow users to browse Regions, Districts, and Groups.'),
                                        Toggle::make('users_can_view_notifications')
                                            ->label('Users can view notifications')
                                            ->helperText('Show legacy notifications on the dashboard and notifications page.'),
                                        Toggle::make('users_can_report_issues')
                                            ->label('Users can report issues')
                                            ->helperText('Allow users to report issues and request missing warrants.'),
                                        Toggle::make('users_can_view_audit_log')
                                            ->label('Users can view audit log')
                                            ->helperText('Allow users to view the audit log of changes made to their data.'),
                                    ]),
                                Section::make('Membership Certificate')
                                    ->collapsible()
                                    ->schema([
                                        Toggle::make('users_can_generate_membership_certificate')
                                            ->label('Users can generate membership certificate')
                                            ->helperText('Allow members to generate and share a verified membership certificate from their profile.')
                                            ->live(),
                                        Select::make('membership_certificate_eligible_role_ids')
                                            ->label('Eligible Roles for Certificate Generation')
                                            ->multiple()
                                            ->options(fn () => SystemUserType::active()->orderBy('position')->pluck('name', 'id'))
                                            ->helperText('Only users holding at least one of these active roles can generate a membership certificate. Leave blank to allow anyone irrespective of their role')
                                            ->visible(fn (Get $get): bool => $get('users_can_generate_membership_certificate'))
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('System Issue Support')
                            ->icon(Heroicon::ExclamationTriangle)
                            ->schema([
                                Section::make('System Issue Support')
                                    ->collapsible()
                                    ->schema([
                                        Toggle::make('system_issue_support_enabled')
                                            ->label('Enable System Issue Reporting')
                                            ->helperText('When enabled, users will see a "Report System Issue" option in the user menu.')
                                            ->live(),
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
                                            ->visible(fn (Get $get): bool => $get('system_issue_support_enabled'))
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}

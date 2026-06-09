<?php

namespace App\Filament\Admin\Clusters\Settings\Pages;

use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Filament\Shared\Concerns\AuditsSettings;
use App\Settings\DataFixesSettings;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageDataFixesSettings extends SettingsPage
{
    use AuditsSettings;

    protected static string|null|BackedEnum $navigationIcon = Heroicon::Wrench;

    protected static string $settings = DataFixesSettings::class;

    protected static ?string $navigationLabel = 'Data Fixes';

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 4;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                Tabs::make('Data Fixes')
                    ->persistTabInQueryString()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Notifications')
                            ->icon(Heroicon::Bell)
                            ->schema([
                                Toggle::make('notifications_enabled')
                                    ->label('Send notifications')
                                    ->helperText('Master switch. When off, no fix sends notifications regardless of its own setting.')
                                    ->live(),
                                TextInput::make('slack_webhook_url')
                                    ->label('Slack Webhook URL')
                                    ->url()
                                    ->password()
                                    ->revealable()
                                    ->helperText('Incoming webhook URL for the channel that should receive data fix alerts.'),
                            ]),
                        Tab::make('Primary Role')
                            ->icon(Heroicon::UserCircle)
                            ->schema([
                                Toggle::make('ensure_each_user_has_only_one_primary_role_enabled')
                                    ->label('Run this fix')
                                    ->helperText('Ensures a deactivated role is never primary. Users with active roles get exactly one active primary; users with no active roles are left with no primary.'),
                                Toggle::make('ensure_each_user_has_only_one_primary_role_notifications')
                                    ->label('Notify on changes')
                                    ->helperText('Only applies while the master notifications switch is on.')
                                    ->disabled(fn (Get $get): bool => ! $get('notifications_enabled'))
                                    ->dehydrated(),
                            ]),
                    ]),
            ]);
    }
}
